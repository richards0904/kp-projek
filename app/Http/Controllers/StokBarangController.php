<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index()
    {
        $stokBarang = StokBarang::all();

        return view('kepalaGudang.stok', compact('stokBarang'));
    }

    public function lihatStokSales()
    {
        $stokBarang = StokBarang::all();

        return view('sales.lihatStokSales', compact('stokBarang'));
    }

    public function lihatStokAdmin()
    {
        $stokBarang = StokBarang::all();

        return view('admin.lihatStokAdmin', compact('stokBarang'));
    }

    public function inputStock(Request $request)
    {
        $request->validate([
            'idBarang' => 'required',
            'namaBarang' => 'required',
            'jenisBarang' => 'required',
            'hargaBarang' => 'required',
        ]);
        try{
        StokBarang::create([
            'idBarang' => $request->idBarang,
            'namaBarang' => $request->namaBarang,
            'jenisBarang' => $request->jenisBarang,
            'hargaBarang' => $request->hargaBarang,
            'stokBarang' => 0
        ]);
        }catch(\Exception $e){
            return redirect()->route('stok.barang')->with('pesan', 'Kode Barang yang anda masukan sudah pernah dibuat.') ;
        }
        return redirect()->route('stok.barang');
    }

    public function editStock(Request $request)
    {
        $editStok = StokBarang::where('idBarang', $request->idBarang)
            ->update([
                'namaBarang' => $request->editNamaBarang,
                'jenisBarang' => $request->editJenisBarang,
                'hargaBarang' => $request->editHargaBarang
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
