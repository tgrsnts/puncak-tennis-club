@extends('user.layout.main')

@section('title', 'Profile')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Profile</h2>
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-6">
            <form action="{{ route('profile.update', app()->getLocale()) }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 items-start">
                    {{-- Photo profile --}}
                    <div class="col-span-1 lg:col-span-2 flex flex-col gap-2 items-center group">
                        <label for="photo-profile" id="photo-profile-box"
                            class="group relative flex justify-center items-center w-40 h-40 p-2 border border-slate-400 rounded-full
                               hover:cursor-pointer hover:outline hover:outline-green-normal transition overflow-hidden bg-gray-50">
                            <i id="photo-profile-icon"
                                class="fa-solid fa-image text-3xl text-gray-400 group-hover:text-green-normal"></i>

                            <img id="photo-profile-preview" class="{{ auth()->user()->photo ? '' : 'hidden' }} absolute object-cover w-full h-full rounded-full"
                                src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/avatar-biru.webp') }}"
                                alt="Preview" />
                        </label>

                        <input type="file" name="photo" id="photo-profile" accept="image/*" hidden>
                        <label for="photo-profile" class="block text-left mb-1 group-hover:text-green-normal">
                            Upload Photo Profile
                        </label>

                        @error('photo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="flex flex-col lg:gap-2">
                        <label for="nama" class="block text-left">Nama</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="name" id="nama" value="{{ auth()->user()->name }}" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col lg:gap-2">
                        <label for="email" class="block text-left">Email</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg bg-gray-100"
                            type="email" name="email" id="email" value="{{ auth()->user()->email }}" readonly />
                        {{-- Kalau mau bisa diedit, hapus readonly dan handle validasinya --}}
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="flex flex-col lg:gap-2">
                        <label for="telepon" class="block text-left">Telepon</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="telepon" id="telepon" value="{{ auth()->user()->telepon }}" />
                        @error('telepon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="flex flex-col lg:gap-2">
                        <label for="jenis_kelamin" class="block text-left">Jenis Kelamin</label>
                        <select
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            name="jenis_kelamin" id="jenis_kelamin">
                            <option value="" disabled {{ auth()->user()->jenis_kelamin ? '' : 'selected' }}>Pilih
                                Jenis Kelamin</option>
                            <option value="L" {{ auth()->user()->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ auth()->user()->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role (read only) --}}
                    @if (auth()->user()->role)
                        <div class="flex flex-col lg:gap-2">
                            <label for="role" class="block text-left">Role</label>
                            <input
                                class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg bg-gray-100"
                                type="text" name="role" id="role" value="{{ auth()->user()->role }}" readonly />
                        </div>
                    @endif
                </div>

                {{-- Section: Ganti Password --}}
                <div class="border-t border-gray-200 pt-4 mt-2 flex flex-col gap-3">
                    <h3 class="font-semibold text-lg">Change Password</h3>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="flex flex-col lg:gap-2">
                            <label for="current_password" class="block text-left">Current Password</label>
                            <input
                                class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                                type="password" name="current_password" id="current_password" />
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col lg:gap-2">
                            <label for="new_password" class="block text-left">New Password</label>
                            <input
                                class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                                type="password" name="password" id="new_password" />
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col lg:gap-2">
                            <label for="new_password_confirmation" class="block text-left">Confirm New Password</label>
                            <input
                                class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                                type="password" name="password_confirmation" id="new_password_confirmation" />
                        </div>
                    </div>
                </div>

                <div class="w-full mt-4">
                    <button
                        class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
                        Submit
                    </button>
                </div>
            </form>

            {{-- Script preview foto profile --}}
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const icon = document.getElementById('photo-profile-icon');
                    const input = document.getElementById('photo-profile');
                    const preview = document.getElementById('photo-profile-preview');

                    if (!input || !preview || !icon) return;

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = (event) => {
                            icon.classList.add('hidden');
                            preview.src = event.target.result;
                            preview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    });
                });
            </script>
        </div>
    </section>
@endsection
