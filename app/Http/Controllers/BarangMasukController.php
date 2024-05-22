<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\StokBarang;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $stokBarangMasuk = BarangMasuk::select('*')
            ->join('stok_barangs', 'barang_masuks.idBarang', '=', 'stok_barangs.idBarang')
            ->get();
        $stokBarang = StokBarang::select('*')
            ->get();
        return view('masuk', compact('stokBarangMasuk', 'stokBarang'));
    }
    public function inputBarangMasuk(Request $request)
    {
        $request->validate(
            [
                'idBarang' => 'required|exists:stok_barangs,idBarang'
            ],
            [
                'idBarang.required' => 'Nilai Kode Barang tidak boleh kosong. Silahkan masukan data dalam Stok Barang terlebih dahulu',
                'idBarang.exists' => 'Kode barang yang anda masukan tidak ada didalam database'
            ]
        );
            BarangMasuk::create([
                'idBarang' => $request->idBarang,
                'qtyMasuk' => $request->qtyMasuk
            ]);
            $stokAwal = StokBarang::where('idBarang', $request->idBarang)
                ->first();
            $stokMasuk = $request->qtyMasuk;
            $stokAkhir = $stokAwal->stokBarang + $stokMasuk;
            $editStok = StokBarang::where('idBarang', $request->idBarang)
                ->update([
                    'stokBarang' => $stokAkhir,
                ]);
            return redirect()->route('barang.masuk');
    }
    public function editBarangMasuk(Request $request)
    {
        $stokAwal = StokBarang::where('idBarang', $request->idBarang)
            ->first();
        $stokLomEdit = BarangMasuk::where('idBarangMasuk', $request->idBarangMasuk)
            ->first();
        $stokEdit = $request->qtyMasuk;
        if ($stokEdit >= $stokLomEdit->qtyMasuk) {
            $selisihStok = $stokEdit - $stokLomEdit->qtyMasuk;
            $stokAkhir = $stokAwal->stokBarang + $selisihStok;
        } else if ($stokEdit < $stokLomEdit->qtyMasuk) {
            $selisihStok = $stokLomEdit->qtyMasuk - $stokEdit;
            $stokAkhir = $stokAwal->stokBarang - $selisihStok;
        }
        $editStokMasuk = StokBarang::where('idBarang', $request->idBarang)
            ->update([
                'stokBarang' => $stokAkhir
            ]);
        $editBarangMasuk = BarangMasuk::where('idBarangMasuk', $request->idBarangMasuk)
            ->update([
                'qtyMasuk' => $request->qtyMasuk
            ]);
        return redirect()->route('barang.masuk');
    }
    public function hapusBarangMasuk(Request $request)
    {
        $stokAwal = StokBarang::where('idBarang', $request->idBarang)
            ->first();
        $stokMasuk = BarangMasuk::where('idBarang', $request->idBarang)
            ->where('idBarangMasuk', $request->idBarangMasuk)
            ->first();
        $stokAkhir = $stokAwal->stokBarang - $stokMasuk->qtyMasuk;
        if ($stokAkhir < 0) {
            return redirect()->route('barang.masuk')->with('pesan', 'Data gagal dihapus!!! Stok Barang akan menjadi negatif jika dihapus.');
        } else {
            $editStok = StokBarang::where('idBarang', $request->idBarang)
                ->update([
                    'stokBarang' => $stokAkhir,
                ]);
            $editBarangMasuk = BarangMasuk::where('idBarangMasuk', $request->idBarangMasuk)
                ->delete();
            return redirect()->route('barang.masuk');
        }
    }
}
