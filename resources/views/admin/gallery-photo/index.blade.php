@extends('admin.layout.main')

@section('title', 'Gallery Photo')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Gallery Photo</h2>
        <a href="{{ route('admin.gallery-photo.create') }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Add New Photo</a>
        <div class="grid grid-cols-3 gap-4">
            <div class="rounded-lg bg-white shadow-lg">
                <img class="rounded-t-lg" src="{{ asset('assets/images/prashant-gurung-5lA7dgpdHIg-unsplash.jpg') }}"
                    alt="">
                <div class="p-4 flex flex-col gap-4">
                    <div class="text-gray-900 font-medium">Coaching Tennis Sabtu Malam</div>
                    <p class="text-gray-600">Sesi latihan tenis santai setiap Sabtu malam untuk meningkatkan teknik,
                        kebugaran, dan kebersamaan.
                        Dipandu pelatih berpengalaman dengan suasana seru dan interaktif.</p>
                    <div class="flex justify-between">
                        <div class="flex gap-2">
                            <a href="gallery-photo/edit"
                                class="px-4 py-2 bg-amber-500 text-white text-sm rounded-lg">Edit</a>
                            <button class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg">Delete</button>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div>12 Oktober 2025</div>
                            <div>12.05 PM</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg bg-white shadow-lg">
                <img class="rounded-t-lg" src="{{ asset('assets/images/prashant-gurung-5lA7dgpdHIg-unsplash.jpg') }}"
                    alt="">
                <div class="p-4 flex flex-col gap-4">
                    <div class="text-gray-900 font-medium">Coaching Tennis Sabtu Malam</div>
                    <p class="text-gray-600">Sesi latihan tenis santai setiap Sabtu malam untuk meningkatkan teknik,
                        kebugaran, dan kebersamaan.
                        Dipandu pelatih berpengalaman dengan suasana seru dan interaktif.</p>
                    <div class="flex justify-between">
                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-amber-500 text-white text-sm rounded-lg">Edit</button>
                            <button class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg">Delete</button>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div>12 Oktober 2025</div>
                            <div>12.05 PM</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg bg-white shadow-lg">
                <img class="rounded-t-lg" src="{{ asset('assets/images/prashant-gurung-5lA7dgpdHIg-unsplash.jpg') }}"
                    alt="">
                <div class="p-4 flex flex-col gap-4">
                    <div class="text-gray-900 font-medium">Coaching Tennis Sabtu Malam</div>
                    <p class="text-gray-600">Sesi latihan tenis santai setiap Sabtu malam untuk meningkatkan teknik,
                        kebugaran, dan kebersamaan.
                        Dipandu pelatih berpengalaman dengan suasana seru dan interaktif.</p>
                    <div class="flex justify-between">
                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-amber-500 text-white text-sm rounded-lg">Edit</button>
                            <button class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg">Delete</button>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div>12 Oktober 2025</div>
                            <div>12.05 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
