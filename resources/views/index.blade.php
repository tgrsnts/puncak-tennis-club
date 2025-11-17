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

        </div>
        <div class="relative flex justify-center bottom-0 w-full">
            <svg class="bottom-0 rotate-180 absolute z-1 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1443 102"
                fill="none">
                <path
                    d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                    fill="white" />
            </svg>
        </div>
    </section>

    <section class="h-screen bg-white">
        <div class="flex gap-12 py-20 overflow-x-hidden">
            @foreach ($timetables as $timetable)
                <div
                    class="w-full rounded-3xl bg-green-normal shadow-md border border-gray-100 p-5 pt-0 flex flex-col gap-4">
                    <div class="relative flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 481 52" fill="none"
                            class="absolute z-1 h-8">
                            <path
                                d="M480.307 -1.43269e-10C430.574 0.000103166 443.109 51.5156 404.413 51.5156L75.8936 51.5156C37.1974 51.5156 49.7324 0.000103167 0 0L480.307 -1.43269e-10Z"
                                fill="white" />
                        </svg>
                        <h2 class="font-bold text-green-normal text-xl absolute z-2">
                            {{ \Carbon\Carbon::parse($timetable->date)->translatedFormat('d F Y') }}</h2>
                    </div>
                    {{-- Header: Tanggal + Level --}}
                    <div class="flex justify-end mt-8">
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            <i class="fa-solid fa-signal"></i>
                            {{ $timetable->level ?? 'All Level' }}
                        </span>
                    </div>

                    {{-- Body: Time & Coach --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="rounded-2xl bg-gray-50 px-4 py-3 flex flex-col gap-1">
                            <span class="text-xs text-gray-500">Time Start</span>
                            <div class="flex items-center gap-2 font-semibold text-gray-800">
                                <i class="fa-regular fa-clock text-sm"></i>
                                <span> {{ \Carbon\Carbon::parse($timetable->start_time)->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-gray-50 px-4 py-3 flex flex-col gap-1">
                            <span class="text-xs text-gray-500">Time Finish</span>
                            <div class="flex items-center gap-2 font-semibold text-gray-800">
                                <i class="fa-regular fa-clock text-sm"></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($timetable->end_time)->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-gray-50 px-4 py-3 flex flex-col gap-1">
                            <span class="text-xs text-gray-500">Coach</span>
                            <div class="flex items-center gap-2 font-semibold text-gray-800">
                                <i class="fa-regular fa-user text-sm"></i>
                                <span>{{ $timetable->coach->name }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Slot & Progress --}}
                    @php
                        $taken = $timetable->bookings_count ?? 0;
                        $max = $timetable->max_slot ?? 5;
                        $percent = $max > 0 ? ($taken / $max) * 100 : 0;
                    @endphp

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between text-xs text-white">
                            <span>Slot</span>
                            <span class="font-semibold">{{ $taken }} / {{ $max }}</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-white overflow-hidden">
                            <div class="h-2 rounded-full bg-green-normal" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>

                    {{-- Footer: Price + Button --}}
                    <div class="flex items-center justify-between gap-4 pt-2">
                        <div class="flex flex-col">
                            <span class="text-xs text-white">Price</span>
                            <span class="text-lg font-bold text-white">
                                Rp {{ number_format($timetable->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ route('booking.create', ['locale' => app()->getLocale(), 'id' => $timetable->id]) }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-yellow-normal px-6 py-3 text-sm font-semibold text-white shadow hover:bg-yellow-normal-hover transition">
                            Book Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="h-full bg-green-normal flex flex-col items-center gap-20 px-20">
        <div class="relative flex justify-center w-full">
            <svg class="absolute z-1 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1443 102" fill="none">
                <path
                    d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                    fill="white" />
            </svg>
            <h2 class="font-bold text-green-normal text-4xl absolute z-2">Tentang Kami</h2>
        </div>

        <div class="flex gap-12">
            <div class="flex flex-col gap-8 w-6/10">
                <h2 class="font-bold text-white text-4xl">Puncak Tennis Club</h2>
                <p class="text-white">Puncak Tennis Club atau biasa disebut PTC adalah komunitas pecinta tenis yang ada di
                    wilayah Puncak. Klub ini
                    dibuat untuk menyalurkan hobi tenis, menambah teman, dan juga menjaga kebugaran lewat kegiatan olahraga
                    bareng.</p>
                <div class="bg-white text-green-normal gap-8 p-4 rounded-lg flex w-fit">
                    <div class="font-medium">Join Us</div>
                    <div class="flex gap-4 items-center">
                        <a href="">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-instagram text-2xl"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-tiktok text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <img class="w-4/10" src="{{ asset('assets/images/about.png') }}" alt="">
        </div>

        <div class="bg-white w-full px-12 pb-12 rounded-3xl gap-20 flex flex-col items-center">
            <div class="top-0 relative flex justify-center w-full">
                <svg class="absolute z-1 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1443 102" fill="none">
                    <path
                        d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                        fill="#388132" />
                </svg>
                <h2 class="font-bold text-white text-3xl absolute z-2">Our Service</h2>
            </div>
            <div class="flex flex-col gap-12 text-green-normal font-semibold text-2xl">
                <div class="flex gap-12">
                    <div>
                        3 hours coaching
                    </div>
                    <div>
                        Coach Professional
                    </div>
                    <div>
                        Ballboy
                    </div>
                </div>
                <div class="flex gap-12">
                    <div>
                        Free Racket and Ball
                    </div>
                    <div>
                        Free Documentation
                    </div>
                </div>
            </div>
        </div>
        <div class="relative flex justify-center bottom-0 w-full">
            <svg class="bottom-0 rotate-180 absolute z-1 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1443 102"
                fill="none">
                <path
                    d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                    fill="white" />
            </svg>
        </div>
    </section>

    <section class="h-screen bg-white flex flex-col items-center gap-20 px-20">
        <h2 class="font-bold text-green-normal text-4xl">Photo</h2>

        <div x-data="photoCarousel()" x-init="init()" class="relative mx-auto w-full flex items-center gap-4">
            <!-- Tombol kiri -->
            <button @click="prev()"
                class="grid place-items-center
             h-8 w-8 rounded-full bg-green-600 text-white shadow hover:bg-green-700"
                aria-label="Prev">‹</button>

            <!-- Track -->
            <div x-ref="track" @scroll.passive="onScroll"
                class="mt-4 flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar py-12">
                <template x-for="(src, i) in loopImages" :key="i">
                    <div class="snap-center shrink-0 transition-all duration-500 ease-out"
                        :class="centerVirtual === i ?
                            'scale-110 z-1' :
                            'scale-90 opacity-80 z-0'">
                        <img :src="src" alt=""
                            class="block rounded-2xl shadow-md object-cover
                      w-40 h-56 sm:w-48 sm:h-64 md:w-56 md:h-72 lg:w-64 lg:h-80">
                    </div>
                </template>
            </div>

            <!-- Tombol kanan -->
            <button @click="next()"
                class=" grid place-items-center
             h-8 w-8 rounded-full bg-green-600 text-white shadow hover:bg-green-700"
                aria-label="Next">›</button>
        </div>

        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

        <script>
            function photoCarousel() {
                return {
                    images: [
                        '/assets/images/photo (1).png',
                        '/assets/images/photo (2).png',
                        '/assets/images/photo (3).png',
                        '/assets/images/photo (4).png',
                        '/assets/images/photo (5).png',
                    ],
                    CLONE: 2,
                    loopImages: [],
                    centerVirtual: 2, // gunakan ini untuk efek besar-kecil
                    centerIndex: 2, // index asli (opsional, buat caption dlsb)
                    step: 0,
                    autoTimer: null,

                    init() {
                        // clones kiri/kanan
                        const head = this.images.slice(0, this.CLONE);
                        const tail = this.images.slice(-this.CLONE);
                        this.loopImages = [...tail, ...this.images, ...head];
                        // di init(), setelah this.loopImages dibentuk:
                        this.$nextTick(() => {
                            // posisikan ke item ‘tengah’ (mis. index real ke-3)
                            const startVirtual = this.CLONE + 2; // 2 => gambar ke-3 (0-based)
                            this.scrollToIndex(startVirtual, false);
                            this.updateCenter();

                        });

                        this.$nextTick(() => {
                            // ukuran langkah = lebar kartu + gap
                            const anyImg = this.$refs.track.querySelector('img');
                            const gap = 32; // gap-8 = 2rem = 32px
                            this.step = anyImg ? anyImg.clientWidth + gap : 400;

                            // posisikan awal ke item real pertama (virtual = CLONE)
                            this.scrollToIndex(this.CLONE, false);
                            this.updateCenter();

                            this.$refs.track.addEventListener('scroll', this.onScroll, {
                                passive: true
                            });

                            window.addEventListener('resize', () => {
                                const img2 = this.$refs.track.querySelector('img');
                                this.step = img2 ? img2.clientWidth + gap : 400;
                                // re-center tanpa animasi
                                this.scrollToIndex(this.centerVirtual, false);
                                this.updateCenter();
                            }, {
                                passive: true
                            });
                        });

                        // autoplay
                        this.play();
                    },

                    onScroll: function() {
                        clearTimeout(this._t);
                        this._t = setTimeout(() => {
                            this.updateCenter();
                            this.normalizeIfNeeded();
                        }, 40);
                    },

                    play() {
                        this.stop();
                        this.autoTimer = setInterval(() => this.next(), 3000);
                    },
                    stop() {
                        if (this.autoTimer) clearInterval(this.autoTimer);
                        this.autoTimer = null;
                    },

                    next() {
                        this.scrollToIndex(this.centerVirtual + 1);
                    },
                    prev() {
                        this.scrollToIndex(this.centerVirtual - 1);
                    },

                    // SCROLL KE TENGAH LAYAR (bukan ke kiri)
                    scrollToIndex(vIndex, smooth = true) {
                        const track = this.$refs.track;
                        const kids = track.children;
                        const clamp = i => Math.max(0, Math.min(i, kids.length - 1));
                        const idx = clamp(vIndex);

                        const card = kids[idx];
                        const leftAbs = card.offsetLeft - (track.clientWidth - card.clientWidth) / 2;

                        track.scrollTo({
                            left: leftAbs,
                            behavior: smooth ? 'smooth' : 'auto'
                        });

                        // Setelah scroll selesai, sinkronkan 'centerVirtual'
                        // (tunggu frame berikutnya supaya posisi final terbaca)
                        requestAnimationFrame(() => this.updateCenter());
                    },

                    // DETEKSI ELEMEN PALING TENGAH DENGAN RECT
                    updateCenter() {
                        const track = this.$refs.track;
                        const kids = Array.from(track.children);
                        const tr = track.getBoundingClientRect();
                        const midX = tr.left + tr.width / 2;

                        let nearest = 0,
                            minDiff = Infinity;
                        kids.forEach((el, i) => {
                            const r = el.getBoundingClientRect();
                            const center = r.left + r.width / 2;
                            const d = Math.abs(center - midX);
                            if (d < minDiff) {
                                minDiff = d;
                                nearest = i;
                            }
                        });

                        this.centerVirtual = nearest;

                        // index asli (0..N-1) bila perlu
                        const real = (nearest - this.CLONE + this.images.length) % this.images.length;
                        this.centerIndex = real;
                    },

                    // INFINITE: lompat diam-diam saat masuk area clone
                    normalizeIfNeeded() {
                        const firstReal = this.CLONE;
                        const lastReal = this.CLONE + this.images.length - 1;

                        if (this.centerVirtual <= firstReal - 1) {
                            const target = this.centerVirtual + this.images.length;
                            this.scrollToIndex(target, false);
                            this.centerVirtual = target;
                        } else if (this.centerVirtual >= lastReal + 1) {
                            const target = this.centerVirtual - this.images.length;
                            this.scrollToIndex(target, false);
                            this.centerVirtual = target;
                        }
                    }
                }
            }
        </script>
    </section>

    <section class="h-full bg-green-normal flex flex-col items-center gap-20 px-20">
        <div class="relative flex justify-center w-full">
            <svg class="absolute z-1 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1443 102" fill="none">
                <path
                    d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                    fill="white" />
            </svg>
            <h2 class="font-bold text-green-normal text-4xl absolute z-2">Practice Location</h2>
        </div>

        <div class="flex gap-12 w-full">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.6096179288757!2d106.9548921!3d-6.695177600000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69b7b31516a355%3A0x3c7de4666412cc3a!2sPuri%20Anandita!5e0!3m2!1sid!2sid!4v1762941880701!5m2!1sid!2sid"
                class="w-full" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="relative flex justify-center bottom-0 w-full">
            <svg class="bottom-0 rotate-180 absolute z-1 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1443 102"
                fill="none">
                <path
                    d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                    fill="white" />
            </svg>
        </div>
    </section>

    <section class="h-full bg-white flex flex-col items-center gap-20 px-20">
        <h2 class="font-bold text-green-normal text-4xl">Our Partner</h2>

        <div class="flex gap-20 pb-20">
            <img class="w-40" src="{{ asset('assets/images/partner (1).png') }}" alt="">
            <img class="w-40" src="{{ asset('assets/images/partner (2).png') }}" alt="">
            <img class="w-40" src="{{ asset('assets/images/partner (3).png') }}" alt="">
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Pastikan popup kalender tidak ketutup */
        .flatpickr-calendar {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
