@extends('layouts.app')

@section('title', 'Tugas — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('logout', ['role' => 'driver']) }}" class="back-btn">←</a>
    <span class="nav-title">Tugas</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Siap antar, {{ Auth::user()->name ?? 'Budi' }}?</h2>
        <span class="muted small-text">{{ $todayTasksCount ?? 2 }} tugas hari ini · {{ Auth::user()->created_at->format('l, d M Y') }}</span>
    </div>

    <div class="card row-flex">
        <div>
            <div class="food-name">{{ Auth::user()->name ?? 'Budi Santoso' }}</div>
            <div class="muted small-text">{{ Auth::user()->vehicle ?? 'Honda Vario' }} · {{ Auth::user()->plate_number ?? 'B 4821 SJT' }}</div>
            <div class="muted small-text">Kontak driver · {{ Auth::user()->phone ?? '0812 3456 7890' }}</div>
        </div>
        <div class="avatar-pill">{{ substr(Auth::user()->name ?? 'Budi Santoso', 0, 2) }}</div>
    </div>

    <div class="row-flex" style="margin-bottom:4px">
        <span class="badge-status green">Aktif · {{ $activeTasksCount ?? 2 }}</span>
        <span class="badge-status">Selesai · {{ $completedCount ?? 8 }}</span>
    </div>

    @if($pendingWarning)
        <div class="alert-warning">{{ $pendingWarning }}</div>
    @endif

    <div class="section-head">
        <h2>Sedang diantar</h2>
    </div>

    @forelse($deliveringOrders as $order)
        <div class="card">
            <div class="row-flex">
                <b>{{ $order->order_number }}</b>
                <span class="badge-status">{{ $order->status }}</span>
            </div>
            <p class="muted small-text" style="margin:7px 0">{{ $order->created_at->format('d M Y') }} · Dipesan {{ $order->created_at->format('H.i') }}</p>
            <b>{{ $order->customer_name }} · {{ $order->delivery_type ?? 'Rumah' }}</b>
            <p class="muted small-text">{{ $order->delivery_address }}<br>{{ $order->customer_phone }} · {{ $order->delivery_notes ?? 'Pagar putih' }}</p>
            <div class="divider-line"></div>

            @foreach($order->items as $item)
                <div class="summary-line">
                    <span>{{ $item->name }}<br><small class="muted">{{ $item->quantity }} × {{ money($item->price) }}</small></span>
                    <b>{{ money($item->quantity * $item->price) }}</b>
                </div>
            @endforeach

            <div class="summary-line total">
                <span>Total pesanan</span>
                <b>{{ $order->total }}</b>
            </div>

            <a href="{{ route('driver.delivery', $order->id) }}" class="btn btn-primary btn-block" style="margin-top:10px">Lihat detail pengiriman</a>
        </div>
    @empty
        <div class="empty-state">Tidak ada pesanan yang sedang diantar.</div>
    @endforelse

    <div class="section-head">
        <h2>Antrean berikutnya</h2>
    </div>

    @forelse($queuedOrders as $order)
        <div class="card">
            <div class="row-flex">
                <b>{{ $order->order_number }}</b>
                <span class="badge-status">{{ $order->status }}</span>
            </div>
            <p class="muted small-text" style="margin-top:6px">{{ $order->customer_name }} · {{ $order->customer_phone }}<br>{{ $order->delivery_address }}</p>
            @foreach($order->items as $item)
                <div class="summary-line">
                    <span>{{ $item->quantity }} × {{ $item->name }}</span>
                    <b>{{ money($item->quantity * $item->price) }}</b>
                </div>
            @endforeach
        </div>
    @empty
        <div class="empty-state">Tidak ada antrean.</div>
    @endforelse
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
