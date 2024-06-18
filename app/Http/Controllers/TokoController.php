<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function index()
    {
        $dataToko = Toko::all();

        return view('toko', compact('dataToko'));
    }

    public function tokoSales()
    {
        $dataToko = Toko::all();

        return view('sales.tokoSales', compact('dataToko'));
    }

    public function inputToko(Request $request)
    {
        $request->validate([
            'namaToko' => 'required',
            'alamat' => 'required',
            'noTelp' => 'required',
        ]);
        Toko::create([
            'namaToko' => $request->namaToko,
            'alamat' => $request->alamat,
            'noTelp' => $request->noTelp
        ]);
        if(Auth::user()->jabatan == 'sales'){
            return redirect()->route('toko.sales');
        }else{
            return redirect()->route('toko.pelanggan');
        }
    }

    public function editToko(Request $request)
    {
        $editStok = Toko::where('idToko', $request->idToko)
            ->update([
                'namaToko' => $request->editNamaToko,
                'noTelp' => $request->editNoTelp,
                'alamat' => $request->editAlamat
            ]);
        if(Auth::user()->jabatan == 'sales'){
            return redirect()->route('toko.sales');
        }else{
            return redirect()->route('toko.pelanggan');
        }
    }

    public function hapusToko(Request $request)
    {
        $editStok = Toko::where('idToko', $request->idToko)
            ->delete();
        if(Auth::user()->jabatan == 'sales'){
            return redirect()->route('toko.sales');
        }else{
            return redirect()->route('toko.pelanggan');
        }
    }

}
