@extends('admin.layout.main')

@section('title', 'Gallery Video')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Edit Gallery Video</h2>
        
        <a href="{{ route('admin.gallery-video.index', app()->getLocale()) }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
            Kembali
        </a>
        
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="{{ route('admin.gallery-video.update', ['locale' => app()->getLocale(), 'video' => $video->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- GRID: 2 kolom, Title span 2 -->
                <div class="grid grid-cols-2 gap-6 items-start">
                    <!-- Row 1: Title (span 2) -->
                    <div class="col-span-2">
                        <label for="title" class="block text-left">Title</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required />
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 2: Description (kiri) -->
                    <div id="desc-cell" class="flex flex-col">
                        <label for="content" class="block text-left mb-1">Description</label>
                        <textarea 
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg resize-none"
                            name="content" id="content" rows="8">{{ old('content', $video->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 2: Upload video (kanan) -->
                    <div class="flex flex-col">
                        <label for="video" class="block text-left mb-1">Upload Video</label>

                        <label for="video" id="video-box"
                            class="group relative flex justify-center items-center w-full p-2 border border-slate-400 rounded-lg hover:cursor-pointer hover:outline hover:outline-green-normal transition overflow-hidden">
                            <i id="icon" class="fa-solid fa-video text-3xl text-gray-400 group-hover:text-green-normal"></i>
                            <span id="video-name" class="text-sm text-gray-600 ml-2">
                                {{ $video->video_path ? 'Video sudah diupload' : 'Pilih video baru' }}
                            </span>
                        </label>

                        <input type="file" name="video" id="video" accept="video/*" hidden>
                        <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah video</p>
                        
                        @if($video->video_path)
                        <div class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Video saat ini: {{ $video->video_filename }}
                        </div>
                        @endif
                        
                        @error('video')
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
            const videoIcon = document.getElementById('icon');
            const videoInput = document.getElementById('video');
            const videoName = document.getElementById('video-name');
            const textarea = document.getElementById('content');
            const videoBox = document.getElementById('video-box');

            // Show video file name when selected
            videoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    videoIcon.classList.add('hidden');
                    videoName.textContent = file.name;
                } else {
                    videoIcon.classList.remove('hidden');
                    videoName.textContent = '{{ $video->video_path ? "Video sudah diupload" : "Pilih video baru" }}';
                }
            });

            // Sinkron tinggi: samakan tinggi videoBox dengan tinggi textarea
            function syncHeights() {
                const rect = textarea.getBoundingClientRect();
                videoBox.style.height = rect.height + 'px';
            }

            // Jalankan awal, saat resize, dan saat tinggi textarea berubah
            syncHeights();
            window.addEventListener('resize', syncHeights);
            new ResizeObserver(syncHeights).observe(textarea);
        });
    </script>
@endsection