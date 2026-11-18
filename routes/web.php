<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Siswa;
use App\Http\Controllers\ProfileController;

// Halaman awal arahkan ke login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    // ============= AREA ADMIN =============
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('buku', Admin\BukuController::class);
        Route::resource('kategori', Admin\KategoriController::class)->except(['create', 'edit', 'show']);
                // Tambahkan di bawah route kategori
        Route::get('/siswa', [Admin\SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/{siswa}', [Admin\SiswaController::class, 'show'])->name('siswa.show');
               Route::get('/siswa/{siswa}/edit', [Admin\SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/siswa/{siswa}', [Admin\SiswaController::class, 'update'])->name('siswa.update');
        Route::get('/peminjaman', [Admin\PeminjamanController::class, 'index'])->name('peminjaman.index');
        
        // Fitur QR Scan
        Route::get('/scan', [Admin\ScanController::class, 'index'])->name('scan.index');
        Route::post('/scan/proses', [Admin\ScanController::class, 'proses'])->name('scan.proses');
    });

    // ============= AREA SISWA =============
    Route::middleware('siswa', 'cek.status.siswa')->prefix('siswa')->name('siswa.')->group(function () {
        // Katalog & Detail Buku
        Route::get('/buku', [Siswa\BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{buku}', [Siswa\BukuController::class, 'show'])->name('buku.show'); // Rute Detail Buku
        
        // Peminjaman & QR
        Route::get('/peminjaman', [Siswa\PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/pinjam', [Siswa\PeminjamanController::class, 'pinjam'])->name('peminjaman.pinjam');
        Route::get('/peminjaman/{peminjaman}/qr', [Siswa\PeminjamanController::class, 'showQr'])->name('peminjaman.qr');
        Route::get('/peminjaman/{peminjaman}/qr-kembali', [Siswa\PeminjamanController::class, 'showQrKembali'])->name('peminjaman.qr_kembali');
    });

    // Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect setelah login sesuai role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('siswa.buku.index');
})->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';