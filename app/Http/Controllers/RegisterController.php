<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // STEP 1 - email & password
    public function showStep1($locale = null)
    {
        return view('auth.register-step1');
    }

    public function handleStep1(Request $request, $locale = null)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'user',
            ]);
            session(['register_user_id' => $user->id]);

            return redirect()->route('register.step2', ['locale' => app()->getLocale()])
                ->with('success', 'Akun berhasil dibuat! Silakan lengkapi data diri.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat akun. Coba lagi nanti.');
        }
    }


    // STEP 2 - lengkapi data diri
    public function showStep2($locale = null)
    {
        if (!session('register_user_id')) {
            return redirect()->route('register.step1');
        }
        return view('auth.register-step2');
    }

    public function handleStep2(Request $request, $locale = null)
    {
        $userId = session('register_user_id');
        if (!$userId) {
            return redirect()->route('register.step1');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $user = User::findOrFail($userId);
        $user->update($data);

        // hapus session step
        session()->forget('register_user_id');

        // opsional auto login
        auth()->login($user);

        return redirect()->route('home', ['locale' => app()->getLocale()])
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }
}
