@php
use Carbon\Carbon;
$tt = $booking->timetable;
$p  = $booking->payment;
@endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice #{{ $booking->id }}</title>
  <style>
    body{ font-family: DejaVu Sans, Arial, sans-serif; color:#111; }
    .wrap{ padding:18px; }
    .muted{ color:#6b7280; font-size:12px; }
    .h1{ font-weight:700; font-size:22px; margin:0; }
    .box{ background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:12px; }
    table{ width:100%; border-collapse: collapse; }
    th,td{ padding:8px; border-bottom:1px solid #e5e7eb; font-size:13px; }
    th{ text-align:left; background:#f3f4f6; }
    .right{ text-align:right; }
    .total{ font-weight:800; }
    .badge{ display:inline-block; padding:4px 10px; border-radius:999px; background:#fef3c7; color:#92400e; font-weight:600; font-size:12px; }
    .paid{ background:#dcfce7; color:#166534; }
  </style>
</head>
<body>
  <div class="wrap">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
      <div>
        <div class="h1">INVOICE</div>
        <div class="muted">Puncak Tennis Club</div>
      </div>
      <div class="right">
        <div class="muted">Invoice #</div>
        <div><strong>{{ $booking->id }}</strong></div>
        <div class="muted" style="margin-top:8px;">Order ID</div>
        <div>{{ $p->order_id ?? ('BOOK-'.$booking->id) }}</div>
        <div style="margin-top:8px;">
          <span class="badge {{ ($p?->status==='paid') ? 'paid' : '' }}">{{ strtoupper($p->status ?? 'pending') }}</span>
        </div>
      </div>
    </div>

    <div style="display:flex; gap:14px; margin-top:14px;">
      <div class="box" style="flex:1;">
        <div class="muted">Ditagihkan kepada</div>
        <div><strong>{{ $booking->guest_name ?? optional($booking->user)->name }}</strong></div>
        <div class="muted">{{ $booking->guest_phone ?? optional($booking->user)->phone }}</div>
      </div>
      <div class="box" style="flex:1;">
        <div class="muted">Tanggal Invoice</div>
        <div><strong>{{ $booking->created_at->format('d M Y') }}</strong></div>
        <div class="muted">Tanggal Sesi</div>
        <div><strong>{{ Carbon::parse($tt->date)->translatedFormat('d F Y') }} {{ $tt->start_time }}–{{ $tt->end_time }}</strong></div>
      </div>
      <div class="box" style="flex:.8;">
        <div class="muted">Metode</div>
        <div><strong>{{ strtoupper($p->payment_type ?? 'MIDTRANS') }}</strong></div>
        <div class="muted">Kode Pembayaran</div>
        <div>{{ $p->payment_code }}</div>
      </div>
    </div>

    <table style="margin-top:16px;">
      <thead>
        <tr>
          <th>Deskripsi</th>
          <th class="right">Qty</th>
          <th class="right">Harga</th>
          <th class="right">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Coaching Session — Coach {{ $tt->coach->name }} ({{ ucfirst($tt->level) }})
            <div class="muted">Tanggal {{ Carbon::parse($tt->date)->translatedFormat('d F Y') }}, {{ $tt->start_time }}–{{ $tt->end_time }}</div>
          </td>
          <td class="right">{{ $booking->person_count }}</td>
          <td class="right">Rp {{ number_format($tt->price,0,',','.') }}</td>
          <td class="right">Rp {{ number_format($booking->person_count * $tt->price,0,',','.') }}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="right total">Total</td>
          <td class="right total">Rp {{ number_format($booking->total_price,0,',','.') }}</td>
        </tr>
      </tfoot>
    </table>

    <div style="display:flex; gap:14px; margin-top:14px;">
      <div class="box" style="flex:1;">
        <div class="muted">Catatan</div>
        <div>{{ $booking->notes ?: '-' }}</div>
      </div>
      <div class="box" style="flex:0 0 140px; text-align:center;">
        {!! $qrSvg !!}
        <div class="muted">Detail/Verifikasi</div>
      </div>
    </div>

    <div class="muted" style="margin-top:16px;">
      Terima kasih! — Hubungi admin bila membutuhkan bantuan.
    </div>
  </div>
</body>
</html>
