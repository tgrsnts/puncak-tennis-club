@extends('admin.layout.main')

@section('title', 'Gallery Photo')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Gallery Photo</h2>

        <a href="{{ route('admin.gallery-photo.create', app()->getLocale()) }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
            Add New Photo
        </a>

        <div class="mt-4">
            @forelse ($galleries as $gallery)
                @if ($loop->first)
                    <div class="grid grid-cols-3 gap-4">
                @endif

                    <div class="rounded-lg bg-white shadow-lg flex flex-col gallery-item" data-id="{{ $gallery->id }}">
                        @php
                            $src = $gallery->img
                                ? asset($gallery->img)
                                : asset('assets/images/placeholder-image.png');
                        @endphp

                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $src }}"
                            alt="{{ $gallery->title ?? 'Photo' }}">

                        <div class="p-4 flex flex-col gap-4 grow">
                            <div class="text-gray-900 font-medium line-clamp-2">{{ $gallery->title }}</div>

                            @if(!empty($gallery->content))
                                <p class="text-gray-600 line-clamp-3">{{ $gallery->content }}</p>
                            @endif

                            <div class="mt-auto flex justify-between items-end">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.gallery-photo.edit', ['locale' => app()->getLocale(), 'gallery' => $gallery->id]) }}"
                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-lg">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.gallery-photo.destroy', ['locale' => app()->getLocale(), 'gallery' => $gallery->id]) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                                <div class="text-sm text-gray-600 text-right">
                                    <div>{{ $gallery->created_at?->locale('id')->translatedFormat('d F Y') }}</div>
                                    <div>{{ $gallery->created_at?->format('H.i') }} WIB</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($loop->last)
                        </div>
                    @endif
            @empty
                <div class="rounded-lg bg-white border border-gray-200 p-8 text-center text-gray-600">
                    Belum ada foto. Klik <strong>Add New Photo</strong> untuk menambahkan.
                </div>
            @endforelse
        </div>

        @if ($galleries->hasPages())
            <div class="mt-6">
                {{ $galleries->withQueryString()->links() }}
            </div>
        @endif
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-form').forEach((form) => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const formAction = form.getAttribute('action');
                    const csrfToken = form.querySelector('input[name="_token"]').value;
                    const galleryItem = form.closest('.gallery-item');
                    const galleryId = galleryItem ? galleryItem.dataset.id : 'unknown';

                    console.log('Deleting gallery ID:', galleryId);
                    console.log('Form action:', formAction);

                    if (typeof Swal === 'undefined') {
                        if (confirm('Yakin ingin menghapus? Data foto akan terhapus permanen!')) {
                            form.submit();
                        }
                        return;
                    }

                    const result = await Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data foto akan terhapus permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#388132',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    });

                    if (!result.isConfirmed) return;

                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Sedang menghapus foto',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const response = await fetch(formAction, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        });

                        const data = await response.json();
                        
                        Swal.close();

                        if (data.success) {
                            // Remove element from DOM with animation
                            if (galleryItem) {
                                galleryItem.style.opacity = '0';
                                galleryItem.style.transition = 'opacity 0.3s ease';
                                setTimeout(() => {
                                    galleryItem.remove();
                                    
                                    // Check if grid is empty and reload if needed
                                    const gridContainer = document.querySelector('.grid.grid-cols-3');
                                    if (gridContainer && gridContainer.children.length === 0) {
                                        location.reload();
                                    }
                                }, 300);
                            }
                            
                            await Swal.fire('Terhapus!', data.message, 'success');
                        } else {
                            await Swal.fire('Gagal!', data.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.close();
                        await Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            });
        });
    </script>

    <style>
        .gallery-item {
            transition: opacity 0.3s ease;
        }
    </style>
@endsection