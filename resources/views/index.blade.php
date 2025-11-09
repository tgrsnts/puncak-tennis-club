@extends('layout.main')
@section('title', 'Home Page')
@section('content')
    <!-- Hero -->
    <section id="hero">
        <div class="relative bg-cover bg-center h-screen"
            style="background-image: url('/assets/images/moises-alex-WqI-PbYugn4-unsplash.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-x-0 -bottom-36 flex justify-center drop-shadow-2xl">
                <div class="bg-white p-8 rounded-3xl flex flex-col gap-4">
                    <div class="gap-2">
                        <h1 class="font-semibold text-green-600 text-3xl">Welcome</h1>
                        <p>Book your coaching tennis now!</p>
                    </div>

                    <form action="/{{ app()->getLocale()}}/schedule" method="GET"
                        class="flex gap-4 items-center border border-gray-400 px-12 py-6 rounded-full">
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js" defer></script>
                        <div class="flex-1">
                            <label class="block mb-1 font-semibold">Tanggal</label>
                            <div class="relative">
                                <i class="fa-solid fa-calendar text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                                <input id="singleDate" type="text" name="date"
                                    class="w-full rounded-md border border-gray-200 pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-normal"
                                    placeholder="6 Nov 2025" readonly />
                            </div>
                            <script>
                                flatpickr("#singleDate", {
                                    locale: "id",
                                    dateFormat: "j M Y", // 6 Nov 2025 — pakai "j F Y" kalau mau full bulan (November)
                                    allowInput: false,
                                    minDate: "today",
                                    monthSelectorType: "static",
                                    showMonths: 1, // kalender tampil 2 bulan berdampingan (mirip contoh)
                                    disableMobile: true,
                                    onReady: function(selectedDates, dateStr, instance) {
                                        // auto isi default hari ini
                                        const d = new Date();
                                        instance.setDate(d, true);
                                    }
                                });
                            </script>
                        </div>
                        <div class="flex items-center gap-4 pr-8">
                            <div class="flex flex-col">
                                <label class="font-bold" for="coach">Coach</label>
                                <select id="coach" name="coach_id"
                                    class="text-gray-700 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-normal">
                                    <option selected disabled> <i class="fa-solid fa-user w-4 text-gray-700"></i> Select
                                        Coach</option>
                                    @foreach ($coaches as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
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
            style="background-image: url('/assets/images/renith-r-MLU_X1d3ofQ-unsplash.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-x-0 flex justify-center drop-shadow-2xl">
                <div class="flex flex-col gap-20 py-20">
                    <div class="font-bold text-white text-4xl">Testimoni</div>
                    <div class="flex gap-8">
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.png') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.png') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.png') }}" class="w-20 absolute -top-10"
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
