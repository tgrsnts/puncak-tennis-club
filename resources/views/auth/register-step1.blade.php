@extends('layout.auth')

@section('content')
    <div>
        <h1 class="text-black text-xl lg:text-4xl font-bold mb-2 lg:mb-4">Register</h1>
        <p class="text-md text-gray-400">Please register to continue to your account.</p>
    </div>

    <form action="/{{ app()->getLocale() }}/register" id="registerForm" method="POST" class="flex flex-col gap-3 flex-1">
        @csrf

        {{-- Email --}}
        <div class="flex flex-col">
            <label for="email">Email</label>
            <input name="email" id="email" type="text" placeholder="Masukkan email" value="{{ old('email') }}"
                class="w-full text-base px-4 py-3 rounded-md bg-gray-100 focus:outline-none focus:ring focus:ring-green-normal border @error('email') border-red-500 @else border-slate-300 @enderror">

            {{-- Tampilkan error untuk email --}}
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="flex flex-col">
            <label for="password">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center px-4">
                    <input class="hidden js-password-toggle" id="toggle-password" type="checkbox" />
                    <label for="toggle-password"
                        class="bg-gray-300 hover:bg-gray-400 js-password-label rounded px-3 py-2 text-sm text-gray-600 font-mono cursor-pointer">
                        <i class="fa-solid fa-eye"></i>
                    </label>
                </div>
                <input name="password" id="password" type="password" placeholder="Masukkan password"
                    class="js-password w-full text-base px-4 py-3 rounded-md bg-gray-100 focus:outline-none focus:ring focus:ring-green-normal border @error('password') border-red-500 @else border-slate-300 @enderror">
            </div>

            {{-- Tampilkan error untuk password --}}
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="flex flex-col">
            <label for="password_confirmation">Confirm Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center px-4">
                    <input class="hidden js-password-toggle" id="toggle-confirm-password" type="checkbox" />
                    <label for="toggle-confirm-password"
                        class="bg-gray-300 hover:bg-gray-400 js-password-label rounded px-3 py-2 text-sm text-gray-600 font-mono cursor-pointer">
                        <i class="fa-solid fa-eye"></i>
                    </label>
                </div>
                <input name="password_confirmation" id="password_confirmation" type="password"
                    placeholder="Masukkan password"
                    class="js-password w-full text-base px-4 py-3 rounded-md bg-gray-100 focus:outline-none focus:ring focus:ring-green-normal border @error('password_confirmation') border-red-500 @else border-slate-300 @enderror">
            </div>

            {{-- Tampilkan error untuk konfirmasi password --}}
            @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="mt-4 p-3 rounded-md bg-yellow-normal hover:bg-yellow-normal-hover text-white">
            Sign Up
        </button>

        <div class="mt-2 text-center text-sm">
            Sudah punya akun?
            <a href="/login"
                class="text-green-normal hover:text-green-normal-hover underline underline-offset-4">Login!</a>
        </div>
    </form>
@endsection
