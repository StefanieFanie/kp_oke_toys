<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonResellerController;

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
    Route::get('/stok-masuk', function () {
        return view('stok-masuk.stok-masuk');
    })->name('stok-masuk');
    Route::get('/form-input-stok-masuk', function () {
        return view('stok-masuk.form-input-stok-masuk');
    })->name('form-input-stok-masuk');
    Route::get('/edit-diskon-reseller', [DiskonResellerController::class, 'edit'])->name('edit-diskon-reseller');
    Route::post('/update-diskon-reseller', [DiskonResellerController::class, 'update'])->name('update-diskon-reseller');
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
    Route::delete('/kategori/hapus/{id}', [KategoriController::class, 'hapus'])->name('hapus-kategori');
    Route::get('/kasir', function () {
        return view('kasir');
    })->name('kasir');
    Route::get('/supplier', [SupplierController::class, 'show'])->name('supplier');
    Route::get('/tambah-supplier', [SupplierController::class, 'tambah'])->name('tambah-supplier');
    Route::post('/simpan-supplier', [SupplierController::class, 'simpan'])->name('simpan-supplier');
    Route::get('/edit-supplier/{id}', [SupplierController::class, 'edit'])->name('edit-supplier');
    Route::post('/update-supplier/{id}', [SupplierController::class, 'update'])->name('update-supplier');
    Route::delete('/hapus-supplier/{id}', [SupplierController::class, 'hapus'])->name('hapus-supplier');
    Route::get('/user', [UserController::class, 'show'])->name('user');
    Route::get('/tambah-user', [UserController::class, 'tambah'])->name('tambah-user');
    Route::post('/simpan-user', [UserController::class, 'simpan'])->name('simpan-user');
    Route::get('/edit-user/{id}', [UserController::class, 'edit'])->name('edit-user');
    Route::post('/update-user/{id}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/hapus-user/{id}', [UserController::class, 'hapus'])->name('hapus-user');
});
