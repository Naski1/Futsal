<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JamController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('admin.costumer.index');
// });


Route::get('/', [DashboardController::class, 'dashboard']);

Route::middleware(['guest'])->group(function () {
    // auth login
    Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth'])->group(function () {
    //lapangan
    Route::resource('/lapangan', LapanganController::class);

    //jam
    Route::resource('/jam', JamController::class);

    //jadwal
    Route::resource('/jadwal', JadwalController::class);

    //user
    Route::resource('/user', UserController::class);

    //pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::get('/pemesanan/search', [PemesananController::class, 'search'])->name('pemesanan.search');
    Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/detail/{id}', [PemesananController::class, 'detail'])->name('pemesanan.detail');
    Route::get('/pemesanan/tanggal', [PemesananController::class, 'pemesananByTanggal'])->name('pemesanan.harian');

    // auth logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
