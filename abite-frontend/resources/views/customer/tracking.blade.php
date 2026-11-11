@extends('layouts.app')

@section('title', 'Lacak Pesanan — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('orders') }}" class="back-btn">←</a>
    <span class="nav-title">Lacak Pesanan</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <h2 style="font:800 20px 'Plus Jakarta Sans';margin:0 0 4px">Sebentar lagi sampai!</h2>
    <p class="muted small-text">{{ $order->order_number }} · {{ $order->created_at->format('d M Y') }}, {{ $order->created_at->format('H.i') }}</p>

    <div class="promo-card">
        <span class="eyebrow">{{ strtoupper($order->status) }}</span>
        <strong>{{ $order->estimated_time ?? '22 menit lagi' }}</strong>
        <p>Estimasi tiba {{ $order->estimated_arrival ?? '12.15–12.25' }}</p>
        <span class="promo-stamp">🛵</span>
    </div>

    <div class="card">
        <div style="font-weight:700;margin-bottom:8px">Perjalanan pesanan</div>
        @foreach($order->steps as $step)
            <div class="timeline-step {{ $step['completed'] ? 'done' : '' }}">
                <span class="timeline-dot"></span>
                <div>
                    <div class="timeline-name">{{ $step['title'] }}</div>
                    <div class="muted small-text">{{ $step['time'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    @if($order->driver)
        <div class="card row-flex">
            <div>
                <div class="food-name">{{ $order->driver->name }}</div>
                <div class="muted small-text">{{ $order->driver->vehicle }} · {{ $order->driver->plate_number }}</div>
                <div class="muted small-text">Kontak driver · {{ $order->driver->phone }}</div>
            </div>
            <div class="avatar-pill">{{ substr($order->driver->name, 0, 2) }}</div>
        </div>
    @endif

    <div class="card">
        <div style="font-weight:700;margin-bottom:6px">Alamat pengiriman</div>
        <p class="muted small-text" style="margin:0">
            {{ $order->delivery_address ?? 'Rumah' }} · {{ Auth::user()->name ?? 'Nadia Putri' }}<br>
            Jl. Melati No. 98, Kebayoran Baru, Jakarta Selatan
        </p>
    </div>

    <div class="card">
        <div style="font-weight:700;margin-bottom:6px">Detail pesanan</div>
        <div class="summary-line">
            <span>Subtotal · {{ $order->total_items }} item</span>
            <b>{{ $order->subtotal }}</b>
        </div>
        @if($order->discount > 0)
            <div class="summary-line">
                <span>Diskon</span>
                <b style="color:var(--green)">−{{ money($order->discount) }}</b>
            </div>
        @endif
        <div class="summary-line">
            <span>Biaya pengiriman</span>
            <b>{{ money($order->shipping_cost) }}</b>
        </div>
        <div class="summary-line total">
            <span>Total pembayaran</span>
            <b>{{ $order->total }}</b>
        </div>
    </div>

    <a href="{{ route('support') }}" class="btn btn-outline btn-block">Butuh bantuan?</a>

    <div style="height:20px"></div>
</div>
@endsection
