@extends('layouts.app')

@section('title', 'Masuk — A-BITE')

@section('content')
<div class="auth-container">
    <div class="auth-header">
        <div class="brand">A-BITE</div>
        <div class="auth-subtitle">Fast Delivery, Every Bite</div>
    </div>

    <div class="auth-form">
        <h1>Lapar? Yuk, masuk.</h1>
        <p>Makanan favoritmu, hangat sampai depan pintu.</p>

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="customer">

            <div class="field">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}">
                @error('email')<div class="hint" style="color:#c0392b">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>Kata sandi</label>
                <div style="position:relative">
                    <input type="password" name="password" id="passwordField" placeholder="Masukkan kata sandi Anda" style="width:100%;padding-right:44px">
                    <button type="button" id="passwordToggle" onclick="togglePassword()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:0;cursor:pointer">👁</button>
                </div>
                @error('password')<div class="hint" style="color:#c0392b">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <span></span>
                <a class="link small" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top:20px">Masuk</button>
        </form>

        <div class="auth-foot">
            Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar sekarang</a>
        </div>

        <hr style="margin:20px 0;border-color:var(--line)">

        <div class="auth-foot" style="margin-top:16px;font-weight:700">Masuk dengan Akun Kerja:</div>
        <div style="display:grid;grid-template-columns:1fr;gap:10px;margin-top:10px">
            <a href="javascript:void(0)" class="btn btn-outline" onclick="selectRole('admin', this)" style="flex-direction:column;padding:16px">
                <span style="font-size:24px;display:block;margin-bottom:6px">🛡️</span>
                <span style="font-size:14px">Admin</span>
            </a>
            <a href="javascript:void(0)" class="btn btn-outline" onclick="selectRole('manager', this)" style="flex-direction:column;padding:16px">
                <span style="font-size:24px;display:block;margin-bottom:6px">📊</span>
                <span style="font-size:14px">Manager</span>
            </a>
            <a href="javascript:void(0)" class="btn btn-outline" onclick="selectRole('driver', this)" style="flex-direction:column;padding:16px">
                <span style="font-size:24px;display:block;margin-bottom:6px">🚗</span>
                <span style="font-size:14px">Driver</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('passwordField');
    const btn = document.getElementById('passwordToggle');
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.textContent = show ? '🔒' : '👁';
}

function selectRole(role, el) {
    document.getElementById('roleInput').value = role;

    document.querySelectorAll('.auth-foot + div .btn').forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline');
    });
    el.classList.remove('btn-outline');
    el.classList.add('btn-primary');

    showToast('Masuk sebagai ' + role.charAt(0).toUpperCase() + role.slice(1));
}

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(function() {
        toast.classList.remove('show');
    }, 2000);
}
</script>
@endpush
@endsection
