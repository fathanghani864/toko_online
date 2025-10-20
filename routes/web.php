<?php

use App\Http\Controllers\pesanancontroller;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\sallercontroller;
use App\Http\Controllers\shopcontroller;
use App\Http\Controllers\usercontroller; // Pastikan ini di-import
use Illuminate\Support\Facades\Route;

// --- Rute Dasar ---

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Rute Khusus PENJUAL (Role: seller) ---
Route::middleware(['auth', 'verified', 'role:seller'])->group(function () {
    
    // **1. CUSTOM ROUTES**
    Route::patch('/orders/{order}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::patch('/orders/{order}/cancel', [PesananController::class, 'cancel'])->name('pesanan.cancel');
    Route::patch('/orders/{order}/complete', [PesananController::class, 'complete'])->name('pesanan.complete');

    // **2. RESOURCE ROUTE UTAMA**
    Route::resource('pesanan', PesananController::class);

    // Rute Seller Dashboard (Resource)
    Route::resource('seller', sallercontroller::class);
    
    // Rute CRUD Produk oleh Penjual
    Route::resource('/seller/produk', ProdukController::class);

});


// --- Rute Khusus PENGGUNA (Role: pengguna) ---
Route::middleware(['auth', 'verified', 'role:pengguna'])->group(function () {
    // Rute resource user (misalnya untuk index dan show produk)
    Route::resource('user', usercontroller::class);
    // Rute BARU untuk menampilkan status pesanan pengguna yang login
    Route::get('/status-pesanan', [usercontroller::class, 'statusPesanan'])->name('pesanan.status');
});


Route::get('/cek-role', function () {
    return auth()->user();
})->middleware('auth');

require __DIR__ . '/auth.php';
