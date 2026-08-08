<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriKeuanganController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KegiatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 1. Route Profil Bawaan Breeze (Yang tadi hilang)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Route CRUD Admin Gebraq
    Route::resource('kategori', KategoriKeuanganController::class)->only(['index', 'store', 'destroy']);
    Route::resource('keuangan', KeuanganController::class)->only(['index', 'store', 'destroy']);
    Route::resource('kegiatan', KegiatanController::class)->only(['index', 'store', 'destroy']);
});

require __DIR__.'/auth.php';
