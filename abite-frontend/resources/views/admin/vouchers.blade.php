@extends('layouts.app')

@section('title', 'Voucher — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('admin.dashboard') }}" class="back-btn">←</a>
    <span class="nav-title">Voucher</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Voucher</h2>
        <span class="muted small-text">Promosi yang pas, pelanggan makin puas</span>
    </div>

    <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary btn-block">＋ Buat voucher</a>

    <div class="tabs" style="margin-top:14px">
        <a href="{{ route('admin.vouchers', ['status' => 'all']) }}" class="tab-item {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">Semua · {{ $vouchers->count() }}</a>
        <a href="{{ route('admin.vouchers', ['status' => 'active']) }}" class="tab-item {{ request('status') == 'active' ? 'active' : '' }}">Aktif · {{ $activeCount ?? 2 }}</a>
        <a href="{{ route('admin.vouchers', ['status' => 'expired']) }}" class="tab-item {{ request('status') == 'expired' ? 'active' : '' }}">Berakhir · {{ $expiredCount ?? 1 }}</a>
    </div>

    @forelse($vouchers as $voucher)
        <div class="card">
            <div class="row-flex">
                <b style="font-size:16px;color:var(--red)">{{ $voucher->code }}</b>
                <span class="badge-status {{ $voucher->is_active ? 'green' : 'red' }}">
                    {{ $voucher->is_active ? 'Aktif' : 'Kedaluwarsa' }}
                </span>
            </div>
            <p class="small-text" style="margin-top:6px">{{ $voucher->description }}</p>
            <div class="muted small-text" style="margin-top:4px">{{ $voucher->rules }}</div>
            <div class="summary-line" style="margin-top:8px">
                <span>Penggunaan / kuota</span>
                <b>{{ $voucher->used_count ?? 0 }} / {{ $voucher->quota }}</b>
            </div>
            <div class="two-actions" style="margin-top:10px">
                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-soft btn-sm">Edit voucher</a>
                <a href="#" class="btn btn-outline btn-sm" onclick="showToast('Riwayat penggunaan voucher {{ $voucher->code }}')">Riwayat</a>
            </div>
        </div>
    @empty
        <div class="empty-state">Belum ada voucher.</div>
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
