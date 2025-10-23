@extends('admin.layout.main')

@section('title', 'Gallery Photo')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Add Gallery Photo</h2>
        <a href="/gallery-photo/create"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Add
            New Photo</a>
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="">
                <!-- GRID: 2 kolom, Title span 2 -->
                <div class="grid grid-cols-2 gap-6 items-start">
                    <!-- Row 1: Title (span 2) -->
                    <div class="col-span-2">
                        <label for="title" class="block text-left">Title</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="title" id="title" />
                    </div>

                    <!-- Row 2: Description (kiri) -->
                    <div id="desc-cell" class="flex flex-col">
                        <label for="description" class="block text-left mb-1">Description</label>
                        <textarea class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg resize-none"
                            name="description" id="description" rows="8"></textarea>
                        <!-- rows bisa kamu ubah; foto di kanan akan ikutan -->
                    </div>

                    <!-- Row 2: Upload Photo (kanan) -->
                    <div class="flex flex-col">
                        <label for="photo" class="block text-left mb-1">Upload Photo</label>

                        <label for="photo" id="photo-box"
                            class="group relative flex justify-center items-center w-full p-2 border border-slate-400 rounded-lg
               hover:cursor-pointer hover:outline hover:outline-green-normal transition overflow-hidden">
                            <i id="icon"
                                class="fa-solid fa-image text-3xl text-gray-400 group-hover:text-green-normal"></i>
                            <img id="photo-preview" class="hidden absolute object-contain max-h-full max-w-full rounded-lg"
                                alt="Preview" />
                        </label>

                        <input type="file" name="photo" id="photo" accept="image/*" hidden>
                    </div>
                </div>

                <div class="w-full mt-4">
                    <button
                        class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
                        Submit
                    </button>
                </div>
            </form>

            <script>
                // Elemen
                const imageIcon = document.getElementById('icon');
                const photoInput = document.getElementById('photo');
                const previewImg = document.getElementById('photo-preview');
                const textarea = document.getElementById('description');
                const photoBox = document.getElementById('photo-box');

                // Preview gambar
                photoInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        imageIcon.classList.add('hidden');
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                });

                // Sinkron tinggi: samakan tinggi photoBox dengan tinggi textarea
                function syncHeights() {
                    // total tinggi area isi (textarea) + border
                    const rect = textarea.getBoundingClientRect();
                    const styles = getComputedStyle(textarea);
                    const total = rect.height +
                        parseFloat(styles.marginTop) + parseFloat(styles.marginBottom);

                    // Set tinggi box foto agar sejajar
                    photoBox.style.height = rect.height + 'px';
                }

                // Jalankan awal, saat resize, dan saat tinggi textarea berubah
                syncHeights();
                window.addEventListener('resize', syncHeights);
                new ResizeObserver(syncHeights).observe(textarea);
            </script>

        </div>
    </section>
@endsection
