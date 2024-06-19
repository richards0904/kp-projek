<?php

use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TokoController;
use App\Models\Pesanan;
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
    Route::get('/stok', [StokBarangController::class, 'index'])->name('stok.barang')->middleware('user-access:kepala gudang');
    Route::post('/stok/tambah', [StokBarangController::class, 'inputStock'])->name('tambah.stok.post')->middleware('user-access:kepala gudang');
    Route::post('/stok/edit', [StokBarangController::class, 'editStock'])->name('edit.stok.post')->middleware('user-access:kepala gudang');
    Route::post('/stok/hapus', [StokBarangController::class, 'hapusStock'])->name('hapus.stok.post')->middleware('user-access:kepala gudang');

    Route::get('/stok/sales', [StokBarangController::class, 'lihatStokSales'])->name('stok.sales')->middleware('user-access:sales');
    Route::get('/stok/admin', [StokBarangController::class, 'lihatStokAdmin'])->name('stok.admin')->middleware('user-access:admin');

    // Barang Masuk Function
    Route::get('/masuk', [BarangMasukController::class, 'index'])->name('barang.masuk')->middleware('user-access:kepala gudang');
    Route::post('masuk/tambah', [BarangMasukController::class, 'inputBarangMasuk'])->name('tambah.barang.masuk')->middleware('user-access:kepala gudang');
    Route::post('masuk/edit', [BarangMasukController::class, 'editBarangMasuk'])->name('edit.barang.masuk')->middleware('user-access:kepala gudang');
    Route::post('masuk/hapus', [BarangMasukController::class, 'hapusBarangMasuk'])->name('hapus.barang.masuk')->middleware('user-access:kepala gudang');

    // Menampilkan Barang Keluar
    Route::get('/keluar', [BarangMasukController::class, 'tampilBarangKeluar'])->name('barang.keluar')->middleware('user-access:kepala gudang');

    // Toko Function
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.pelanggan')->middleware('user-access:admin');
    Route::get('/toko/sales', [TokoController::class, 'tokoSales'])->name('toko.sales')->middleware('user-access:sales');
    Route::post('/toko/tambah', [TokoController::class, 'inputToko'])->name('tambah.toko.post')->middleware('user-access:sales,admin');
    Route::post('/toko/edit', [TokoController::class, 'editToko'])->name('edit.toko.post')->middleware('user-access:sales,admin');
    Route::post('/toko/hapus', [TokoController::class, 'hapusToko'])->name('hapus.toko.post')->middleware('user-access:sales,admin');



    // Pesanan Function
    Route::get('/pesanan', [PesananController::class, 'indexAdmin'])->name('pesanan.barang');
    Route::get('/pesanan/sales', [PesananController::class, 'index'])->name('pesanan.sales');
    Route::post('/pesanan/tambah', [PesananController::class, 'buatPesanan'])->name('tambah.pesanan.post');
    Route::post('/pesanan/edit', [PesananController::class, 'editPesanan'])->name('edit.pesanan.post');
    Route::post('/pesanan/hapus', [PesananController::class, 'hapusPesanan'])->name('hapus.pesanan.post');
    Route::post('/pesanan/konfirmasi/{idPesanan}', [PesananController::class, 'konfirmasiPesanan'])->name('pesanan.konfirmasi');

    // Detail Pesanan Function (Masih di Dalam Pesanan Controller)
    Route::get('/pesanan/detail/{id}', [PesananController::class, 'showDetail'])->name('detail.pesanan');
    Route::get('/pesanan/detail/admin/{id}', [PesananController::class, 'showDetailAdmin'])->name('detail.admin');
    Route::post('/pesanan/detail/tambah', [PesananController::class, 'tambahDetailPesanan'])->name('detail.pesanan.tambah');
    Route::post('/pesanan/detail/ubah', [PesananController::class, 'ubahDetailPesanan'])->name('detail.pesanan.ubah');
    Route::post('/pesanan/detail/hapus', [PesananController::class, 'hapusDetailPesanan'])->name('detail.pesanan.hapus');
    Route::get('/pesanan/{id}/cetak-nota', [PesananController::class, 'cetakNota'])->name('cetak.nota');

    // Pesanan dikonfirmasi (Penjualan)
    Route::get('/penjualan', [PesananController::class, 'tampilPenjualan'])->name('penjualan.barang');
    Route::post('/penjualan/filter', [PesananController::class, 'filter'])->name('penjualan.filter');
    Route::get('/penjualan/laporan', [PesananController::class, 'cetakLaporan'])->name('penjualan.laporan');

    // Pengguna Function
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.halaman');
    Route::post('pengguna/tambah', [PenggunaController::class, 'inputPengguna'])->name('tambah.pengguna');
    Route::post('pengguna/edit', [PenggunaController::class, 'editPengguna'])->name('edit.pengguna');
    Route::post('pengguna/hapus', [PenggunaController::class, 'hapusPengguna'])->name('hapus.pengguna');



});


