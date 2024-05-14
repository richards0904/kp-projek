<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index()
    {
        $stokBarang = StokBarang::all();

        return view('stok', compact('stokBarang'));
    }

    public function inputStock(Request $request)
    {
        $request->validate([
            'namaBarang' => 'required',
            'jenisBarang' => 'required',
            'hargaBarang' => 'required',
        ]);
        StokBarang::create([
            'namaBarang' => $request->namaBarang,
            'jenisBarang' => $request->jenisBarang,
            'hargaBarang' => $request->hargaBarang,
            'stokBarang' => 0
        ]);
        return redirect()->route('stok.barang');
    }

    public function editStock(Request $request)
    {
        $editStok = StokBarang::where('idBarang', $request->idBarang)
            ->update([
                'namaBarang' => $request->editNamaBarang,
                'jenisBarang' => $request->editJenisBarang
            ]);
        return redirect()->route('stok.barang');
    }

    public function hapusStock(Request $request)
    {
        $editStok = StokBarang::where('idBarang', $request->idBarang)
            ->delete();
        return redirect()->route('stok.barang');
    }
}
