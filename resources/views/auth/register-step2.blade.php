@extends('layout.auth')

@section('content')
    <h1 class="text-2xl font-bold text-green-700">Step 2 – Lengkapi Data Diri</h1>
    <form method="POST" action="/{{ app()->getLocale() }}/register/complete">
        @csrf
        <div>
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-md bg-gray-100" required
                value="{{ old('name') }}">
            @error('name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Telepon</label>
            <input type="text" name="telepon" class="w-full px-4 py-2 border rounded-md bg-gray-100" required
                value="{{ old('telepon') }}">
            @error('telepon')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded-md bg-gray-100" required>
                <option value="">-- Pilih --</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="mt-4 w-full bg-green-normal hover:bg-green-normal-hover text-white py-2 rounded-md">
            Selesai
        </button>
    </form>
@endsection
