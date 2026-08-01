<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/peta-persebaran', [HomeController::class, 'petaPersebaran'])->name('peta.persebaran');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::post('/katalog/{id}/komentar', [KatalogController::class, 'storeKomentar'])->name('katalog.komentar');

// Buku Tamu (Pengunjung mengisi mandiri, tidak perlu login)
Route::post('/buku-tamu', [\App\Http\Controllers\Admin\PengunjungController::class, 'storeMandiri'])->name('buku-tamu.store');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin (Dilindungi middleware)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource route untuk Kategori (index, create, store, edit, update, destroy)
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class)->except(['show']);

    // Warisan Budaya & Media pakai form modal (tambah/edit dalam satu halaman index)
    Route::resource('warisan', \App\Http\Controllers\Admin\WarisanBudayaController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::resource('media', \App\Http\Controllers\Admin\MediaController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // Komentar hanya perlu index (moderasi), update (ubah status), dan destroy
    Route::resource('komentar', \App\Http\Controllers\Admin\KomentarController::class)
        ->only(['index', 'update', 'destroy']);

    // Buku Tamu Pengunjung (BAB IV.4 poin 7)
    Route::resource('pengunjung', \App\Http\Controllers\Admin\PengunjungController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::get('/pengunjung-export/csv', [\App\Http\Controllers\Admin\PengunjungController::class, 'exportCsv'])->name('pengunjung.export');
    Route::get('/pengunjung-export/pdf', [\App\Http\Controllers\Admin\PengunjungController::class, 'exportPdf'])->name('pengunjung.export.pdf');

    // Buku Induk Koleksi Museum (BAB IV.4 poin 8)
    Route::resource('koleksi', \App\Http\Controllers\Admin\KoleksiController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::get('/koleksi-export/csv', [\App\Http\Controllers\Admin\KoleksiController::class, 'exportCsv'])->name('koleksi.export');
    Route::get('/koleksi-export/pdf', [\App\Http\Controllers\Admin\KoleksiController::class, 'exportPdf'])->name('koleksi.export.pdf');

    // Laporan (BAB IV.4)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
        Route::get('/export-csv', [\App\Http\Controllers\Admin\LaporanController::class, 'exportCsv'])->name('export.csv');
        Route::get('/warisan', [\App\Http\Controllers\Admin\LaporanController::class, 'warisan'])->name('warisan');
        Route::get('/warisan/csv', [\App\Http\Controllers\Admin\LaporanController::class, 'warisanCsv'])->name('warisan.csv');

        Route::get('/rekapitulasi', [\App\Http\Controllers\Admin\LaporanController::class, 'rekapitulasi'])->name('rekapitulasi');
        Route::get('/rekapitulasi/csv', [\App\Http\Controllers\Admin\LaporanController::class, 'rekapitulasiCsv'])->name('rekapitulasi.csv');

        Route::get('/komentar', [\App\Http\Controllers\Admin\LaporanController::class, 'komentar'])->name('komentar');
        Route::get('/komentar/csv', [\App\Http\Controllers\Admin\LaporanController::class, 'komentarCsv'])->name('komentar.csv');

        Route::get('/kunjungan', [\App\Http\Controllers\Admin\LaporanController::class, 'kunjungan'])->name('kunjungan');
        Route::get('/kunjungan/csv', [\App\Http\Controllers\Admin\LaporanController::class, 'kunjunganCsv'])->name('kunjungan.csv');
    });

    // Pengaturan Akun
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('index');
        Route::put('/profile', [\App\Http\Controllers\Admin\PengaturanController::class, 'updateProfile'])->name('profile');
        Route::put('/password', [\App\Http\Controllers\Admin\PengaturanController::class, 'updatePassword'])->name('password');
    });
});
