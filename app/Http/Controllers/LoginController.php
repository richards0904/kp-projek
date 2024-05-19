<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index()
    {
        return view("login");
    }
    function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email Wajib diisi',
            'password.required' => 'Password Wajib diisi'
        ]);
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            // echo('Sukses');
            if (Auth::user()->jabatan == 'admin') {
                return redirect()->route('stok.barang');
            } else if (Auth::user()->jabatan == 'owner') {
                return redirect()->route('kelola.admin');
            } else if (Auth::user()->jabatan == 'sales') {
                return redirect()->route('kelola.admin');
            } else {
                return redirect()->route('');
            }
            exit();
        } else {
            return redirect('')->withErrors('Username dan password yang dimasukan tidak sesuai ')->withInput();
        }
    }
    function postLogout()
    {
        Auth::logout();
        return redirect('');
    }

    public function redirectTo()
{
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect(route('stok.barang'));
    }

    return redirect(route('user'));
}
}
