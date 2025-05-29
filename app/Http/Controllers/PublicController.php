<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\DaftarKegiatan;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    /**
     * Halaman beranda/welcome
     */
    public function welcome()
    {
        $openDonations = Donasi::where('status', 'open')
            ->whereDate('tanggal_selesai', '>=', now())
            ->latest()
            ->take(6)
            ->get();

        foreach ($openDonations as $donasi) {
            $donasi->progressPercentage = 0;
            if ($donasi->target_dana > 0) {
                $donasi->progressPercentage = min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100);
            }
        }

        $upcomingKegiatans = Kegiatan::where('status', 'publish')
            ->whereDate('tanggal_mulai', '>=', now())
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

        // Cek apakah kegiatan sudah berakhir
        if ($kegiatan->tanggal_selesai < now()) {
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
            'latar_belakang' => 'required|string',
            'pernah_relawan' => 'required|boolean',
            'nama_kegiatan_sebelumnya' => 'nullable|string',
            'jenis_kendaraan' => 'required|string',
            'merk_kendaraan' => 'nullable|string',
            'siap_kontribusi' => 'required|boolean',
            'bukti_follow' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_repost' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buktiFollow = $request->file('bukti_follow');
        if (!$buktiFollow || !$buktiFollow->isValid()) {
            return redirect()->back()
                ->with('error', 'File bukti_follow tidak valid atau tidak ditemukan.');
        }

        $filenameFollow = uniqid() . '.' . $buktiFollow->getClientOriginalExtension();
        $buktiFollow->move(storage_path('app/bukti_follow'), $filenameFollow);
        $buktiFollowPath = 'bukti_follow/' . $filenameFollow;

        $buktiRepost = $request->file('bukti_repost');
        if (!$buktiRepost || !$buktiRepost->isValid()) {
            return redirect()->back()
                ->with('error', 'File bukti_repost tidak valid atau tidak ditemukan.');
        }

        $filenameRepost = uniqid() . '.' . $buktiRepost->getClientOriginalExtension();
        $buktiRepost->move(storage_path('app/bukti_repost'), $filenameRepost);
        $buktiRepostPath = 'bukti_repost/' . $filenameRepost;

        // Debug semua data yang akan disimpan
        $dataToSave = [
            'user_id' => auth()->user()->id,
            'kegiatan_id' => $id,
            'status' => 'pending',
            'tanggal_daftar' => now(),
            'latar_belakang' => $request->latar_belakang,
            'pernah_relawan' => $request->pernah_relawan,
            'nama_kegiatan_sebelumnya' => $request->nama_kegiatan_sebelumnya,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'merk_kendaraan' => $request->merk_kendaraan,
            'siap_kontribusi' => $request->siap_kontribusi,
            'bukti_follow' => $buktiFollowPath,
            'bukti_repost' => $buktiRepostPath,
        ];

        // Coba save ke database
        try {
            DaftarKegiatan::create($dataToSave);
            return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil dikirim!');
        } catch (\Exception $e) {
            // Hapus file jika save gagal
            Storage::disk('public')->delete([$buktiFollowPath, $buktiRepostPath]);
            
            return redirect()->back()
                ->with('error', 'Error save database: ' . $e->getMessage())
                ->withInput();
        }
    }
}
