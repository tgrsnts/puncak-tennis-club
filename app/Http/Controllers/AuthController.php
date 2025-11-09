<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (Auth::attempt($user)){
            $request->session()->regenerate();
            return redirect()->intended('admin/');
        }
        return back()->with('email', 'Email atau Password Salah')->onlyInput('email');
    }

    public function register(Request $request){
        $user = $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'kode' => 'required'
        ]);
        if($request->kode == 'anantakeren'){
            User::create([
                "nama" => $request->nama,
                "email" => $request->email,
                "password" => $request->password,
                "role" => 1,
                "jenis_kelamin" => "L",
                "telepon" => "-"
            ]);
            return redirect()->route('login')->with('success', 'Akun Berhasil Dibuat');
        }
        elseif($request->kode == 'anantagacor'){
            User::create([
                "nama" => $request->nama,
                "email" => $request->email,
                "password" => $request->password,
                "role" => 2,
                "jenis_kelamin" => "L",
                "telepon" => "-"
            ]);
            return redirect()->route('login')->with('success', 'Akun Berhasil Dibuat');
        }
        return redirect()->route('login')->with('gagal', 'Akun Gagal Dibuat');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
