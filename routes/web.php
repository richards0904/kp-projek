<?php

use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StokBarangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Function yang hanya bisa diakses oleh orang yang belum login
Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('masuk');
    Route::post('/', [LoginController::class, 'postLogin'])->name('login');
});

// Function yang hanya bisa diakses apabila sudah login
Route::middleware(['auth'])->group(function (){

    // Logout Function
    Route::get('/logout', [LoginController::class, 'postLogout'])->name('logout');

    // Stok Function
    Route::get('/stok', [StokBarangController::class, 'index'])->name('stok.barang')->middleware('user-access:admin,kepala gudang') ;
    Route::post('/stok/tambah', [StokBarangController::class, 'inputStock'])->name('tambah.stok.post');
    Route::post('/stok/edit', [StokBarangController::class, 'editStock'])->name('edit.stok.post');
    Route::post('/stok/hapus', [StokBarangController::class, 'hapusStock'])->name('hapus.stok.post');

    // Barang Masuk Function
    Route::get('/masuk', [BarangMasukController::class, 'index'])->name('barang.masuk')->middleware('user-access:kepala gudang');
    Route::post('masuk/tambah', [BarangMasukController::class, 'inputBarangMasuk'])->name('tambah.barang.masuk');
    Route::post('masuk/edit', [BarangMasukController::class, 'editBarangMasuk'])->name('edit.barang.masuk');
    Route::post('masuk/hapus', [BarangMasukController::class, 'hapusBarangMasuk'])->name('hapus.barang.masuk');



});


