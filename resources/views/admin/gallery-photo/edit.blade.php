@extends('admin.layout.main')

@section('title', 'Gallery Photo')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Edit Gallery Photo</h2>
        
        <a href="{{ route('admin.gallery-photo.index', app()->getLocale()) }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
            Kembali
        </a>
        
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="{{ route('admin.gallery-photo.update', ['locale' => app()->getLocale(), 'gallery' => $gallery->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- GRID: 2 kolom, Title span 2 -->
                <div class="grid grid-cols-2 gap-6 items-start">
                    <!-- Row 1: Title (span 2) -->
                    <div class="col-span-2">
                        <label for="title" class="block text-left">Title</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required />
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 2: Description (kiri) -->
                    <div id="desc-cell" class="flex flex-col">
                        <label for="content" class="block text-left mb-1">Description</label>
                        <textarea 
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg resize-none"
                            name="content" id="content" rows="8">{{ old('content', $gallery->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 2: Upload Photo (kanan) -->
                    <div class="flex flex-col">
                        <label for="img" class="block text-left mb-1">Upload Photo</label>

                        <label for="img" id="photo-box"
                            class="group relative flex justify-center items-center w-full p-2 border border-slate-400 rounded-lg hover:cursor-pointer hover:outline hover:outline-green-normal transition overflow-hidden">
                            
                            @if($gallery->img)
                                <img id="photo-preview" src="{{ asset($gallery->img) }}" class="absolute object-contain max-h-full max-w-full rounded-lg" alt="Preview" />
                                <i id="icon" class="fa-solid fa-image text-3xl text-gray-400 group-hover:text-green-normal hidden"></i>
                            @else
                                <i id="icon" class="fa-solid fa-image text-3xl text-gray-400 group-hover:text-green-normal"></i>
                                <img id="photo-preview" class="hidden absolute object-contain max-h-full max-w-full rounded-lg" alt="Preview" />
                            @endif
                        </label>

                        <input type="file" name="img" id="img" accept="image/*" hidden>
                        <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                        
                        @if($gallery->img)
                        <div class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Foto saat ini: {{ basename($gallery->img) }}
                        </div>
                        @endif
                        
                        @error('img')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-full mt-4">
                    <button type="submit"
                        class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageIcon = document.getElementById('icon');
            const photoInput = document.getElementById('img');
            const previewImg = document.getElementById('photo-preview');
            const textarea = document.getElementById('content');
            const photoBox = document.getElementById('photo-box');

            // Preview gambar baru
            photoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;
                
                const reader = new FileReader();
                reader.onload = (event) => {
                    // Sembunyikan icon dan tampilkan preview
                    if (imageIcon) imageIcon.classList.add('hidden');
                    previewImg.src = event.target.result;
                    previewImg.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            });

            // Sinkron tinggi: samakan tinggi photoBox dengan tinggi textarea
            function syncHeights() {
                const rect = textarea.getBoundingClientRect();
                photoBox.style.height = rect.height + 'px';
            }

            // Jalankan awal, saat resize, dan saat tinggi textarea berubah
            syncHeights();
            window.addEventListener('resize', syncHeights);
            new ResizeObserver(syncHeights).observe(textarea);
        });
    </script>
@endsection