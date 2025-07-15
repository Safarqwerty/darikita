<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\PemberiDonasiController;
use App\Http\Controllers\DaftarKegiatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'welcome'])->name('welcome');
Route::get('/donasi', [PublicController::class, 'donasi'])->name('donasi');
Route::get('/donasi/{id}', [PublicController::class, 'showDonasi'])->name('donasi.detail');
Route::get('/kegiatan', [PublicController::class, 'kegiatan'])->name('kegiatan');
Route::get('/tentang', [PublicController::class, 'about'])->name('public.about');
Route::get('/kontak', [PublicController::class, 'contact'])->name('public.contact');

// Route to show the registration form (accessible to guests, but will redirect if not logged in)
Route::get('/kegiatan/{kegiatan}/daftar', [DaftarKegiatanController::class, 'create'])->name('public.kegiatan.create');

// Dashboard dan Profil untuk semua pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kegiatan/{id}', [PublicController::class, 'showKegiatan'])->name('public.kegiatan.show');

    Route::post('/kegiatan/{id}', [DaftarKegiatanController::class, 'store'])->name('public.kegiatan.daftar');
});

// Rute Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Group for routes that SHOULD have the 'admin.' name prefix
    Route::name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // User management (admin)
        Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
        Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    });

    // e.g., donasi.index, kegiatan.index
    Route::resource('donasi', DonasiController::class);
    Route::resource('kegiatan', KegiatanController::class);

    // e.g., pendaftaran.index, pendaftaran.show
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [DaftarKegiatanController::class, 'index'])->name('index');
        Route::get('/{id}', [DaftarKegiatanController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [DaftarKegiatanController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [DaftarKegiatanController::class, 'reject'])->name('reject');
    });

    // e.g., pemberi-donasi.index, pemberi-donasi.create
    Route::prefix('pemberi-donasi')->name('pemberi-donasi.')->group(function () {
        Route::get('/', [PemberiDonasiController::class, 'index'])->name('index');
        Route::get('/create', [PemberiDonasiController::class, 'create'])->name('create');
        Route::post('/', [PemberiDonasiController::class, 'store'])->name('store');
        Route::get('/report', [PemberiDonasiController::class, 'report'])->name('report');
        Route::get('/{pemberiDonasi}', [PemberiDonasiController::class, 'show'])->name('show');
        Route::get('/{pemberiDonasi}/edit', [PemberiDonasiController::class, 'edit'])->name('edit');
        Route::put('/{pemberiDonasi}', [PemberiDonasiController::class, 'update'])->name('update');
        Route::delete('/{pemberiDonasi}', [PemberiDonasiController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
