<?php

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

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index']);

// Supplier Routes
Route::get('/supplier', [SupplierController::class, 'index']);
Route::post('/supplier', [SupplierController::class, 'create']);
Route::put('/supplier', [SupplierController::class, 'update']);
Route::post('/supplier/delete', [SupplierController::class, 'delete']);

// Barang Routes
Route::get('/barang', [BarangController::class, 'index']);

// Barang Masuk Routes
Route::get('/barang-masuk', [BarangMasukController::class, 'index']);

// Barang Keluar Routes
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);

// Barang Rusak Routes
Route::get('/barang-rusak', [BarangRusakController::class, 'index']);

// Barang Laporan Bulanan Routes
Route::get('/laporan', [LaporanController::class, 'index']);

// Pengguna Routes
Route::get('/pengguna', [PenggunaController::class, 'index']);
