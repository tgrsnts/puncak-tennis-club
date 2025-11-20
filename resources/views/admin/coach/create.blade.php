@extends('admin.layout.main')

@section('title', 'Coach')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Tambah Coach</h2>
        <a href="{{ route('admin.coach.index', app()->getLocale()) }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Kembali</a>
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="{{ route('admin.coach.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col gap-4">
                @csrf

                {{-- GLOBAL ERROR MESSAGE --}}
                {{-- @if ($errors->any())
                    <div class="p-4 rounded-lg bg-red-100 border border-red-300 text-red-700 text-sm">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

                    {{-- COACH --}}
                    <div class="flex flex-col">
                        <label for="name" class="block">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full p-2 border border-slate-400 rounded-lg">
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LEVEL --}}
                    <div class="flex flex-col">
                        <label for="specialty" class="block">Specialty</label>
                        <select name="specialty" id="specialty" class="w-full p-2 border border-slate-400 rounded-lg">
                            <option value="Beginner" {{ old('specialty') == 'Beginner' ? 'selected' : '' }}>Beginner
                            </option>
                            <option value="Intermediate" {{ old('specialty') == 'Intermediate' ? 'selected' : '' }}>
                                Intermediate</option>
                            <option value="Advanced" {{ old('specialty') == 'Advanced' ? 'selected' : '' }}>Advanced
                            </option>
                        </select>
                        @error('specialty')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PHOTO --}}
                    <div class="flex flex-col">
                        <label for="photo_url" class="block">Photo</label>

                        <label for="photo_url"
                            class="w-40 h-40 bg-gray-100 border border-slate-400 rounded-lg flex items-center justify-center cursor-pointer overflow-hidden">
                            <img id="photo-preview" class="hidden w-full h-full object-cover" />
                            <i id="photo-icon" class="fa-solid fa-image text-gray-400 text-3xl"></i>
                        </label>
                        <p class="text-sm">Upload Photo</p>

                        <input type="file" name="photo_url" id="photo_url" accept="image/*" class="hidden">

                        @error('photo_url')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('photo_url').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const preview = document.getElementById('photo-preview');
                            const icon = document.getElementById('photo-icon');

                            if (!file) return;

                            const reader = new FileReader();
                            reader.onload = (event) => {
                                preview.src = event.target.result;
                                preview.classList.remove('hidden');
                                icon.classList.add('hidden');
                            };

                            reader.readAsDataURL(file);
                        });
                    </script>


                </div>

                <button class="bg-green-dark text-white px-4 py-2 rounded-lg w-fit">
                    Submit
                </button>
            </form>

        </div>
    </section>
@endsection
