@extends('admin.layout.main')

@section('title', 'Profile')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Profile</h2>
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="">
                <!-- GRID: 2 kolom, Title span 2 -->
                <div class="grid grid-cols-2 gap-6 items-start">
                    <div class="col-span-2 flex flex-col gap-2 items-center group">
                        <label for="photo-profile" id="photo-profile-box"
                            class="group relative flex justify-center items-center w-40 h-40 p-2 border border-slate-400 rounded-full
                        hover:cursor-pointer hover:outline hover:outline-green-normal transition overflow-hidden">
                            <i id="icon"
                                class="fa-solid fa-image text-3xl text-gray-400 group-hover:text-green-normal"></i>
                            <img id="photo-profile-preview"
                                class="hidden absolute object-contain max-h-full max-w-full rounded-lg" alt="Preview" />
                        </label>

                        <input type="file" name="photo-profile" id="photo-profile" accept="image/*" hidden>
                        <label for="photo-profile" class="block text-left mb-1 group-hover:text-green-normal">Upload Photo
                            Profile</label>
                    </div>
                    <!-- Row 1: Title (span 2) -->
                    <div class="">
                        <label for="nama" class="block text-left">Nama</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="nama" id="nama" />
                    </div>

                    <div class="">
                        <label for="role" class="block text-left">Role</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="text" name="role" id="role" />
                    </div>

                    <div class="">
                        <label for="password" class="block text-left">Password</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="password" name="password" id="password" />
                    </div>

                    <div id="desc-cell" class="flex flex-col row-span-3">
                        <label for="description" class="block text-left mb-1">Description</label>
                        <textarea class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg resize-none"
                            name="description" id="description" rows="8"></textarea>
                    </div>

                    <div class="">
                        <label for="password" class="block text-left">Old Password</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="password" name="password" id="password" />
                    </div>

                    <div class="">
                        <label for="password" class="block text-left">New Password</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="password" name="password" id="password" />
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
                const videoInput = document.getElementById('video');
                const previewImg = document.getElementById('video-preview');
                const textarea = document.getElementById('description');
                const videoBox = document.getElementById('video-box');

                // Preview gambar
                videoInput.addEventListener('change', (e) => {
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

                // Sinkron tinggi: samakan tinggi videoBox dengan tinggi textarea
                function syncHeights() {
                    // total tinggi area isi (textarea) + border
                    const rect = textarea.getBoundingClientRect();
                    const styles = getComputedStyle(textarea);
                    const total = rect.height +
                        parseFloat(styles.marginTop) + parseFloat(styles.marginBottom);

                    // Set tinggi box foto agar sejajar
                    videoBox.style.height = rect.height + 'px';
                }

                // Jalankan awal, saat resize, dan saat tinggi textarea berubah
                syncHeights();
                window.addEventListener('resize', syncHeights);
                new ResizeObserver(syncHeights).observe(textarea);
            </script>

        </div>
    </section>
@endsection
