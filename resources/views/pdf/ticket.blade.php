@php
use Carbon\Carbon;
$tt = $booking->timetable;
@endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>E-Ticket #{{ $booking->id }}</title>
  <style>
    *{ box-sizing:border-box; } body{ font-family: DejaVu Sans, Arial, sans-serif; color:#111; }
    .card{ border:1px solid #e5e7eb; border-radius:12px; padding:16px; }
    .row{ display:flex; gap:16px; }
    .col{ flex:1; }
    .muted{ color:#6b7280; font-size:12px; }
    .h1{ font-weight:700; font-size:20px; margin:0 0 4px; }
    .h2{ font-weight:600; font-size:14px; margin:12px 0 6px; }
    .badge{ display:inline-block; padding:4px 10px; border-radius:999px; background:#dcfce7; color:#166534; font-weight:600; font-size:12px; }
    .box{ background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:10px; }
    .right{ text-align:right; }
    .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono","Courier New", monospace; }
    .footer{ margin-top:18px; font-size:11px; color:#6b7280; }
    img.qr{ width:140px; height:140px; }
  </style>
</head>
<body>
  <div class="card">
    <div class="row" style="align-items:center;">
      <div class="col">
        <div class="h1">Puncak Tennis Club — E-Ticket</div>
        <div class="muted">Tunjukkan tiket ini saat tiba di lapangan</div>
      </div>
      <div class="col right">
        <span class="badge">CONFIRMED / PAID</span><br>
        <div class="muted">Order ID</div>
        <div class="mono">{{ $booking->payment->order_id ?? ('BOOK-'.$booking->id) }}</div>
      </div>
    </div>

    <div class="row" style="margin-top:14px;">
      <div class="col box">
        <div class="muted">Tanggal</div>
        <div><strong>{{ Carbon::parse($tt->date)->translatedFormat('d F Y') }}</strong></div>
      </div>
      <div class="col box">
        <div class="muted">Waktu</div>
        <div><strong> {{ \Carbon\Carbon::parse($tt->start_time)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::parse($tt->end_time)->format('H:i') }}</strong></div>
      </div>
      <div class="col box">
        <div class="muted">Coach</div>
        <div><strong>{{ $tt->coach->name }}</strong></div>
      </div>
      <div class="col box">
        <div class="muted">Level</div>
        <div><strong>{{ ucfirst($tt->level) }}</strong></div>
      </div>
    </div>

    <div class="row" style="margin-top:10px;">
      <div class="col box">
        <div class="muted">Nama Pemesan</div>
        <div><strong>{{ $booking->guest_name ?? optional($booking->user)->name }}</strong></div>
      </div>
      <div class="col box">
        <div class="muted">Jumlah Peserta</div>
        <div><strong>{{ $booking->person_count }} orang</strong></div>
      </div>
      <div class="col box right">
        <div class="muted">Total Pembayaran</div>
        <div><strong>Rp {{ number_format($booking->total_price,0,',','.') }}</strong></div>
      </div>
    </div>

    <div class="row" style="margin-top:14px; align-items:center;">
      <div class="col">
        <div class="h2">Kode Verifikasi</div>
        <div class="mono">{{ $booking->public_code }}</div>
        <div class="muted" style="margin-top:6px;">Pindai QR untuk verifikasi & detail booking</div>
        <div class="muted">URL: {{ $publicUrl }}</div>
      </div>
      <div class="col right">
        {{-- QR dalam bentuk inline SVG --}}
        {!! $qrSvg !!}
      </div>
    </div>

    <div class="footer">
      Dicetak: {{ now()->format('d M Y H:i') }} — Puncak Tennis Club
    </div>
  </div>
</body>
</html>
