<?php

use App\Http\Controllers\LoginController;
use App\Livewire\Dashboard;
use App\Livewire\Produk\Produk;
use App\Livewire\Kasir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.submit');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('produk', Produk::class)
    ->middleware(['auth'])
    ->name('produk');
    Route::get('kasir', Kasir::class)
    ->middleware(['auth'])
    ->name('kasir');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


