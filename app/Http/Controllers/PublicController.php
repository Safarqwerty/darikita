<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
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
            ->whereDate('tanggal_selesai_daftar', '>=', Carbon::today()) // Hanya yang belum lewat tanggal selesai pendaftaran
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
            ->whereDate('tanggal_selesai_daftar', '>=', Carbon::today())
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
        // 1. Auto-close donasi yang sudah lewat tanggalnya ATAU target tercapai
        Donasi::where('status', 'open')
        ->where(function($query) {
            $query->whereDate('tanggal_selesai', '<', Carbon::now())
                ->orWhereColumn('dana_terkumpul', '>=', 'target_dana');
        })
        ->update(['status' => 'closed']);

        // 2. Ambil donasi yang masih open dan belum mencapai target
        $openDonations = Donasi::where('status', 'open')
        ->whereDate('tanggal_selesai', '>=', now())
        ->whereColumn('dana_terkumpul', '<', 'target_dana')
        ->latest()
        ->take(3)
        ->get();

        // 3. Hitung progress
        $openDonations->each(function ($donasi) {
            $donasi->progressPercentage = $donasi->target_dana > 0
                ? min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100)
                : 0;
            $donasi->daysLeft = Carbon::now()->diffInDays(Carbon::parse($donasi->tanggal_selesai), false);
        });

        // 4. Ambil kegiatan upcoming (hanya yang belum lewat tanggal pendaftaran)
        $upcomingKegiatans = Kegiatan::where('status', 'publish')
            ->whereDate('tanggal_selesai_daftar', '>=', now())
            ->whereDate('tanggal_selesai_kegiatan', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        // 5. Statistik jumlah
        $totalRelawan = User::where('email', '!=', 'admin@gmail.com')->count();
        $totalKegiatan = Kegiatan::count();
        $donasiSebelumnya = 3350;
        $donasiSekarang = Donasi::count();
        $totalDonasi = $donasiSebelumnya + $donasiSekarang;

        return view('welcome', compact(
            'openDonations',
            'upcomingKegiatans',
            'totalRelawan',
            'totalKegiatan',
            'totalDonasi'
        ));
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
        // 1. Auto-close expired or target-reached donations first
        Donasi::where('status', 'open')
                ->where(function($query) {
                    $query->whereDate('tanggal_selesai', '<', Carbon::now())
                        ->orWhereColumn('dana_terkumpul', '>=', 'target_dana');
                })
                ->update(['status' => 'closed']);

        // 2. Base query for active donations
        $query = Donasi::where('status', 'open')
                        ->whereDate('tanggal_selesai', '>=', Carbon::now())
                        ->whereColumn('dana_terkumpul', '<', 'target_dana');

        // 3. Enhanced search with better handling
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_donasi', 'like', $searchTerm)
                    ->orWhere('deskripsi', 'like', $searchTerm);
            });
        }

        // 4. Filter improvements
        if ($request->filled('jenis_donasi')) {
            $query->where('jenis_donasi', $request->jenis_donasi);
        }

        // 5. Status filter (now includes closed donations)
        if ($request->filled('status')) {
            $query->where('status', $request->status);

            // If showing closed donations, remove the active donation conditions
            if ($request->status === 'closed') {
                $query->where(function($q) {
                    $q->whereDate('tanggal_selesai', '<', Carbon::now())
                        ->orWhereColumn('dana_terkumpul', '>=', 'target_dana');
                });
            }
        }

        // 6. Pagination with query string preservation
        $donasis = $query->latest()->paginate(12);

        // 7. Calculate additional donation metrics
        $donasis->each(function ($donasi) {
            $donasi->progressPercentage = $donasi->target_dana > 0
                ? min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100)
                : 0;

            $donasi->daysLeft = Carbon::parse($donasi->tanggal_selesai)
                                    ->diffInDays(Carbon::now(), false);

            $donasi->isUrgent = $donasi->daysLeft <= 7 && $donasi->daysLeft >= 0;
        });

        // 8. Get filter options
        $jenisDonasiOptions = Donasi::where('status', 'open')
                                ->whereNotNull('jenis_donasi')
                                ->distinct()
                                ->orderBy('jenis_donasi')
                                ->pluck('jenis_donasi');

        return view('public.donasi.index', compact('donasis', 'jenisDonasiOptions'));
    }

    /**
     * Detail kegiatan untuk public
     */
    public function showKegiatan($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Cek apakah kegiatan sudah lewat tanggal selesai pendaftaran
        if ($kegiatan->tanggal_selesai_daftar < Carbon::today()) {
            return redirect()->route('public.kegiatan.index')
                ->with('error', 'Pendaftaran untuk kegiatan ini sudah ditutup.');
        }

        // Debug: cek struktur data gambar
        \Log::info('Data kegiatan:', [
            'id' => $kegiatan->id,
            'nama' => $kegiatan->nama_kegiatan,
            'gambar_lokasi' => $kegiatan->gambar_lokasi,
            'gambar_lokasi_type' => gettype($kegiatan->gambar_lokasi),
            'gambar_lokasi_count' => is_array($kegiatan->gambar_lokasi) ? count($kegiatan->gambar_lokasi) : 'not array'
        ]);

        // Cek apakah file gambar benar-benar ada
        if ($kegiatan->gambar_lokasi && is_array($kegiatan->gambar_lokasi)) {
            foreach ($kegiatan->gambar_lokasi as $index => $gambar) {
                $fullPath = storage_path('app/public/' . $gambar);
                $publicPath = public_path('storage/' . $gambar);
                \Log::info("Gambar {$index}:", [
                    'path' => $gambar,
                    'storage_exists' => file_exists($fullPath),
                    'public_exists' => file_exists($publicPath),
                    'full_path' => $fullPath,
                    'public_path' => $publicPath
                ]);
            }
        }

        $relatedKegiatans = Kegiatan::where('status', 'publish')
            ->where('id', '!=', $id)
            ->whereDate('tanggal_selesai_daftar', '>=', Carbon::today())
            ->latest()
            ->take(3)
            ->get();

        return view('public.kegiatan.detail', compact('kegiatan', 'relatedKegiatans'));
    }
}
