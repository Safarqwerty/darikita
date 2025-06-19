<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\DaftarKegiatan;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    public function Kegiatan(Request $request)
    {
        $query = Kegiatan::query()
            ->where('status', 'publish') // Hanya tampilkan kegiatan yang sudah dipublish
            ->orderBy('tanggal_mulai_kegiatan', 'asc');

        // Filter berdasarkan pencarian nama atau deskripsi
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_kegiatan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi_kegiatan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter berdasarkan jenis kegiatan
        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        // Filter berdasarkan provinsi
        if ($request->filled('provinsi')) {
            $query->where('provinsi', 'like', '%' . $request->provinsi . '%');
        }

        // Paginasi
        $kegiatans = $query->paginate(12);

        // Mendapatkan opsi jenis kegiatan yang unik dari database
        $jenisKegiatanOptions = Kegiatan::where('status', 'publish')
            ->distinct()
            ->pluck('jenis_kegiatan')
            ->sort()
            ->values();

        return view('public.kegiatan.index', compact('kegiatans', 'jenisKegiatanOptions'));
    }

    /**
     * Halaman beranda/welcome
     */
    public function welcome()
    {
        $openDonations = Donasi::where('status', 'open')
            ->whereDate('tanggal_selesai', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        foreach ($openDonations as $donasi) {
            $donasi->progressPercentage = 0;
            if ($donasi->target_dana > 0) {
                $donasi->progressPercentage = min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100);
            }
        }

        $upcomingKegiatans = Kegiatan::where('status', 'publish')
        ->whereDate('tanggal_selesai_kegiatan', '>=', now())
        ->latest()
        ->take(3)
        ->get();

        return view('welcome', compact('openDonations', 'upcomingKegiatans'));
    }

    /**
     * Detail donasi untuk public
     */
    public function showDonasi($id)
    {
        $donasi = Donasi::findOrFail($id);

        // Hitung progress donasi
        $progress = $donasi->target_dana > 0 ?
            ($donasi->dana_terkumpul / $donasi->target_dana) * 100 : 0;

        // Ambil donasi terkait lainnya
        $relatedDonations = Donasi::where('status', 'open')
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.donasi.detail', compact('donasi', 'progress', 'relatedDonations'));
    }

    /**
     * Daftar semua donasi untuk public
     */
    public function donasi(Request $request)
    {
        $query = Donasi::where('status', 'open');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $donasis = $query->latest()->paginate(12);

        // Calculate progress for each donation
        foreach ($donasis as $donasi) {
            $donasi->progressPercentage = 0;
            if ($donasi->target_dana > 0) {
                $donasi->progressPercentage = min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100);
            }
        }

        return view('public.donasi.index', compact('donasis'));
    }

    /**
     * Detail kegiatan untuk public
     */
    public function showKegiatan($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Ambil kegiatan terkait lainnya
        $relatedKegiatans = Kegiatan::where('status', 'publish')
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.kegiatan.detail', compact('kegiatan', 'relatedKegiatans'));
    }

    public function daftarKegiatan(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Cek apakah kegiatan sudah berakhir - sesuaikan dengan nama kolom yang benar
        if ($kegiatan->tanggal_selesai_kegiatan < now()) {
            return redirect()->route('public.kegiatan.show', $id)
                ->with('error', 'Kegiatan ini sudah berakhir.');
        }

        // Validasi: Cek apakah user sudah pernah mendaftar untuk kegiatan ini
        $existingRegistration = DaftarKegiatan::where('user_id', auth()->user()->id)
            ->where('kegiatan_id', $id)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda sudah pernah mendaftar untuk kegiatan ini.');
        }

        $request->validate([
            'latar_belakang' => 'required|string|max:500',
            'pernah_relawan' => 'required|in:0,1', // Menggunakan in validation
            'nama_kegiatan_sebelumnya' => 'nullable|string|max:500',
            'jenis_kendaraan' => 'required|string|in:motor,mobil,tidak_ada',
            'merk_kendaraan' => 'nullable|string|max:100',
            'siap_kontribusi' => 'required|in:0,1', // Menggunakan in validation
            'bukti_follow' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_repost' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'latar_belakang.required' => 'Latar belakang wajib diisi.',
            'pernah_relawan.required' => 'Pilihan pernah relawan wajib dipilih.',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'siap_kontribusi.required' => 'Pilihan siap kontribusi wajib dipilih.',
            'bukti_follow.required' => 'Bukti follow social media wajib diupload.',
            'bukti_repost.required' => 'Bukti repost/share wajib diupload.',
            'bukti_follow.image' => 'File bukti follow harus berupa gambar.',
            'bukti_repost.image' => 'File bukti repost harus berupa gambar.',
            'bukti_follow.max' => 'Ukuran file bukti follow maksimal 2MB.',
            'bukti_repost.max' => 'Ukuran file bukti repost maksimal 2MB.',
        ]);

        try {
            // Upload bukti follow menggunakan Laravel Storage
            $buktiFollowPath = null;
            if ($request->hasFile('bukti_follow')) {
                $buktiFollowPath = $request->file('bukti_follow')->store('bukti_follow', 'public');
            }

            // Upload bukti repost menggunakan Laravel Storage
            $buktiRepostPath = null;
            if ($request->hasFile('bukti_repost')) {
                $buktiRepostPath = $request->file('bukti_repost')->store('bukti_repost', 'public');
            }

            // Pastikan kedua file berhasil diupload
            if (!$buktiFollowPath || !$buktiRepostPath) {
                return redirect()->back()
                    ->with('error', 'Gagal mengupload file. Silakan coba lagi.')
                    ->withInput();
            }

            // Data yang akan disimpan
            $dataToSave = [
                'user_id' => auth()->user()->id,
                'kegiatan_id' => $id,
                'status' => 'pending',
                'tanggal_daftar' => now(),
                'latar_belakang' => $request->latar_belakang,
                'pernah_relawan' => (bool) $request->pernah_relawan, // Convert to boolean
                'nama_kegiatan_sebelumnya' => $request->nama_kegiatan_sebelumnya,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'merk_kendaraan' => $request->merk_kendaraan,
                'siap_kontribusi' => (bool) $request->siap_kontribusi, // Convert to boolean
                'bukti_follow' => $buktiFollowPath,
                'bukti_repost' => $buktiRepostPath,
            ];

            // Debug data (hapus pada production)
            \Log::info('Data pendaftaran kegiatan:', $dataToSave);

            // Simpan ke database
            DaftarKegiatan::create($dataToSave);

            return redirect()->route('dashboard')
                ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu konfirmasi dari admin.');

        } catch (\Exception $e) {
            // Hapus file jika save gagal
            if (isset($buktiFollowPath)) {
                Storage::disk('public')->delete($buktiFollowPath);
            }
            if (isset($buktiRepostPath)) {
                Storage::disk('public')->delete($buktiRepostPath);
            }

            \Log::error('Error saat pendaftaran kegiatan: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.')
                ->withInput();
        }
    }
}
