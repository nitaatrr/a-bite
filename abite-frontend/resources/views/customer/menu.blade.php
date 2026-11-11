@extends('layouts.app')

@section('title', 'Menu — A-BITE')

@section('content')
<div class="hero-section">
    <h1>Mau makan apa, Nadia?</h1>
    <p class="muted">⌖ Antar ke Rumah · Jl. Melati No. 98</p>
</div>

<div class="content">
    <form class="mt-3" method="GET">
        <input class="form-input search-input" name="q" value="{{ request('q') }}" placeholder="⌕ Cari menu atau rasa favoritmu">
    </form>

    <div class="promo-card">
        <span class="eyebrow">SPESIAL HARI INI</span>
        <strong>Bikin kenyang,<br>tetap hemat 15%.</strong>
        <p>Pakai HEMAT15 · Min. Rp60.000<br>Maks. diskon Rp15.000</p>
        <span class="promo-stamp">🍱</span>
    </div>

    <div class="tabs">
        @foreach(['Semua','Nasi','Ayam','Minuman'] as $f)
            <a href="{{ route('menu', ['filter' => $f]) }}" class="tab-item {{ request('filter') == $f || (!request('filter') && $f == 'Semua') ? 'active' : '' }}">{{ $f }}</a>
        @endforeach
    </div>

    <div class="section-head">
        <h2>Favorit untukmu</h2>
        <span class="muted small-text">{{ $foods->count() }} menu</span>
    </div>

    <div class="food-grid">
        @forelse($foods as $food)
            <div class="card food-card">
                <img src="{{ $food->image_url }}" alt="{{ $food->name }}">
                <div class="food-name">{{ $food->name }}</div>
                <p class="food-desc">{{ $food->description }}</p>
                <div class="food-actions">
                    <span class="food-price">{{ money($food->price) }}</span>
                    @if(isset($cart[$food->id]))
                        <div class="qty-selector">
                            <a href="{{ route('cart.change', ['food_id' => $food->id, 'change' => -1]) }}" style="text-decoration:none">−</a>
                            {{ $cart[$food->id] }}
                            <a href="{{ route('cart.change', ['food_id' => $food->id, 'change' => 1]) }}" style="text-decoration:none">+</a>
                        </div>
                    @else
                        <a href="{{ route('cart.change', ['food_id' => $food->id, 'change' => 1]) }}" class="btn btn-soft btn-sm">Tambah</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">Tidak ada menu tersedia.</div>
        @endforelse
    </div>

    @if(qty($cart) > 0)
        <div class="sticky-cta">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">
                Lihat keranjang · {{ qty($cart) }} item · {{ money(subtotal($cart, $foods)) }} →
            </a>
        </div>
    @endif
</div>

@include('layouts.partials._bottom-nav', [
    'items' => [
        ['route' => route('menu'), 'icon' => '⌂', 'label' => 'Menu', 'active' => request()->routeIs('menu')],
        ['route' => route('cart'), 'icon' => '▣', 'label' => 'Keranjang', 'active' => request()->routeIs('cart')],
        ['route' => route('orders'), 'icon' => '▤', 'label' => 'Pesanan', 'active' => request()->routeIs('orders')],
    ]
])
@endsection
