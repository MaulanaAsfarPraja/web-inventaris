<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StatusBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Halaman login hanya untuk tamu
    Route::get('/login', [LoginController::class, 'index'])
    ->name('login')
    ->middleware('initamu');

    Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post')
    ->middleware('initamu');

    // Logout user
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout')
        ->middleware('inilogin');

    // Group route untuk user yang sudah login
    Route::middleware(['inilogin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
  

    // Profile
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // CRUD barang
    Route::resource('barang', BarangController::class)->middleware('inilogin');

    // CRUD status barang
    Route::resource('statusbarang', StatusBarangController::class)->middleware('inilogin');

    // CRUD transaksi
    Route::resource('transaksi', TransaksiController::class)->middleware('inilogin');

    // CRUD petugas
    Route::get('petugas/{petugas}/edit', [PetugasController::class, 'edit'])
        ->name('petugas.edit')
        ->middleware('inilogin');

    Route::put('petugas/{petugas}', [PetugasController::class, 'update'])
        ->name('petugas.update')
        ->middleware('inilogin');

    Route::delete('petugas/{petugas}', [PetugasController::class, 'destroy'])
        ->name('petugas.destroy')
        ->middleware('inilogin');

    Route::resource('petugas', PetugasController::class)->middleware('inilogin');
});

Route::middleware(['inilogin','admin'])->group(function () {
    Route::resource('petugas', PetugasController::class);
});
