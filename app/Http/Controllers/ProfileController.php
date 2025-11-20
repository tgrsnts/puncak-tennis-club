<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Display the user's profile
    public function index(Request $request)
    {
        return view('user.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'telepon'          => ['nullable', 'string', 'max:20'],
            'jenis_kelamin'    => ['nullable', 'in:L,P'],
            'photo'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // Password section (opsional)
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password'         => ['nullable', 'string', 'min:8', 'confirmed'], // butuh field password_confirmation
        ]);

        // 1) Update field basic
        $user->name          = $validated['name'];
        $user->telepon       = $validated['telepon'] ?? null;
        $user->jenis_kelamin = $validated['jenis_kelamin'] ?? null;

        // 2) Handle foto profil (optional)
        if ($request->hasFile('photo')) {
            // hapus foto lama kalau ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->photo = $path;
        }

        // 3) Handle ganti password (optional)
        if (!empty($validated['password'])) {

            // Cek password lama manual (lebih eksplisit)
            if (empty($validated['current_password']) || !Hash::check($validated['current_password'], $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                    ->withInput();
            }

            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
