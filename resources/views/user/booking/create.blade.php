@extends('user.layout.main')
@section('title', 'Book Now')

@section('content')
<section class="min-h-screen font-poppins w-full p-4 pb-20 bg-[#F4F5F9]">
  <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- LEFT: Session Summary --}}
    <div class="lg:col-span-1 rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
      <div class="flex items-center justify-between bg-gray-50 px-5 py-3">
        <div class="flex items-center gap-2 text-gray-700">
          <i class="fa-solid fa-calendar"></i>
          <span class="font-semibold">{{ \Carbon\Carbon::parse($timetable->date)->translatedFormat('d F Y') }}</span>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700">
          <i class="fa-solid fa-signal"></i> {{ $timetable->level }}
        </span>
      </div>

      <div class="p-5 space-y-4">
        {{-- Time --}}
        <div class="grid grid-cols-2 gap-3">
          <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-2">
            <i class="fa-regular fa-clock text-gray-600"></i>
            <div>
              <div class="text-xs text-gray-500">Time Start</div>
              <div class="font-semibold text-gray-800">{{ $timetable->start_time }}</div>
            </div>
          </div>
          <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-2">
            <i class="fa-regular fa-clock text-gray-600"></i>
            <div>
              <div class="text-xs text-gray-500">Time Finish</div>
              <div class="font-semibold text-gray-800">{{ $timetable->end_time }}</div>
            </div>
          </div>
        </div>

        {{-- Coach --}}
        <div class="flex items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
          <i class="fa-solid fa-user text-gray-600"></i>
          <div>
            <div class="text-xs text-gray-500">Coach</div>
            <div class="font-semibold text-gray-800">{{ $timetable->coach->name }}</div>
          </div>
        </div>

        {{-- Slot --}}
        @php
          // Static slot values
          $taken   = $timetable->current_slots;
          $max     = $timetable->max_slots;
          $remain  = max(0, $max - $taken);
          $percent = max(0, min(100, round(($taken / max(1, $max)) * 100)));
          $isFull  = $remain <= 0;
        @endphp
        <div class="space-y-2">
          <div class="flex items-center justify-between text-sm">
            <span class="text-gray-700 font-medium">Slot</span>
            <span class="text-gray-600">{{ $taken }} / {{ $max }}</span>
          </div>
          <div class="h-2 w-full rounded-full bg-gray-200 overflow-hidden">
            <div class="h-full rounded-full {{ $isFull ? 'bg-gray-400' : 'bg-emerald-500' }}" style="width: {{ $percent }}%"></div>
          </div>
          @if($isFull)
            <div class="text-xs text-red-600 font-medium">Penuh</div>
          @elseif($remain <= 2)
            <div class="text-xs text-amber-600 font-medium">Sisa {{ $remain }} slot</div>
          @endif
        </div>

        {{-- Price (per peserta) --}}
        <div class="flex items-center justify-between pt-2">
          <div class="text-gray-500 text-sm">Price (per orang)</div>
          <div class="text-lg font-bold text-gray-900">Rp {{ $timetable->price }}</div>
        </div>
      </div>
    </div>

    {{-- RIGHT: Booking Form --}}
    <div class="lg:col-span-2">
      <form action="{{ route('booking.store', ['locale' => app()->getLocale(), 'timetable' => $timetable->id]) }}" method="POST" class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6 space-y-5" id="bookingForm">
        @csrf
        
        @php $user = auth()->user(); @endphp

        {{-- Contact info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
            <input type="text" name="name" required
              class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-normal"
              placeholder="Nama kamu" value="{{ $user->name ?? '' }}">
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">No. WhatsApp</label>
            <input type="tel" name="phone" required
              class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-normal"
              placeholder="08xxxxxxxxxx" value="{{ $user->telepon ?? '' }}">
          </div>
        </div>

        {{-- person_count & Note --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Jumlah Peserta</label>
            <input type="number" min="1" max="{{ $remain ?: 1 }}" value="1" name="person_count" id="person_count"
              class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-normal"
              {{ $isFull ? 'disabled' : '' }}>
            @if($isFull)
              <p class="mt-1 text-xs text-red-600">Sesi penuh. Tidak dapat melakukan pemesanan.</p>
            @else
              <p class="mt-1 text-xs text-gray-500">Sisa slot: {{ $remain }}</p>
            @endif
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Catatan (opsional)</label>
            <input type="text" name="note"
              class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-normal"
              placeholder="Contoh: butuh raket pinjaman">
          </div>
        </div>

        {{-- Summary --}}
        <div class="rounded-xl bg-gray-50 border border-gray-200 p-4 space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-gray-600">Tanggal</span>
            <span class="font-medium">{{ \Carbon\Carbon::parse($timetable->date)->translatedFormat('d F Y') }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-gray-600">Waktu</span>
            <span class="font-medium">{{ $timetable->start_time }} – {{ $timetable->end_time }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-gray-600">Coach</span>
            <span class="font-medium">{{ $timetable->coach->name }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-gray-600">Harga x Jumlah</span>
            <span class="font-medium" id="priceLine">Rp {{ $timetable->price }} × 1</span>
          </div>
          <div class="border-t border-gray-200 pt-2 flex items-center justify-between">
            <span class="text-gray-700 font-semibold">Total</span>
            <span class="text-xl font-extrabold text-gray-900" id="totalPrice">Rp {{ $timetable->price }}</span>
          </div>
        </div>

        {{-- Terms --}}
        <label class="inline-flex items-start gap-2 text-sm text-gray-600">
          <input type="checkbox" name="agree" class="mt-1 rounded border-gray-300" required>
          <span>Saya menyetujui ketentuan booking dan kebijakan pembatalan Puncak Tennis Club.</span>
        </label>

        {{-- CTA --}}
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="/schedule"
             class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">
            Kembali
          </a>
          <button type="submit"
            class="rounded-xl px-5 py-2.5 text-sm font-semibold text-white {{ $isFull ? 'bg-gray-300 cursor-not-allowed' : 'bg-green-normal hover:bg-green-normal-hover' }}"
            {{ $isFull ? 'disabled' : '' }}>
            Konfirmasi Booking
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

{{-- JS: update total price dinamis --}}
<script>
  (function(){
  const price = 75000;
    const input = document.getElementById('person_count');
    const line  = document.getElementById('priceLine');
    const total = document.getElementById('totalPrice');

    function formatRupiah(num){
      return new Intl.NumberFormat('id-ID').format(num);
    }

    if (input) {
      input.addEventListener('input', () => {
        let qty = parseInt(input.value || '1', 10);
        if (isNaN(qty) || qty < 1) qty = 1;
        line.textContent  = `Rp ${formatRupiah(price)} × ${qty}`;
        total.textContent = `Rp ${formatRupiah(price * qty)}`;
      });
    }
  })();
</script>
<!-- Midtrans Snap integration: intercept form submit, request snap token from server, then open Snap modal -->
<script>
  (function(){
    const form = document.getElementById('bookingForm');
    const MIDTRANS_CLIENT_KEY = "{{ env('MIDTRANS_CLIENT_KEY') }}"; // set in .env

    function loadSnap(clientKey){
      return new Promise((resolve, reject) => {
        if (window.snap) return resolve();
        if (!clientKey) return reject(new Error('Midtrans client key not set'));
        const s = document.createElement('script');
        s.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        s.setAttribute('data-client-key', clientKey);
        s.onload = () => resolve();
        s.onerror = (e) => reject(e);
        document.head.appendChild(s);
      });
    }

    async function handleSubmit(e){
      e.preventDefault();
      if (!form) return;

      // prevent double submit
      if (form.dataset.processing === '1') return;
      form.dataset.processing = '1';

      const url = form.action;
      const fd = new FormData(form);

      // get csrf token from hidden input
      const csrfInput = form.querySelector('input[name="_token"]');
      const csrf = csrfInput ? csrfInput.value : '';

      try{
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
          },
          body: fd
        });

        if (!res.ok) {
          const text = await res.text();
          console.error('Booking request failed', res.status, text);
          alert('Gagal membuat booking. Silakan coba lagi.');
          form.dataset.processing = '0';
          return;
        }

        const data = await res.json();

        // expected { snap_token: '...', finish_redirect: '...' }
        if (data.snap_token) {
          await loadSnap(MIDTRANS_CLIENT_KEY);
          window.snap.pay(data.snap_token, {
            onSuccess: function(result){
              // redirect to finish page if provided
              if (data.finish_redirect) window.location.href = data.finish_redirect;
              else window.location.reload();
            },
            onPending: function(result){
              if (data.finish_redirect) window.location.href = data.finish_redirect;
              else alert('Payment pending. Silakan cek status pemesanan.');
            },
            onError: function(result){
              alert('Terjadi kesalahan saat proses pembayaran.');
            },
            onClose: function(){
              alert('Pembayaran ditutup. Anda dapat melanjutkan atau mencoba lagi.');
            }
          });
        } else if (data.redirect) {
          window.location.href = data.redirect;
        } else {
          alert('Respons tidak valid dari server.');
        }
      } catch(err){
        console.error(err);
        alert('Terjadi kesalahan. Coba lagi.');
      } finally {
        form.dataset.processing = '0';
      }
    }

    if (form) form.addEventListener('submit', handleSubmit);
  })();
</script>
@endsection
