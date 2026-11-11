@extends('layouts.app')

@section('title', 'Checkout — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('cart') }}" class="back-btn">←</a>
    <span class="nav-title">Checkout</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <h2 style="font:800 20px 'Plus Jakarta Sans';margin:0 0 4px">Checkout</h2>
    <p class="muted small-text">Periksa pesanan sebelum membayar</p>

    <div class="card">
        <div class="row-flex">
            <b>Alamat pengiriman</b>
            <a class="link-text small-text" href="{{ route('profile') }}">Ubah</a>
        </div>
        <div style="margin-top:12px">
            <b>⌂ Rumah · {{ Auth::user()->name ?? 'Nadia Putri' }}</b>
            <p class="muted small-text" style="margin:4px 0 0">
                Jl. Melati No. 98, Kebayoran Baru, Jakarta Selatan 12160<br>
                0813 8890 2211 · Pagar putih
            </p>
        </div>
    </div>

    <div class="card">
        <div class="alert-success">◷ Tiba sekitar 12.15–12.25 · 30–40 menit</div>
    </div>

    <div class="card">
        <div class="row-flex">
            <b>Pesananmu · {{ qty($cart) }} item</b>
            <a class="link-text small-text" href="{{ route('cart') }}">Ubah</a>
        </div>
        @foreach($cartItems as $item)
            <div class="summary-line">
                <span>
                    {{ $item->name }}
                    <br><small class="muted">{{ $cart[$item->id] }} × {{ money($item->price) }}</small>
                </span>
                <b>{{ money($item->price * $cart[$item->id]) }}</b>
            </div>
        @endforeach
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

    <div class="section-head">
        <h2>Metode pembayaran</h2>
    </div>

    <form action="{{ route('checkout.submit') }}" method="POST">
        @csrf
        <div class="d-grid gap-2">
            @foreach([
                ['QRIS', 'Scan dari aplikasi bank atau e-wallet'],
                ['COD', 'Bayar tunai saat pesanan tiba'],
                ['Debit', 'Kartu debit GPN, Visa, Mastercard'],
                ['Kredit', 'Kartu kredit Visa atau Mastercard']
            ] as [$method, $desc])
                <div class="card row-flex {{ $errors->has('payment') ? 'is-error' : '' }}"
                     onclick="document.querySelector('input[name=payment]').value='{{ $method }}';this.classList.add('selected');this.parentElement.querySelectorAll('.card').forEach(c=>{if(c!==this)c.classList.remove('selected')})">
                    <div>
                        <b>{{ $method }}</b>
                        <div class="muted small-text">{{ $desc }}</div>
                    </div>
                    <span style="color:var(--red)">@php echo ($voucher == $method) ? '◉' : '○'; @endphp</span>
                    <input type="radio" name="payment" value="{{ $method }}" class="d-none" {{ !$loop->first ? '' : 'checked' }}>
                </div>
            @endforeach
        </div>

        @error('payment')
            <div class="error-msg d-block">{{ $message }}</div>
        @enderror

        <div class="sticky-cta" style="margin-top:16px">
            <button type="submit" class="btn btn-primary btn-block">
                Buat pesanan · {{ money(total($cart, $foods, $discount)) }}
            </button>
        </div>
    </form>
</div>
@endsection
