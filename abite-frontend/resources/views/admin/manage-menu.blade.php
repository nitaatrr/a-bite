@extends('layouts.app')

@section('title', 'Kelola Menu — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('admin.dashboard') }}" class="back-btn">←</a>
    <span class="nav-title">Menu</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Kelola menu</h2>
        <span class="muted small-text">{{ $foods->count() }} menu siap dipesan</span>
    </div>

    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-block">＋ Tambah menu baru</a>

    <form class="mt-3" method="GET">
        <input class="form-input search-input" name="q" value="{{ request('q') }}" placeholder="Cari nama menu">
    </form>

    <div class="tabs">
        @foreach(['Semua','Nasi','Ayam','Mie','Minuman'] as $cat)
            <a href="{{ route('admin.menu', ['category' => $cat]) }}" class="tab-item {{ request('category') == $cat || (!request('category') && $cat == 'Semua') ? 'active' : '' }}">{{ $cat }}</a>
        @endforeach
    </div>

    @forelse($foods as $food)
        <div class="card">
            <div class="food-admin-list">
                <img src="{{ $food->image_url }}" alt="{{ $food->name }}">
                <div class="grow">
                    <div class="food-name">{{ $food->name }}</div>
                    <p class="muted small-text">{{ $food->description }}</p>
                    <div class="food-price">{{ money($food->price) }}</div>
                </div>
            </div>
            <div class="two-actions" style="margin-top:12px">
                <a href="{{ route('admin.menu.edit', $food->id) }}" class="btn btn-soft btn-sm">Edit menu</a>
                <form method="POST" action="{{ route('admin.menu.destroy', $food->id) }}" class="d-inline" style="flex:1">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline btn-sm" onclick="return confirm('Yakin hapus menu {{ $food->name }}?')">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">Belum ada menu.</div>
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
