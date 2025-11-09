@extends('user.layout.main')
@section('title', 'Detail Riwayat Booking')

@section('content')
    <section class="min-h-screen font-poppins w-full p-4 pb-20 bg-[#F4F5F9]">
        <div class="max-w-4xl mx-auto space-y-5">

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold">Detail Riwayat Booking</h2>
                <a href="{{ route('history.index', ['locale' => app()->getLocale()]) }}"
                    class="text-sm font-semibold text-gray-700 hover:underline">
                    ← Kembali ke Riwayat
                </a>
            </div>

            {{-- Status + Order --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="space-y-1">
                        <div class="text-sm text-gray-500">Nomor Order</div>
                        <div class="font-mono font-semibold text-gray-900">{{ $booking->id }}</div>
                    </div>

                    @php
                        $status = strtolower($booking->status);
                        $badge = match ($status) {
                            'paid', 'settlement', 'capture' => 'bg-green-100 text-green-700',
                            'pending', 'challenge' => 'bg-amber-100 text-amber-700',
                            'cancel', 'deny', 'expire' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                        $statusLabel = ucfirst($status === 'paid' ? 'Paid' : $status);
                    @endphp

                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm {{ $badge }}">
                        <i class="fa-solid fa-receipt"></i> {{ $statusLabel }}
                    </span>
                </div>

                @if (!empty($booking->payment?->payment_type))
                    <div class="mt-3 text-sm text-gray-600">
                        Metode Pembayaran: <span
                            class="font-medium text-gray-800">{{ strtoupper($booking->payment->payment_type) }} - {{ $booking->payment->va_bank }}</span>
                    </div>
                @endif
            </div>

            {{-- Ringkasan Sesi --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-5 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
                        <i class="fa-regular fa-calendar text-gray-600"></i>
                        <div>
                            <div class="text-xs text-gray-500">Tanggal</div>
                            <div class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($booking->timetable->date)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
                        <i class="fa-regular fa-clock text-gray-600"></i>
                        <div>
                            <div class="text-xs text-gray-500">Waktu</div>
                            <div class="font-semibold text-gray-800">
                                {{ $booking->timetable->start_time }} – {{ $booking->timetable->end_time }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
                        <i class="fa-solid fa-user text-gray-600"></i>
                        <div>
                            <div class="text-xs text-gray-500">Coach</div>
                            <div class="font-semibold text-gray-800">{{ $booking->timetable->coach->name }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
                        <i class="fa-solid fa-signal text-gray-600"></i>
                        <div>
                            <div class="text-xs text-gray-500">Level</div>
                            <div class="font-semibold text-gray-800">{{ ucfirst($booking->timetable->level) }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <div class="text-gray-600">Jumlah Peserta</div>
                        <div class="font-semibold text-gray-900">{{ $booking->person_count }} orang</div>
                    </div>
                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <div class="text-gray-600">Total Pembayaran</div>
                        <div class="text-lg font-extrabold text-gray-900">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline mini (opsional) --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-5">
                <h3 class="font-semibold mb-3">Status Pembayaran</h3>
                <ol class="relative border-s border-gray-200 ms-3 space-y-4">
                    <li class="ms-4">
                        <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-gray-300"></div>
                        <div class="text-sm text-gray-600">Dibuat:
                            <span class="font-medium text-gray-800">{{ $booking->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </li>
                    @if ($booking->payment->status === 'paid' && !empty($booking->payment?->settlement_time))
                        <li class="ms-4">
                            <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-green-500"></div>
                            <div class="text-sm text-gray-600">Diselesaikan:
                                <span
                                    class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->payment->settlement_time)->format('d M Y H:i') }}</span>
                            </div>
                        </li>
                    @elseif(in_array($booking->payment->status, ['pending', 'challenge']))
                        <li class="ms-4">
                            <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-amber-500"></div>
                            <div class="text-sm text-amber-700">Menunggu pembayaran</div>
                        </li>
                    @elseif(in_array($booking->payment->status, ['expire', 'cancel', 'deny']))
                        <li class="ms-4">
                            <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-red-500"></div>
                            <div class="text-sm text-red-700">Transaksi {{ ucfirst($booking->payment->status) }}</div>
                        </li>
                    @endif
                </ol>
            </div>

            {{-- Actions --}}
            <div
                class="rounded-2xl bg-white border border-gray-200 shadow-sm p-5 flex flex-wrap items-center justify-between gap-3">
                <div class="text-xs text-gray-500">
                    Tunjukkan e-tiket ini ke petugas saat datang ke lapangan.
                </div>
                <div class="flex gap-3">
                    {{-- Download E-Ticket / Invoice (sesuaikan route) --}}
                    {{-- <a href="{{ route('booking.ticket', ['locale' => app()->getLocale(), 'id' => $booking->id]) }}"  --}}
                    <a href=""
                        class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200">
                        Download E-Tiket
                    </a>
                    {{-- <a href="{{ route('booking.invoice', ['locale' => app()->getLocale(), 'id' => $booking->id]) }}" --}}
                    <a href=""
                        class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200">
                        Download Invoice
                    </a>

                    {{-- Bayar Sekarang (hanya saat pending/challenge) --}}
                    @if (in_array($booking->payment->status, ['pending', 'challenge']))
                        <button id="payNow"
                            class="rounded-xl px-4 py-2 text-sm font-semibold text-white bg-green-normal hover:bg-green-normal-hover">
                            Bayar Sekarang
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </section>

    {{-- Midtrans Snap (hanya jika ada tombol bayar) --}}
    @if (in_array($booking->payment->status, ['pending', 'challenge']))
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            (function() {
                const btn = document.getElementById('payNow');
                if (!btn) return;

                // Token yang tersimpan saat create (payment_code)
                const existingToken = @json($booking->payment->payment_code);

                // Helper untuk buka popup Snap
                function openSnap(token) {
                    if (!window.snap || !token) {
                        alert('Gagal memuat pembayaran.');
                        return;
                    }
                    window.snap.pay(token, {
                        onSuccess: function() {
                            window.location.reload();
                        },
                        onPending: function() {
                            window.location.reload();
                        },
                        onError: function() {
                            alert('Terjadi kesalahan pembayaran. Coba lagi.');
                        },
                        onClose: function() {
                            /* user menutup popup, diamkan saja */
                        }
                    });
                }

                // Regenerasi token (kalau token lama invalid/expire)
                async function regenerateAndOpen() {
                    try {
                        const url =
                            "{{ route('booking.snap', ['locale' => app()->getLocale(), 'booking' => $booking->id]) }}";
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                            // body tidak perlu; server bangun payload dari data booking
                        });

                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        const json = await res.json();

                        // Perhatikan: controller kamu mengembalikan "snap_token"
                        const token = json.snap_token || json.token; // fallback kalau suatu saat berubah
                        if (!token) throw new Error('Token kosong');

                        openSnap(token);
                    } catch (e) {
                        console.error(e);
                        alert('Tidak dapat memproses pembayaran saat ini.');
                    }
                }

                btn.addEventListener('click', function() {
                    // 1) Coba pakai token yang sudah ada
                    if (existingToken) {
                        try {
                            openSnap(existingToken);
                            return;
                        } catch (_) {
                            // 2) Kalau gagal (mis. token expired), regenerate
                            regenerateAndOpen();
                        }
                    } else {
                        // Tidak ada token tersimpan → regenerate
                        regenerateAndOpen();
                    }
                });
            })();
        </script>
    @endif

@endsection
