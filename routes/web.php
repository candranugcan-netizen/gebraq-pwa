<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriKeuanganController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LandingController;
use App\Models\Keuangan;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/dashboard', function () {
    $pemasukan = Keuangan::where('tipe', 'Pemasukan')->sum('nominal');
    $pengeluaran = Keuangan::where('tipe', 'Pengeluaran')->sum('nominal');
    $saldo = $pemasukan - $pengeluaran;
    $totalKegiatan = Kegiatan::count();
    $recentKeuangan = Keuangan::with('kategori')->latest()->take(3)->get();

    return view('dashboard', compact('pemasukan', 'pengeluaran', 'saldo', 'totalKegiatan', 'recentKeuangan'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 1. Route Profil Bawaan Breeze (Yang tadi hilang)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Ekspor Keuangan (Tambahkan 2 baris ini)
    Route::get('/keuangan/export/excel', [KeuanganController::class, 'exportExcel'])->name('keuangan.export.excel');
    Route::get('/keuangan/export/pdf', [KeuanganController::class, 'exportPdf'])->name('keuangan.export.pdf');

    // 2. Route CRUD Admin Gebraq
    Route::resource('kategori', KategoriKeuanganController::class)->only(['index', 'store', 'destroy']);
    Route::resource('keuangan', KeuanganController::class)->only(['index', 'store', 'destroy']);
    Route::resource('kegiatan', KegiatanController::class)->only(['index', 'store', 'destroy']);
});

require __DIR__.'/auth.php';
