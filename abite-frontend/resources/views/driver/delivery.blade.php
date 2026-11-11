@extends('layouts.app')

@section('title', 'Pengiriman ' . $order->order_number . ' — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('driver.tasks') }}" class="back-btn">←</a>
    <span class="nav-title">Pengiriman</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Pengiriman {{ $order->order_number }}</h2>
        <span class="muted small-text">{{ $order->created_at->format('d F Y') }} · Dipesan {{ $order->created_at->format('H.i') }}</span>
    </div>

    <div class="promo-card">
        <span class="eyebrow">{{ strtoupper($order->status) }}</span>
        <strong>{{ $order->estimated_time ?? 'Tiba 12.15–12.25' }}</strong>
        <p>{{ $order->driver_assigned ?? 'Driver ditugaskan · Budi Santoso' }}</p>
        <span class="promo-stamp">🛵</span>
    </div>

    <div class="card">
        <b style="font-size:14px">Rute pengantaran</b>

        @foreach($order->route_steps as $step)
            <div class="timeline-step {{ $step['completed'] ? 'done' : '' }}">
                <span class="timeline-dot"></span>
                <div>
                    <div class="timeline-name">{{ $step['location'] }} · {{ $step['status'] }}</div>
                    <div class="muted small-text">{{ $step['address'] }} · {{ $step['time'] }}</div>
                </div>
            </div>
        @endforeach

        <a href="https://maps.google.com" target="_blank" class="btn btn-soft btn-block" style="margin-top:12px">Buka petunjuk arah</a>
    </div>

    <div class="card">
        <b style="font-size:14px">Pelanggan · {{ $order->customer_name }}</b>
        <p class="muted small-text">{{ $order->customer_phone }}</p>
        <div class="two-actions" style="margin-top:10px">
            <a href="tel:{{ $order->customer_phone }}" class="btn btn-outline">Telepon</a>
            <button class="btn btn-soft" onclick="showToast('Membuka chat dengan pelanggan')">Chat</button>
        </div>
    </div>

    <div class="card">
        <b style="font-size:14px">Ringkasan pembayaran</b>
        @foreach($order->items as $item)
            <div class="summary-line">
                <span>{{ $item->name }}<br><small class="muted">{{ $item->quantity }} × {{ money($item->price) }}</small></span>
                <b>{{ money($item->quantity * $item->price) }}</b>
            </div>
        @endforeach
        <div class="summary-line total">
            <span>Total pembayaran</span>
            <b>{{ $order->total }}</b>
        </div>

        <div style="margin-top:10px">
            <div class="muted small-text">Metode: {{ $order->payment_method ?? 'QRIS' }}</div>
            @if($order->payment_method == 'COD')
                <div class="alert-warning">Harus menagih pembayaran ke pelanggan.</div>
            @else
                <div class="alert-success">Tidak perlu menagih pembayaran ke pelanggan.</div>
            @endif
        </div>
    </div>

    <div class="card">
        <b style="font-size:14px">Perbarui status</b>
        <p class="muted small-text" style="margin-top:4px">Status saat ini: {{ $order->status }}</p>

        <form method="POST" action="{{ route('driver.delivery.update', $order->id) }}" style="margin-top:12px">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-primary btn-block" name="new_status" value="Terkirim" onclick="return confirm('Konfirmasi pesanan telah sampai di alamat pelanggan?')">
                ✓ Terkirim
            </button>
            <p class="hint">Pilih Terkirim hanya setelah pesanan diterima pelanggan.</p>
        </form>
    </div>
</div>

<div class="bottom-nav">
    <a href="{{ route('driver.tasks') }}" class="nav-link-item {{ request()->routeIs('driver.tasks') ? 'active' : '' }}">
        <b>▤</b><span>Tugas</span>
    </a>
    <a href="{{ route('driver.profile') }}" class="nav-link-item {{ request()->routeIs('driver.profile') ? 'active' : '' }}">
        <b>♙</b><span>Profil</span>
    </a>
</div>
@endsection
