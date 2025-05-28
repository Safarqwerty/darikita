<?php

namespace App\Http\Controllers;

use App\Models\PemberiDonasi;
use App\Models\Donasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemberiDonasiController extends Controller
{
    /**
     * Display a listing of the donations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // For admin, show all donations
        if (Auth::user()->hasRole('admin')) {
            $pemberiDonasis = PemberiDonasi::with(['user', 'donasi'])->orderBy('tanggal_donasi', 'desc')->paginate(10);
        } else {
            // For regular users, show only their donations
            $pemberiDonasis = PemberiDonasi::with(['donasi'])
                ->where('user_id', Auth::id())
                ->orderBy('tanggal_donasi', 'desc')
                ->paginate(10);
        }

        return view('admin.pemberi-donasi.index', compact('pemberiDonasis'));
    }

    /**
     * Show the form for creating a new donation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Changed from 'active' to 'open' to match the migration schema
        $donasis = Donasi::where('status', 'open')->get();
        return view('admin.pemberi-donasi.create', compact('donasis'));
    }

    /**
     * Store a newly created donation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'donasi_id' => 'required|exists:donasis,id',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_donasi' => 'required|date',
        ]);

        // Mulai transaksi database untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            // Simpan data donasi dari pemberi
            PemberiDonasi::create([
                'user_id' => Auth::id(),
                'donasi_id' => $request->donasi_id,
                'jumlah' => $request->jumlah,
                'tanggal_donasi' => $request->tanggal_donasi,
            ]);

            // Update jumlah dana_terkumpul pada program donasi
            $donasi = Donasi::findOrFail($request->donasi_id);
            $donasi->dana_terkumpul = $donasi->dana_terkumpul + $request->jumlah;

            // Jika dana sudah mencapai/melebihi target, ubah status menjadi closed
            if ($donasi->dana_terkumpul >= $donasi->target_dana) {
                $donasi->status = 'closed';
            }

            $donasi->save();

            // Commit transaksi jika semua proses berhasil
            DB::commit();

            return redirect()->route('pemberi-donasi.index')
                ->with('success', 'Donasi berhasil dibuat, terima kasih atas kontribusi Anda!');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses donasi. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Display the specified donation.
     *
     * @param  \App\Models\PemberiDonasi  $pemberiDonasi
     * @return \Illuminate\Http\Response
     */
    public function show(PemberiDonasi $pemberiDonasi)
    {
        // Only admin or the donation owner can see the details
        if (Auth::user()->hasRole('admin') || $pemberiDonasi->user_id === Auth::id()) {
            return view('admin.pemberi-donasi.show', compact('pemberiDonasi'));
        }

        return redirect()->route('pemberi-donasi.index')
            ->with('error', 'Anda tidak memiliki akses untuk melihat donasi ini.');
    }

    /**
     * Show the form for editing the specified donation.
     * Only admin can edit donations.
     *
     * @param  \App\Models\PemberiDonasi  $pemberiDonasi
     * @return \Illuminate\Http\Response
     */
    public function edit(PemberiDonasi $pemberiDonasi)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('pemberi-donasi.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit donasi.');
        }

        $donasis = Donasi::all();
        $users = User::all();

        return view('admin.pemberi-donasi.edit', compact('pemberiDonasi', 'donasis', 'users'));
    }

    /**
     * Update the specified donation in storage.
     * Only admin can update donations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PemberiDonasi  $pemberiDonasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PemberiDonasi $pemberiDonasi)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('pemberi-donasi.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah donasi.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'donasi_id' => 'required|exists:donasis,id',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_donasi' => 'required|date',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Menyimpan data sebelum diupdate
            $oldDonasiId = $pemberiDonasi->donasi_id;
            $oldJumlah = $pemberiDonasi->jumlah;
            $newDonasiId = $request->donasi_id;
            $newJumlah = $request->jumlah;

            // Update data donasi
            $pemberiDonasi->update($request->all());

            // Jika donasi dipindahkan ke program lain atau jumlah diubah
            if ($oldDonasiId != $newDonasiId || $oldJumlah != $newJumlah) {
                // Kurangi jumlah dana dari program lama
                if ($oldDonasiId != $newDonasiId) {
                    $oldDonasi = Donasi::findOrFail($oldDonasiId);
                    $oldDonasi->dana_terkumpul = max(0, $oldDonasi->dana_terkumpul - $oldJumlah);

                    // Periksa apakah status perlu diubah
                    if ($oldDonasi->dana_terkumpul < $oldDonasi->target_dana && $oldDonasi->tanggal_selesai >= now()->format('Y-m-d')) {
                        $oldDonasi->status = 'open';
                    }

                    $oldDonasi->save();

                    // Tambahkan ke program baru
                    $newDonasi = Donasi::findOrFail($newDonasiId);
                    $newDonasi->dana_terkumpul += $newJumlah;

                    // Periksa apakah target sudah tercapai
                    if ($newDonasi->dana_terkumpul >= $newDonasi->target_dana) {
                        $newDonasi->status = 'closed';
                    }

                    $newDonasi->save();
                } else {
                    // Jika hanya jumlah yang berubah pada program yang sama
                    $donasi = Donasi::findOrFail($oldDonasiId);
                    $donasi->dana_terkumpul = $donasi->dana_terkumpul - $oldJumlah + $newJumlah;

                    // Periksa apakah target sudah tercapai atau belum
                    if ($donasi->dana_terkumpul >= $donasi->target_dana) {
                        $donasi->status = 'closed';
                    } elseif ($donasi->tanggal_selesai >= now()->format('Y-m-d')) {
                        $donasi->status = 'open';
                    }

                    $donasi->save();
                }
            }

            // Commit transaksi
            DB::commit();

            return redirect()->route('pemberi-donasi.index')
                ->with('success', 'Data donasi berhasil diperbarui.');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui donasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified donation from storage.
     * Only admin can delete donations.
     *
     * @param  \App\Models\PemberiDonasi  $pemberiDonasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(PemberiDonasi $pemberiDonasi)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('pemberi-donasi.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus donasi.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Ambil informasi donasi sebelum dihapus
            $donasiId = $pemberiDonasi->donasi_id;
            $jumlahDonasi = $pemberiDonasi->jumlah;

            // Hapus data donasi
            $pemberiDonasi->delete();

            // Kurangi jumlah dana terkumpul pada program donasi
            $donasi = Donasi::findOrFail($donasiId);
            $donasi->dana_terkumpul = max(0, $donasi->dana_terkumpul - $jumlahDonasi);

            // Jika target belum tercapai, pastikan status masih open
            if ($donasi->dana_terkumpul < $donasi->target_dana && $donasi->tanggal_selesai >= now()->format('Y-m-d')) {
                $donasi->status = 'open';
            }

            $donasi->save();

            // Commit transaksi
            DB::commit();

            return redirect()->route('pemberi-donasi.index')
                ->with('success', 'Data donasi berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus donasi.');
        }
    }

    /**
     * Display a report of donations.
     * Only accessible to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('pemberi-donasi.index')
                ->with('error', 'Anda tidak memiliki izin untuk melihat laporan.');
        }

        // Get total donations per campaign
        $donationsByProgram = PemberiDonasi::selectRaw('donasi_id, SUM(jumlah) as total_donation')
            ->with('donasi')
            ->groupBy('donasi_id')
            ->get();

        // Get total donations per month
        $donationsByMonth = PemberiDonasi::selectRaw('MONTH(tanggal_donasi) as month, YEAR(tanggal_donasi) as year, SUM(jumlah) as total_donation')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.pemberi-donasi.report', compact('donationsByProgram', 'donationsByMonth'));
    }
}
