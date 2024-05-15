<?php

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



Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('masuk');
    Route::post('/', [LoginController::class, 'postLogin'])->name('login');
});


Route::get('/stok', [StokBarangController::class, 'index'])->middleware('user-access:admin , sales')->name('stok.barang');
Route::post('stok/tambah', [StokBarangController::class, 'inputStock'])->name('tambah.stok.post');
Route::post('/stok/edit', [StokBarangController::class, 'editStock'])->name('edit.stok.post');
Route::post('/stok/hapus', [StokBarangController::class, 'hapusStock'])->name('hapus.stok.post');


