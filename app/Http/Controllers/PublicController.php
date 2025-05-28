<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

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

    /**
     * Daftar semua kegiatan untuk public
     */
    public function kegiatan(Request $request)
    {
        $query = Kegiatan::where('status', 'publish');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_kegiatan', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan jenis kegiatan jika ada
        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis_kegiatan', $request->jenis);
        }

        $kegiatans = $query->latest()->paginate(12);

        return view('public.kegiatan.index', compact('kegiatans'));
    }

    /**
     * Halaman tentang
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Halaman kontak
     */
    public function contact()
    {
        return view('public.contact');
    }
}
