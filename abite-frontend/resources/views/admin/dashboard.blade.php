@extends('layouts.app')

@section('title', 'Dasbor Admin — A-BITE')

@section('content')
<div class="hero-section">
    <span class="eyebrow">A-BITE / ADMIN</span>
    <h1>Halo, {{ Auth::user()->name ?? 'Rina' }} 👋</h1>
    <p>{{ Auth::user()->created_at->format('l, d F Y') }}</p>
</div>

<div class="content">
    <div class="section-head">
        <h2>Operasional hari ini</h2>
        <span class="muted small-text">Dapur A-BITE · Buka</span>
    </div>

    @if($attentionOrders > 0)
        <div class="alert-warning">{{ $attentionOrders }} pesanan perlu perhatian.</div>
    @endif

    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-label">Pesanan masuk</span>
            <span class="stat-value">{{ $stats['total_orders'] ?? '38' }}</span>
            <span class="stat-change">{{ $stats['order_growth'] ?? '↑ 12%' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Perlu diproses</span>
            <span class="stat-value">{{ $stats['pending_orders'] ?? '8' }}</span>
            <span class="stat-change">{{ $stats['no_driver'] ?? '3 belum ada driver' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Pendapatan</span>
            <span class="stat-value">{{ $stats['revenue'] ?? 'Rp2,486 jt' }}</span>
            <span class="stat-change">{{ $stats['revenue_growth'] ?? '↑ 8%' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Driver tersedia</span>
            <span class="stat-value">{{ $stats['available_drivers'] ?? '4/6' }}</span>
            <span class="stat-change">{{ $stats['drivers_en_route'] ?? '2 sedang mengantar' }}</span>
        </div>
    </div>

    <div class="section-head">
        <h2>Akses cepat</h2>
    </div>
    <div class="two-actions">
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">＋ Tambah menu</a>
        <a href="{{ route('admin.vouchers') }}" class="btn btn-soft">Kelola voucher</a>
    </div>

    <div class="section-head">
        <h2>Pesanan terbaru</h2>
        <a class="link-text small-text" href="{{ route('admin.orders') }}">Lihat semua</a>
    </div>

    @forelse($recentOrders as $order)
        <div class="card row-flex">
            <div>
                <b>{{ $order->order_number }}</b>
                <div class="muted small-text">{{ $order->customer_name }} · {{ $order->created_at->format('H.i') }}</div>
            </div>
            <div style="text-align:right">
                <b>{{ $order->total }}</b>
                <div class="badge-status">{{ $order->status_label ?? $order->status }}</div>
            </div>
        </div>
    @empty
        <div class="empty-state">Belum ada pesanan terbaru.</div>
    @endforelse
</div>

@include('layouts.partials._bottom-nav', [
    'items' => [
        ['route' => route('admin.dashboard'), 'icon' => '▦', 'label' => 'Dasbor', 'active' => request()->routeIs('admin.dashboard')],
        ['route' => route('admin.menu'), 'icon' => '☷', 'label' => 'Menu', 'active' => request()->routeIs('admin.menu*')],
        ['route' => route('admin.orders'), 'icon' => '▤', 'label' => 'Pesanan', 'active' => request()->routeIs('admin.orders*')],
        ['route' => route('admin.vouchers'), 'icon' => '％', 'label' => 'Voucher', 'active' => request()->routeIs('admin.vouchers*')],
    ]
])
@endsection
