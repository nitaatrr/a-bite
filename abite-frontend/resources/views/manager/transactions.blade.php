@extends('layouts.app')

@section('title', 'Transaksi — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('manager.analytics') }}" class="back-btn">←</a>
    <span class="nav-title">Transaksi</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Transaksi</h2>
        <span class="muted small-text">Pantau pembayaran, tanpa terlewat</span>
    </div>

    <div class="card">
        <span class="muted small-text">Total pembayaran diterima</span>
        <div class="price" style="font:800 24px 'Plus Jakarta Sans'">{{ $transactions['total_received'] ?? 'Rp14.860.000' }}</div>
        <span class="muted small-text">
            {{ $transactions['paid_count'] ?? '186' }} transaksi lunas ·
            {{ $transactions['pending_count'] ?? '4' }} menunggu
        </span>
    </div>

    <form class="mt-3" method="GET">
        <input class="form-input search-input" name="q" value="{{ request('q') }}" placeholder="🔍 Cari nomor pesanan">
    </form>

    <div class="date-range-picker" style="margin-top:10px">
        <input type="date" name="from_date" value="{{ old('from_date', request('from_date')) }}" style="width:48%">
        <div class="date-separator" style="width:4%">—</div>
        <input type="date" name="to_date" value="{{ old('to_date', request('to_date')) }}" style="width:48%">
    </div>

    <div class="tabs" style="margin-top:14px">
        <a href="{{ route('manager.transactions', ['status' => 'all']) }}" class="tab-item {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('manager.transactions', ['status' => 'paid']) }}" class="tab-item {{ request('status') == 'paid' ? 'active' : '' }}">Lunas</a>
        <a href="{{ route('manager.transactions', ['status' => 'pending']) }}" class="tab-item {{ request('status') == 'pending' ? 'active' : '' }}">Menunggu</a>
    </div>

    @forelse($transactionsList as $transaction)
        <div class="card">
            <div class="row-flex">
                <b>{{ $transaction->order_number }}</b>
                <span class="badge-status {{ $transaction->payment_status == 'Lunas' ? 'green' : '' }}">
                    {{ $transaction->payment_status }}
                </span>
            </div>
            <div style="margin-top:8px">
                <b>{{ $transaction->customer_name }}</b>
            </div>
            <div class="row-flex" style="margin-top:4px">
                <span class="muted small-text">{{ $transaction->payment_method }} · {{ $transaction->created_at->format('d M') }} · {{ $transaction->created_at->format('H.i') }}</span>
                <b>{{ $transaction->total }}</b>
            </div>
            <a href="{{ route('manager.transactions.detail', $transaction->id) }}" class="link-text small-text" style="display:block;margin-top:8px">
                Lihat detail transaksi →
            </a>
        </div>
    @empty
        <div class="empty-state">Tidak ada transaksi.</div>
    @endforelse

    {{-- Pagination --}}
    <div class="pagination">
        <span class="disabled">‹</span>
        <span class="current">1</span>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">›</a>
    </div>
</div>

<div class="bottom-nav">
    <a href="{{ route('manager.analytics') }}" class="nav-link-item {{ request()->routeIs('manager.analytics') ? 'active' : '' }}">
        <b>▥</b><span>Statistik</span>
    </a>
    <a href="{{ route('manager.transactions') }}" class="nav-link-item {{ request()->routeIs('manager.transactions') ? 'active' : '' }}">
        <b>▤</b><span>Transaksi</span>
    </a>
    <a href="{{ route('manager.reports') }}" class="nav-link-item {{ request()->routeIs('manager.reports') ? 'active' : '' }}">
        <b>▧</b><span>Laporan</span>
    </a>
</div>
@endsection
