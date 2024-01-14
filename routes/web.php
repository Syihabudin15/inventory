<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangRusakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SupplierController;
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
// Auth Routes
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::get('/logout', [AuthController::class, 'handleLogout'])->middleware('auth');

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Supplier Routes
Route::get('/supplier', [SupplierController::class, 'index'])->middleware('auth');
Route::post('/supplier', [SupplierController::class, 'create'])->middleware('auth');
Route::put('/supplier', [SupplierController::class, 'update'])->middleware('auth');
Route::post('/supplier/delete', [SupplierController::class, 'delete'])->middleware('auth');

// Barang Routes
Route::get('/barang', [BarangController::class, 'index'])->middleware('auth');
Route::post('/barang', [BarangController::class, 'create'])->middleware('auth');
Route::put('/barang', [BarangController::class, 'update'])->middleware('auth');
Route::post('/barang/delete', [BarangController::class, 'delete'])->middleware('auth');

// Barang Masuk Routes
Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->middleware('auth');
Route::post('/barang-masuk', [BarangMasukController::class, 'create'])->middleware('auth');
Route::put('/barang-masuk', [BarangMasukController::class, 'update'])->middleware('auth');


// Barang Keluar Routes
Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->middleware('auth');
Route::post('/barang-keluar', [BarangKeluarController::class, 'create'])->middleware('auth');
Route::put('/barang-keluar', [BarangKeluarController::class, 'update'])->middleware('auth');

// Barang Rusak Routes
Route::get('/barang-rusak', [BarangRusakController::class, 'index'])->middleware('auth');
Route::post('/barang-rusak', [BarangRusakController::class, 'create'])->middleware('auth');
Route::put('/barang-rusak', [BarangRusakController::class, 'update'])->middleware('auth');
Route::post('/barang-rusak/refund', [BarangRusakController::class, 'updateRefund'])->middleware('auth');

// Barang Laporan Bulanan Routes
Route::get('/laporan', [LaporanController::class, 'index'])->middleware('auth');
Route::post('/laporan/download', [LaporanController::class, 'download'])->middleware('auth');

// Pengguna Routes
Route::get('/pengguna', [PenggunaController::class, 'index'])->middleware('auth');
Route::post('/pengguna', [PenggunaController::class, 'create'])->middleware('auth');
Route::put('/pengguna', [PenggunaController::class, 'update'])->middleware('auth');
Route::post('/pengguna/delete', [PenggunaController::class, 'delete'])->middleware('auth');
