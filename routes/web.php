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
Route::get('/', [AuthController::class, 'login']);

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index']);

// Supplier Routes
Route::get('/supplier', [SupplierController::class, 'index']);
Route::post('/supplier', [SupplierController::class, 'create']);
Route::put('/supplier', [SupplierController::class, 'update']);
Route::post('/supplier/delete', [SupplierController::class, 'delete']);

// Barang Routes
Route::get('/barang', [BarangController::class, 'index']);
Route::post('/barang', [BarangController::class, 'create']);
Route::put('/barang', [BarangController::class, 'update']);
Route::post('/barang/delete', [BarangController::class, 'delete']);

// Barang Masuk Routes
Route::get('/barang-masuk', [BarangMasukController::class, 'index']);
Route::post('/barang-masuk', [BarangMasukController::class, 'create']);

// Barang Keluar Routes
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);

// Barang Rusak Routes
Route::get('/barang-rusak', [BarangRusakController::class, 'index']);

// Barang Laporan Bulanan Routes
Route::get('/laporan', [LaporanController::class, 'index']);

// Pengguna Routes
Route::get('/pengguna', [PenggunaController::class, 'index']);
Route::post('/pengguna', [PenggunaController::class, 'create']);
Route::put('/pengguna', [PenggunaController::class, 'update']);
Route::post('/pengguna/delete', [PenggunaController::class, 'delete']);
