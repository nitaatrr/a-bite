@extends('layouts.app')

@section('title', 'Keranjang — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('menu') }}" class="back-btn">←</a>
    <span class="nav-title">Keranjang</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <h2 style="font:800 20px 'Plus Jakarta Sans';margin:0 0 4px">Keranjangmu</h2>
    <p class="muted small-text">{{ qty($cart) }} item, siap bikin harimu lebih enak</p>

    <div class="section-head">
        <h2>Pilihanmu</h2>
        <a class="link-text small-text" href="{{ route('menu') }}">Tambah menu</a>
    </div>

    @if(count($cartItems) > 0)
        @foreach($cartItems as $item)
            <div class="card">
                <div class="row-flex">
                    <div class="row-start">
                        <img class="food-thumb" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        <div>
                            <div class="food-name">{{ $item->name }}</div>
                            <div class="muted small-text">{{ $cart[$item->id] }} × {{ money($item->price) }}</div>
                        </div>
                    </div>
                    <div class="qty-selector">
                        <a href="{{ route('cart.change', ['food_id' => $item->id, 'change' => -1]) }}" style="text-decoration:none">−</a>
                        {{ $cart[$item->id] }}
                        <a href="{{ route('cart.change', ['food_id' => $item->id, 'change' => 1]) }}" style="text-decoration:none">+</a>
                    </div>
                </div>
                <div class="row-flex" style="margin-top:10px">
                    <span></span>
                    <b>{{ money($item->price * $cart[$item->id]) }}</b>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">Keranjang masih kosong.</div>
    @endif

    <div class="card">
        <div style="font-weight:700;margin-bottom:10px">Punya voucher?</div>
        <div class="row-flex" style="margin-top:10px">
            <form class="d-flex gap-2 w-100" method="GET" action="{{ route('voucher.apply') }}">
                <input class="form-input search-input" name="code" placeholder="Masukkan Kode Voucher" value="{{ old('code', $voucher) }}">
                <button type="submit" class="btn btn-outline btn-sm">Pakai</button>
            </form>
        </div>
        @if($discount > 0)
            <div class="alert-success" style="margin-top:10px">Voucher valid! Kamu hemat {{ money($discount) }}.</div>
        @endif
        <span class="hint">Diskon 15%, maks. Rp15.000. Min. belanja Rp60.000.</span>
    </div>

    <div class="card">
        <div style="font-weight:700;margin-bottom:6px">Ringkasan pembayaran</div>
        <div class="summary-line">
            <span>Subtotal · {{ qty($cart) }} item</span>
            <b>{{ money(subtotal($cart, $foods)) }}</b>
        </div>
        <div class="summary-line">
            <span>Diskon {{ $voucher ?: 'Voucher' }}</span>
            <b style="color:var(--green)">−{{ money($discount) }}</b>
        </div>
        <div class="summary-line">
            <span>Biaya pengiriman</span>
            <b>{{ money(qty($cart) > 0 ? 8000 : 0) }}</b>
        </div>
        <div class="summary-line total">
            <span>Total pembayaran</span>
            <b>{{ money(total($cart, $foods, $discount)) }}</b>
        </div>
    </div>

    <div class="sticky-cta">
        <a href="{{ route('checkout') }}" class="btn btn-primary btn-block" {{ count($cart) == 0 ? 'disabled' : '' }}>
            Lanjut checkout · {{ money(total($cart, $foods, $discount)) }}
        </a>
    </div>
</div>

@include('layouts.partials._bottom-nav', [
    'items' => [
        ['route' => route('menu'), 'icon' => '⌂', 'label' => 'Menu', 'active' => request()->routeIs('menu')],
        ['route' => route('cart'), 'icon' => '▣', 'label' => 'Keranjang', 'active' => request()->routeIs('cart')],
        ['route' => route('orders'), 'icon' => '▤', 'label' => 'Pesanan', 'active' => request()->routeIs('orders')],
    ]
])
@endsection
