@extends('layouts.app')

@section('title', 'Daftar — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('login') }}" class="back-btn">←</a>
    <span class="nav-title">Daftar</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="eyebrow">A-BITE</div>
    <h1 style="font:800 22px 'Plus Jakarta Sans';margin:10px 0 6px;line-height:1.2">Selangkah lagi ke<br>rasa favoritmu.</h1>
    <p class="muted" style="margin-bottom:20px">Fast Delivery, Every Bite</p>
    <h3 style="font:700 18px 'Plus Jakarta Sans';margin:16px 0 10px">Buat akun baru</h3>

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <div class="field">
            <label>Nama lengkap</label>
            <input class="form-input" type="text" name="name" placeholder="Masukkan Nama Lengkap" value="{{ old('name') }}">
            @error('name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label>Email</label>
            <input class="form-input" type="email" name="email" placeholder="Email@email.com" value="{{ old('email') }}">
            @error('email')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label>Kata sandi</label>
            <input class="form-input" type="password" name="password" placeholder="Buat kata sandi">
            <span class="hint">Minimal 8 karakter, gunakan huruf dan angka.</span>
            @error('password')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div style="margin:12px 0">
            <label style="display:flex;align-items:flex-start;gap:8px;cursor:pointer">
                <input type="checkbox" name="terms" style="margin-top:3px;flex-shrink:0">
                <span class="small-text">Saya menyetujui <a class="link-text" href="#">Syarat & Ketentuan</a> serta <a class="link-text" href="#">Kebijakan Privasi</a> A-BITE.</span>
            </label>
            @error('terms')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block" style="margin-top:18px">Daftar sekarang</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a class="link-text" href="{{ route('login') }}">Masuk</a>
    </div>
</div>
@endsection
