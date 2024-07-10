<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    public function index(){
        $dataPengguna = User::where('jabatan', 'admin')->orWhere('jabatan','kepala gudang')->orWhere('jabatan', 'sales')
            ->get();
        return view('superAdmin.pengguna', compact('dataPengguna'));
    }

    public function inputPengguna(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaPegawai' => 'required',
            'noTelpPegawai' => 'required',
            'alamatPegawai' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'jabatan' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('pesan', 'Alamat email yang anda masukan sudah pernah digunakan');
        }
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
        $validator = Validator::make($request->all(), [
            'namaPegawai' => 'required',
            'noTelpPegawai' => 'required',
            'alamatPegawai' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'jabatan' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('pesan', 'Alamat email yang anda masukan sudah pernah digunakan');
        }

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
