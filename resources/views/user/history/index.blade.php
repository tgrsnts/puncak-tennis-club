@extends('user.layout.main')
@section('title', 'Riwayat Booking')

@section('content')
    <section class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        {{-- Grid hasil / empty state --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse ($bookings as $item)
                <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-5">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-semibold text-lg text-gray-800">
                            {{ $item->timetable->coach->coach_name }}
                        </div>
                        <span
                            class="text-sm px-3 py-1 rounded-full 
                    {{ $item->payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-600">
                        <i class="fa-regular fa-calendar mr-2"></i>
                        {{ \Carbon\Carbon::parse($item->timetable->date)->translatedFormat('d F Y') }}
                        &nbsp; | &nbsp;
                        <i class="fa-regular fa-clock mr-2"></i>
                        {{ $item->timetable->start_time }} - {{ $item->timetable->end_time }}
                    </div>

                    <div class="flex justify-between items-center mt-3 mb-2">
                        <div class="text-gray-500 text-sm">
                            Level: <strong>{{ ucfirst($item->timetable->level) }}</strong>
                        </div>
                        <div class="text-gray-900 font-bold">
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-white">
                        <a href="{{ route('history.show', ['locale' => app()->getLocale(), 'id' => $item->id]) }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold text-white bg-green-normal hover:bg-green-normal-hover">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full">
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">
                        <div
                            class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Tidak ada riwayat ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Anda belum melakukan booking apapun.
                        </p>

                        <div class="mt-4 flex items-center justify-center gap-3">
                            <a href="{{ route('schedule.index', ['locale' => app()->getLocale()]) }}"
                                class="rounded-xl bg-green-normal px-4 py-2 text-sm font-semibold text-white hover:bg-green-normal-hover">
                                Lihat Semua Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- (Opsional) Pagination --}}
        @if (method_exists($bookings, 'links'))
            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        @endif

    </section>
@endsection
