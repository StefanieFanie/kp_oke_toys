<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/produk', function () {
    return view('produk.produk');
})->name('produk');

Route::get('/tambah-produk', function () {
    return view('produk.tambah-produk');
})->name('tambah-produk');

Route::get('/edit-produk', function () {
    return view('produk.edit-produk');
})->name('edit-produk');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/kategori', [KategoriController::class, 'show'])->name('kategori');
    Route::get('/laporan-barang', function () {
        return view('laporan.laporan-barang');
    })->name('laporan-barang');
    Route::get('/kategori', [KategoriController::class, 'show'])->name('kategori');
    Route::get('/kategori/tambah', [KategoriController::class, 'tambah'])->name('tambah-kategori');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('edit-kategori');
    Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('update-kategori');
    Route::post('/simpan-kategori', [KategoriController::class, 'simpan'])->name('simpan-kategori');
});
