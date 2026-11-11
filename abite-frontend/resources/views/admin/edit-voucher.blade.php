@extends('layouts.app')

@section('title', $voucher->exists ? 'Edit Voucher — A-BITE' : 'Buat Voucher — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('admin.vouchers') }}" class="back-btn">←</a>
    <span class="nav-title">{{ $voucher->exists ? 'Edit Voucher' : 'Buat Voucher' }}</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <form method="POST" action="{{ $voucher->exists ? route('admin.vouchers.update', $voucher->id) : route('admin.vouchers.store') }}">
        @csrf
        @if($voucher->exists) @method('PUT') @endif

        <div class="card">
            <b style="font-size:14px">Informasi voucher</b>

            <div class="field">
                <label>Kode voucher</label>
                <input class="form-input" type="text" name="code" value="{{ old('code', $voucher->code) }}" placeholder="HEMAT15">
                @error('code')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Deskripsi</label>
                <input class="form-input" type="text" name="description" value="{{ old('description', $voucher->description) }}" placeholder="Hemat 15% untuk makanan favoritmu.">
                @error('description')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="divider-line"></div>
            <b style="font-size:14px">Aturan diskon</b>

            <div class="field">
                <label>Jenis diskon</label>
                <select class="form-input" name="discount_type">
                    <option value="percentage" {{ old('discount_type', $voucher->discount_type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                </select>
            </div>

            <div class="field">
                <label>Nilai diskon</label>
                <input class="form-input" type="number" name="discount_value" value="{{ old('discount_value', $voucher->discount_value) }}" placeholder="15">
                @error('discount_value')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Maksimum diskon (Rp)</label>
                <input class="form-input" type="number" name="discount_cap" value="{{ old('discount_cap', $voucher->discount_cap) }}" placeholder="15000">
                @error('discount_cap')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Minimum pembelian (Rp)</label>
                <input class="form-input" type="number" name="minimum_purchase" value="{{ old('minimum_purchase', $voucher->minimum_purchase) }}" placeholder="60000">
                @error('minimum_purchase')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="divider-line"></div>
            <b style="font-size:14px">Kuota & batas penggunaan</b>

            <div class="field">
                <label>Total kuota</label>
                <input class="form-input" type="number" name="quota" value="{{ old('quota', $voucher->quota) }}" placeholder="500">
                @error('quota')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Batas penggunaan per pengguna</label>
                <input class="form-input" type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user', $voucher->usage_limit_per_user) }}" placeholder="1">
                @error('usage_limit_per_user')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Tanggal mulai</label>
                <input class="form-input" type="date" name="start_date" value="{{ old('start_date', $voucher->start_date?->format('Y-m-d')) }}">
                @error('start_date')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Tanggal berakhir</label>
                <input class="form-input" type="date" name="end_date" value="{{ old('end_date', $voucher->end_date?->format('Y-m-d')) }}">
                @error('end_date')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            @if($validationValid)
                <div class="alert-success">Validasi berhasil. Kode unik, tanggal valid, dan kuota masih tersedia.</div>
            @endif

            <button type="submit" class="btn btn-primary btn-block" style="margin-top:14px">
                {{ $voucher->exists ? 'Simpan voucher' : 'Buat voucher' }}
            </button>
        </div>
    </form>
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
