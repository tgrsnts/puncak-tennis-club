@extends('layout.main')
@section('title', 'Home Page')
@section('content')

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                toast: true,
                position: 'top-end',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    <!-- Hero -->
    <section id="hero">
        <div class="relative bg-cover bg-center h-screen"
            style="background-image: url('/assets/images/moises-alex-WqI-PbYugn4-unsplash.webp');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-x-0 -bottom-36 flex justify-center drop-shadow-2xl">
                <div class="bg-white p-8 rounded-3xl flex flex-col gap-4">
                    <div class="gap-2">
                        <h1 class="font-semibold text-green-600 text-3xl">Welcome</h1>
                        <p>Book your coaching tennis now!</p>
                    </div>

                    <form action="/{{ app()->getLocale() }}/booking" method="GET"
                        class="flex gap-4 items-center border border-gray-400 px-12 py-6 rounded-full">
                        <div class="flex-1">
                            <label class="block mb-1 font-semibold">Tanggal</label>
                            <div class="relative">
                                <i class="fa-solid fa-calendar text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                                <input id="singleDate" type="text" name="date"
                                    class="w-full rounded-md border border-gray-200 pl-10 pr-4 py-2 focus:outline-none focus:ring focus:ring-green-normal"
                                    placeholder="6 Nov 2025" readonly />
                            </div>
                        </div>
                        <div class="flex items-center gap-4 pr-8">
                            <div class="flex flex-col">
                                <label class="font-bold" for="coach">Coach</label>
                                <div class="w-full max-w-sm min-w-[200px] relative">
                                    <div class="relative">
                                        <select id="coach" name="coach_id"
                                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-green-normal hover:border-green-normal shadow-sm focus:shadow-md appearance-none cursor-pointer">
                                            @foreach ($coaches as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.2" stroke="currentColor"
                                            class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="bg-green-normal hover:bg-green-normal-hover hover: cursor-pointer w-12 h-12 rounded-full">
                            <i class="fa-solid fa-search w-4 text-white"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen bg-white">

    </section>

    <!-- Testimonial -->
    <section>
        <div class="relative bg-cover bg-center h-screen"
            style="background-image: url('/assets/images/renith-r-MLU_X1d3ofQ-unsplash.webp');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-x-0 flex justify-center drop-shadow-2xl">
                <div class="flex flex-col gap-20 py-20">
                    <div class="font-bold text-white text-4xl">Testimoni</div>
                    <div class="flex gap-8">
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.webp') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.webp') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.webp') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Pastikan popup kalender tidak ketutup */
        .flatpickr-calendar {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        // Jalankan SETELAH semua resource termuat
        window.addEventListener('load', function() {
            if (!window.flatpickr) return;

            flatpickr.localize(flatpickr.l10ns.id); // pastikan locale ID aktif

            flatpickr("#singleDate", {
                locale: "id",
                dateFormat: "j M Y", // "6 Nov 2025" — pakai "j F Y" untuk "6 November 2025"
                allowInput: false,
                minDate: "today",
                monthSelectorType: "static",
                showMonths: 1,
                disableMobile: true,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.setDate(new Date(), true);
                }
            });
        });
    </script>
@endpush
