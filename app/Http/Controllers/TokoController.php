<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $dataToko = Toko::all();

        return view('toko', compact('dataToko'));
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
        return redirect()->route('toko.pelanggan');
    }

    public function editToko(Request $request)
    {
        $editStok = Toko::where('idToko', $request->idToko)
            ->update([
                'namaToko' => $request->editNamaToko,
                'noTelp' => $request->editNoTelp,
                'alamat' => $request->editAlamat
            ]);
        return redirect()->route('toko.pelanggan');
    }
    public function hapusToko(Request $request)
    {
        $editStok = Toko::where('idToko', $request->idToko)
            ->delete();
        return redirect()->route('toko.pelanggan');
    }

}
