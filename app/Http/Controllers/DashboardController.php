<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kegiatan;
use App\Models\DaftarKegiatan;
use App\Models\PemberiDonasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard()
    {
        // Authorization: Only admin can access
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Get user stats
        $totalUsers = User::where('email', '!=', 'admin@gmail.com')->count();
        $users = User::where('email', '!=', 'admin@gmail.com')
                    ->latest() // sama dengan ->orderBy('created_at', 'DESC')
                    ->get();
        // Get donation stats
        $totalDonasi = Donasi::count();
        $donasiAktif = Donasi::where('status', 'aktif')->count();
        $totalDanaTerkumpul = Donasi::sum('dana_terkumpul');
        $totalDonatur = PemberiDonasi::distinct('user_id')->count('user_id');

        // Get activity stats
        $totalKegiatan = Kegiatan::count();
        $kegiatanAktif = Kegiatan::where('status', 'aktif')->count();
        $totalPendaftar = DaftarKegiatan::count();
        $pendaftarApproved = DaftarKegiatan::where('status', 'approved')->count();

        // Get user stats
        $totalUsers = User::count();
        $newUsers = User::whereDate('created_at', '>=', now()->subDays(30))->count();

        // Get latest donation data
        $latestDonations = PemberiDonasi::with(['user', 'donasi'])
            ->latest('tanggal_donasi')
            ->take(5)
            ->get();

        // Get latest registrations
        $latestRegistrations = DaftarKegiatan::with(['user', 'kegiatan'])
            ->latest('tanggal_daftar')
            ->take(5)
            ->get();

        // Monthly donation statistics for chart (last 6 months)
        $monthlyDonations = DB::table('pemberi_donasis')
            ->select(DB::raw('YEAR(tanggal_donasi) as year, MONTH(tanggal_donasi) as month, SUM(jumlah) as total'))
            ->whereDate('tanggal_donasi', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Format month names for chart
        $chartLabels = [];
        $chartData = [];
        foreach ($monthlyDonations as $donation) {
            $date = \Carbon\Carbon::createFromDate($donation->year, $donation->month, 1);
            $chartLabels[] = $date->format('M Y');
            $chartData[] = $donation->total;
        }

        // --- FIX: Corrected the view path from 'dashboard.admin' to 'admin.dashboard' ---
        return view('admin.dashboard', compact(
            'totalDonasi', 'donasiAktif', 'totalDanaTerkumpul', 'totalDonatur',
            'totalKegiatan', 'kegiatanAktif', 'totalPendaftar', 'pendaftarApproved',
            'totalUsers', 'newUsers', 'latestDonations', 'latestRegistrations',
            'chartLabels', 'chartData', 'users'
        ));
    }

    /**
     * Display user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function userDashboard()
    {
        $user = Auth::user(); // Get the full authenticated user object
        $userId = $user->id;

        // Get user's donations
        $totalDonations = PemberiDonasi::where('user_id', $userId)->count();
        $totalDonated = PemberiDonasi::where('user_id', $userId)->sum('jumlah');
        $latestDonations = PemberiDonasi::with('donasi')
            ->where('user_id', $userId)
            ->latest('tanggal_donasi')
            ->take(3)
            ->get();

        // Get user's registrations
        $totalRegistrations = DaftarKegiatan::where('user_id', $userId)->count();
        $approvedRegistrations = DaftarKegiatan::where('user_id', $userId)
            ->where('status', 'diterima')
            ->count();
        $latestRegistrations = DaftarKegiatan::with('kegiatan')
            ->where('user_id', $userId)
            ->latest('tanggal_daftar')
            ->take(3)
            ->get();

        // Get active events for recommendations
        $activeEvents = Kegiatan::where('status', 'publish')
            ->withCount(['pendaftar'])
            ->whereDate('tanggal_selesai_kegiatan', '>=', now())
            ->latest()
            ->get();

        // Get active donations for recommendations
        $activeDonations = Donasi::where('status', 'aktif')
            ->whereDate('tanggal_selesai', '>=', now())
            ->latest()
            ->get();

        // Get user's registered activities
        $registrationActivities = DaftarKegiatan::where('user_id', $userId)
            ->with('kegiatan')
            ->latest('tanggal_daftar')
            ->get();

        return view('dashboard', compact(
            'user', // Pass the user object to the view
            'totalDonations', 'totalDonated', 'latestDonations',
            'totalRegistrations', 'approvedRegistrations', 'latestRegistrations',
            'activeEvents', 'activeDonations', 'registrationActivities'
        ));
    }
}
