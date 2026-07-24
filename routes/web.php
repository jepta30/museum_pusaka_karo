<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::post('/katalog/{id}/komentar', [KatalogController::class, 'storeKomentar'])->name('katalog.komentar');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin (Dilindungi middleware)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource route untuk Kategori (mengelola CRUD lengkap)
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class);
    
    // Resource route untuk Warisan Budaya, Media, dan Komentar
    Route::resource('warisan', \App\Http\Controllers\Admin\WarisanBudayaController::class);
    Route::resource('media', \App\Http\Controllers\Admin\MediaController::class);
    Route::resource('komentar', \App\Http\Controllers\Admin\KomentarController::class);
});
