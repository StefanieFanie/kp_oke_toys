<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/kategori', [KategoriController::class, 'show'])->name('kategori');
    Route::get('/laporan-barang', function () {
        return view('laporan.laporan-barang');
    })->name('laporan-barang');
    Route::get('/produk', [ProdukController::class, 'show'])->name('produk');
    Route::get('/tambah-produk', [ProdukController::class, 'tambah'])->name('tambah-produk');
    Route::post('/simpan-produk', [ProdukController::class, 'simpan'])->name('simpan-produk');
    Route::get('/edit-produk/{id}', [ProdukController::class, 'edit'])->name('edit-produk');
    Route::post('/update-produk/{id}', [ProdukController::class, 'update'])->name('update-produk');
    Route::delete('/hapus-produk/{id}', [ProdukController::class, 'hapus'])->name('hapus-produk');
    Route::get('/cari-produk', [ProdukController::class, 'cari'])->name('cari-produk');
    Route::get('/kategori', [KategoriController::class, 'show'])->name('kategori');
    Route::get('/kategori/tambah', [KategoriController::class, 'tambah'])->name('tambah-kategori');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('edit-kategori');
    Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('update-kategori');
    Route::post('/simpan-kategori', [KategoriController::class, 'simpan'])->name('simpan-kategori');
    Route::get('/kasir', function () {
        return view('kasir');
    })->name('kasir');
});
