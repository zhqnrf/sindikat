<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\PraPenelitianController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SuratBalasanController;
use App\Http\Controllers\MouController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// 1. ROUTES UNTUK SEMUA USER (USER BIASA & ADMIN)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- MAHASISWA (Akses User) ---
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        // Form & Action
        Route::get('/create', [MahasiswaController::class, 'create'])->name('create');
        Route::post('/', [MahasiswaController::class, 'store'])->name('store');
        
        // Helper Routes (AJAX untuk Form) - PENTING: Harus bisa diakses User
        Route::get('/ruangan-info/{id}', [MahasiswaController::class, 'getRuanganInfo'])->name('ruangan.info');
        Route::get('/search/universitas', [MahasiswaController::class, 'searchUniversitas'])->name('search.universitas');
    });

    // --- PRA-PENELITIAN (Akses User) ---
    Route::prefix('pra-penelitian')->name('pra-penelitian.')->group(function () {
        Route::get('/create', [PraPenelitianController::class, 'create'])->name('create');
        Route::post('/', [PraPenelitianController::class, 'store'])->name('store');
    });

    // --- SERTIFIKAT & ABSENSI (Public/Shared) ---
    Route::get('/sertifikat/download/{token}', [AbsensiController::class, 'generateSertifikatPublik'])->name('sertifikat.download');
    Route::get('/absensi/{token}', [AbsensiController::class, 'card'])->name('absensi.card');
    Route::post('/absensi/{token}/toggle', [AbsensiController::class, 'toggle'])->name('absensi.toggle');
});

// =========================================================================
// 2. ROUTES KHUSUS ADMIN
// =========================================================================
Route::middleware(['auth', 'admin'])->group(function () {

    // Mahasiswa (Admin Features)
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('index');
        Route::post('/import-excel', [MahasiswaController::class, 'importExcel'])->name('import_excel');
        Route::get('/export', [MahasiswaController::class, 'export'])->name('export');
        Route::get('/links', [MahasiswaController::class, 'copyLinks'])->name('links');
        
        Route::get('/{id}/sertifikat/summary', [MahasiswaController::class, 'showSertifikatSummary'])->name('sertifikat.summary');
        Route::get('/{mahasiswa}', [MahasiswaController::class, 'show'])->name('show');
        Route::get('/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('edit');
        Route::put('/{mahasiswa}', [MahasiswaController::class, 'update'])->name('update');
        Route::delete('/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('destroy');
    });

    // Pra-penelitian (Admin Features)
    Route::prefix('pra-penelitian')->name('pra-penelitian.')->group(function () {
        Route::get('/', [PraPenelitianController::class, 'index'])->name('index');
        Route::get('/{pra_penelitian}', [PraPenelitianController::class, 'show'])->name('show');
        Route::get('/{pra_penelitian}/edit', [PraPenelitianController::class, 'edit'])->name('edit');
        Route::put('/{pra_penelitian}', [PraPenelitianController::class, 'update'])->name('update');
        Route::delete('/{pra_penelitian}', [PraPenelitianController::class, 'destroy'])->name('destroy');
        Route::patch('/{pra_penelitian}/batal', [PraPenelitianController::class, 'batal'])->name('batal');
    });

    // Ruangan
    Route::prefix('ruangan')->name('ruangan.')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('index');
        Route::get('/create', [RuanganController::class, 'create'])->name('create');
        Route::post('/', [RuanganController::class, 'store'])->name('store');
        Route::get('/{ruangan}/edit', [RuanganController::class, 'edit'])->name('edit');
        Route::put('/{ruangan}', [RuanganController::class, 'update'])->name('update');
        Route::delete('/{ruangan}', [RuanganController::class, 'destroy'])->name('destroy');
    });

    // Pelatihan
    Route::prefix('pelatihan')->name('pelatihan.')->group(function () {
        Route::get('/', [PelatihanController::class, 'index'])->name('index');
        Route::get('/create', [PelatihanController::class, 'create'])->name('create');
        Route::get('/export', [PelatihanController::class, 'export'])->name('export');
        Route::post('/import-excel', [PelatihanController::class, 'import_excel'])->name('import_excel');
        Route::post('/', [PelatihanController::class, 'store'])->name('store');
        Route::get('/{pelatihan}', [PelatihanController::class, 'show'])->name('show');
        Route::get('/{pelatihan}/edit', [PelatihanController::class, 'edit'])->name('edit');
        Route::put('/{pelatihan}', [PelatihanController::class, 'update'])->name('update');
        Route::delete('/{pelatihan}', [PelatihanController::class, 'destroy'])->name('destroy');
    });

    // Surat Balasan
    Route::prefix('surat-balasan')->name('surat-balasan.')->group(function () {
        Route::get('/', [SuratBalasanController::class, 'index'])->name('index');
        Route::get('/create', [SuratBalasanController::class, 'create'])->name('create');
        Route::post('/', [SuratBalasanController::class, 'store'])->name('store');
        Route::get('/{suratBalasan}/edit', [SuratBalasanController::class, 'edit'])->name('edit');
        Route::put('/{suratBalasan}', [SuratBalasanController::class, 'update'])->name('update');
        Route::delete('/{suratBalasan}', [SuratBalasanController::class, 'destroy'])->name('destroy');
        Route::get('/{suratBalasan}/pdf', [SuratBalasanController::class, 'generatePdf'])->name('pdf');
    });

    // MOU
    Route::prefix('mou')->name('mou.')->group(function () {
        Route::get('/', [MouController::class, 'index'])->name('index');
        Route::get('/create', [MouController::class, 'create'])->name('create');
        Route::post('/', [MouController::class, 'store'])->name('store');
        Route::post('/import', [MouController::class, 'importExcel'])->name('import_excel');
        Route::get('/{mou}', [MouController::class, 'show'])->name('show');
        Route::get('/{mou}/edit', [MouController::class, 'edit'])->name('edit');
        Route::put('/{mou}', [MouController::class, 'update'])->name('update');
        Route::delete('/{mou}', [MouController::class, 'destroy'])->name('destroy');
    });

    // Admin Utilities
    Route::get('/mahasiswa/{id}/sertifikat', [MahasiswaController::class, 'generateSertifikat'])->name('mahasiswa.sertifikat');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});