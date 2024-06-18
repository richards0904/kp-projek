<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(){
        $dataPengguna = User::where('jabatan', 'admin')->orWhere('jabatan','kepala gudang')->orWhere('jabatan', 'sales')
            ->get();
        return view('superAdmin.pengguna', compact('dataPengguna'));
    }

    public function inputPengguna(Request $request)
    {
        $request->validate([
            'namaPegawai' => 'required',
            'noTelpPegawai' => 'required',
            'alamatPegawai' => 'required',
            'email' => 'required',
            'password' => 'required',
            'jabatan' => 'required'
        ]);
        User::create([
            'namaPegawai' => $request->namaPegawai,
            'noTelpPegawai' => $request->noTelpPegawai,
            'alamatPegawai' => $request->alamatPegawai,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan
        ]);
        return redirect()->route('pengguna.halaman');
    }

    public function editPengguna(Request $request)
    {
        $editPengguna = User::where('idPegawai', $request->idPegawai)
            ->update([
                'namaPegawai' => $request->namaPegawai,
                'noTelpPegawai' => $request->noTelpPegawai,
                'alamatPegawai' => $request->alamatPegawai,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jabatan' => $request->jabatan
            ]);
        return redirect()->route('pengguna.halaman');
    }
    public function hapusPengguna(Request $request)
    {
        $hapusPengguna = User::where('idPegawai', $request->idPegawai)
            ->delete();
        return redirect()->route('pengguna.halaman');
    }

}
