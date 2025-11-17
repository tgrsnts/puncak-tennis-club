@extends('user.layout.main')
@section('title', 'Home Page')

@section('content')
    <section class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">

        {{-- Banner filter (muncul hanya saat search) --}}
        @if ($filterDateDisplay || $filterCoach)
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <span class="text-gray-600">Menampilkan hasil untuk</span>

                @if ($filterDateDisplay)
                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                        <i class="fa-solid fa-calendar text-gray-600"></i>
                        {{ $filterDateDisplay }}
                    </span>
                @endif

                @if ($filterCoach)
                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                        <i class="fa-solid fa-user text-gray-600"></i>
                        {{ $filterCoach->name }}
                    </span>
                @endif

                <a href="{{ route('booking.index', app()->getLocale()) }}"
                    class="ml-2 text-blue-600 hover:underline">Reset</a>
            </div>
        @endif

        {{-- Grid hasil / empty state --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse ($timetables as $item)
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    {{-- Header tanggal --}}
                    <div class="flex items-center justify-between bg-gray-50 px-5 py-3">
                        <div class="flex items-center gap-2 text-gray-700">
                            <i class="fa-solid fa-calendar"></i>
                            <span class="font-semibold">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700">
                            <i class="fa-solid fa-signal"></i> {{ ucfirst($item->level) }}
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="p-5 space-y-4">
                        {{-- Time range --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-2">
                                <i class="fa-regular fa-clock text-gray-600"></i>
                                <div>
                                    <div class="text-xs text-gray-500">Time Start</div>
                                    <div class="font-semibold text-gray-800"> {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-2">
                                <i class="fa-regular fa-clock text-gray-600"></i>
                                <div>
                                    <div class="text-xs text-gray-500">Time Finish</div>
                                    <div class="font-semibold text-gray-800"> {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Coach --}}
                        <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
                            <i class="fa-solid fa-user text-gray-600"></i>
                            <div>
                                <div class="text-xs text-gray-500">Coach</div>
                                <div class="font-semibold text-gray-800">{{ $item->coach->name }}</div>
                            </div>
                        </div>

                        {{-- Slot (pakai field dinamis jika ada, fallback ke contoh statis) --}}
                        @php
                            $taken = isset($item->current_slots) ? (int) $item->current_slots : 4;
                            $max = isset($item->max_slots) ? (int) $item->max_slots : 8;
                            $percent = max(0, min(100, round(($taken / max(1, $max)) * 100)));

                        @endphp
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700 font-medium">Slot</span>
                                <span class="text-gray-600">{{ $taken }} / {{ $max }}</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-gray-200 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $percent }}%"></div>
                            </div>
                            @if ($max - $taken <= 2 && $max - $taken > 0)
                                <div class="text-xs text-amber-600 font-medium">Sisa {{ $max - $taken }} slot lagi</div>
                            @elseif($max - $taken <= 0)
                                <div class="text-xs text-red-600 font-medium">Penuh</div>
                            @endif
                        </div>

                        {{-- Price (pakai field dinamis jika ada) --}}
                        <div class="flex items-center justify-between pt-2">
                            <div class="text-gray-500 text-sm">Price</div>
                            <div class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($item->price ?? 75000, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Footer / CTA --}}
                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-white px-5 py-4">
                        {{-- <a href="{{ route('booking.detail', ['timetable' => $item->id, 'locale' => app()->getLocale()]) }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">
                            Detail
                        </a> --}}

                        @php $isFull = $taken >= $max; @endphp
                        @if ($isFull)
                            <button disabled
                                class="rounded-xl px-4 py-2 text-sm font-semibold text-white bg-gray-400 cursor-not-allowed">
                                Full
                            </button>
                        @else
                            <a href="{{ route('booking.create', ['locale' => app()->getLocale(), 'id' => $item->id]) }}"
                                class="rounded-xl px-4 py-2 text-sm font-semibold text-white bg-green-normal hover:bg-green-normal-hover">
                                Book Now
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full">
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">
                        <div
                            class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Tidak ada jadwal ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Coba ubah tanggal atau pilih coach lain, lalu lakukan pencarian kembali.
                        </p>

                        <div class="mt-4 flex items-center justify-center gap-3">
                            <a href="{{ url('/') }}"
                                class="rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                                Reset Filter
                            </a>
                            <a href="{{ route('booking.index', ['locale' => app()->getLocale()]) }}"
                                class="rounded-xl bg-green-normal px-4 py-2 text-sm font-semibold text-white hover:bg-green-normal-hover">
                                Lihat Semua Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- (Opsional) Pagination --}}
        @if (method_exists($timetables, 'links'))
            <div class="mt-4">
                {{ $timetables->links() }}
            </div>
        @endif

    </section>
@endsection
