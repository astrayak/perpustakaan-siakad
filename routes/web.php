<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Siswa;
use App\Http\Controllers\ProfileController;

Route::get('/', function () { return redirect()->route('login'); });

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('buku', Admin\BukuController::class);
        Route::resource('kategori', Admin\KategoriController::class)->except(['create', 'edit', 'show']);
        Route::get('/peminjaman', [Admin\PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::patch('/peminjaman/{peminjaman}/bayar', [Admin\PeminjamanController::class, 'bayarDenda'])->name('peminjaman.bayar');
        Route::get('/scan', [Admin\ScanController::class, 'index'])->name('scan.index');
        Route::post('/scan/proses', [Admin\ScanController::class, 'proses'])->name('scan.proses');
        
        Route::get('/siswa', [Admin\SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/{siswa}', [Admin\SiswaController::class, 'show'])->name('siswa.show');
        Route::get('/siswa/{siswa}/edit', [Admin\SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/siswa/{siswa}', [Admin\SiswaController::class, 'update'])->name('siswa.update');
        Route::patch('/siswa/{siswa}/reset-password', [Admin\SiswaController::class, 'resetPassword'])->name('siswa.reset'); // RESET PASS
        Route::patch('/password-request/{id}/reset', [Admin\SiswaController::class, 'prosesResetRequest'])->name('password.request.process');

        Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [Admin\LaporanController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/update', [Admin\UpdateController::class, 'index'])->name('update.index');
        Route::get('/update/check', [Admin\UpdateController::class, 'checkUpdate'])->name('update.check');
        Route::post('/update/install', [Admin\UpdateController::class, 'installUpdate'])->name('update.install');

                // Log History
        Route::get('/log', [Admin\LogController::class, 'index'])->name('log.index');

        
    });

    Route::middleware(['siswa', 'cek_status'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/buku', [Siswa\BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{buku}', [Siswa\BukuController::class, 'show'])->name('buku.show');
        Route::get('/peminjaman', [Siswa\PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/pinjam', [Siswa\PeminjamanController::class, 'pinjam'])->name('peminjaman.pinjam');
        Route::patch('/peminjaman/{peminjaman}/batalkan', [Siswa\PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');
        Route::get('/peminjaman/{peminjaman}/qr', [Siswa\PeminjamanController::class, 'showQr'])->name('peminjaman.qr');
        Route::get('/peminjaman/{peminjaman}/qr-kembali', [Siswa\PeminjamanController::class, 'showQrKembali'])->name('peminjaman.qr_kembali');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) return redirect()->route('admin.dashboard');
    return redirect()->route('siswa.buku.index');
})->middleware('auth')->name('dashboard');

// Route Request Lupa Password
Route::post('/request-password', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'requestPassword'])->name('password.request.submit');

require __DIR__.'/auth.php';