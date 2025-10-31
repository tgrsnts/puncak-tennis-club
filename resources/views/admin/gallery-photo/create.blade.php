@extends('admin.layout.main')

@section('title', 'Gallery Photo')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Add Gallery Photo</h2>

        <a href="{{ route('admin.gallery-photo.index', app()->getLocale()) }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Kembali</a>

        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">

            <form id="gallery-form" action="{{ route('admin.gallery-photo.store', app()->getLocale()) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-6 items-start">
                    <div class="col-span-2">
                        <label for="title" class="block text-left text-black">Title</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg text-black bg-white placeholder:text-slate-500"
                            type="text" name="title" id="title" placeholder="Judul..." />
                        <p class="text-sm text-red-600 mt-1" data-error="title"></p>
                    </div>

                    <div id="desc-cell" class="flex flex-col">
                        <label for="description" class="block text-left mb-1 text-black">Description</label>
                        <textarea
                            class="w-full p-2 border text-black border-slate-400 focus:outline focus:outline-green-normal rounded-lg resize-none bg-white placeholder:text-slate-500"
                            name="content" id="description" rows="8" placeholder="Deskripsi..."></textarea>
                        <p class="text-sm text-red-600 mt-1" data-error="content"></p>
                    </div>

                    <div class="flex flex-col">
                        <label for="img" class="block text-left mb-1 text-black">Upload Photo</label>

                        <label for="img" id="photo-box"
                            class="group relative flex justify-center items-center w-full p-2 border border-slate-400 rounded-lg
                       hover:cursor-pointer hover:outline hover:outline-green-normal transition overflow-hidden bg-white text-black">
                            <i id="icon" class="fa-solid fa-image text-3xl text-gray-400 group-hover:text-green-normal"></i>
                            <img id="photo-preview" class="hidden absolute object-contain max-h-full max-w-full rounded-lg"
                                alt="Preview" />
                        </label>

                        <input type="file" name="img" id="img" accept="image/*" hidden>
                        <p class="text-sm text-red-600 mt-1" data-error="img"></p>
                    </div>
                </div>

                <div class="w-full mt-4 flex items-center gap-3">
                    <button id="submit-btn"
                        class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
                        Submit
                    </button>
                    <span id="submit-state" class="text-sm text-slate-600"></span>
                </div>
            </form>

            <script>
                // Preview
                const imageIcon = document.getElementById('icon');
                const photoInput = document.getElementById('img');
                const previewImg = document.getElementById('photo-preview');
                const textarea = document.getElementById('description');
                const photoBox = document.getElementById('photo-box');

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

                function syncHeights() {
                    const rect = textarea.getBoundingClientRect();
                    photoBox.style.height = rect.height + 'px';
                }
                syncHeights();
                window.addEventListener('resize', syncHeights);
                new ResizeObserver(syncHeights).observe(textarea);

                // ===== Fetch submit (AJAX) =====
                const form = document.getElementById('gallery-form');
                const submitBtn = document.getElementById('submit-btn');
                const submitState = document.getElementById('submit-state');

                function setErrors(errors = {}) {
                    document.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
                    Object.entries(errors).forEach(([field, msgs]) => {
                        const holder = document.querySelector(`[data-error="${field}"]`);
                        if (holder) holder.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                    });
                }

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    setErrors();
                    submitBtn.disabled = true;
                    submitState.textContent = 'Menyimpan...';

                    const formData = new FormData(form);

                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: formData
                        });

                        if (res.ok) {
                            const data = await res.json();
                            submitState.textContent = 'Tersimpan!';
                            // Redirect ke index (atau tampilkan toast)
                            window.location.href = "{{ route('admin.gallery-photo.index', app()->getLocale()) }}";
                            return;
                        }

                        // 422 validation errors
                        if (res.status === 422) {
                            const json = await res.json();
                            setErrors(json.errors || {});
                            submitState.textContent = 'Periksa kembali input.';
                        } else {
                            submitState.textContent = 'Terjadi kesalahan.';
                        }
                    } catch (err) {
                        console.error(err);
                        submitState.textContent = 'Gagal terhubung ke server.';
                    } finally {
                        submitBtn.disabled = false;
                    }
                });
            </script>
        </div>
    </section>
@endsection