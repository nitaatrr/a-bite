@extends('layouts.app')

@section('title', $food->exists ? 'Edit Menu — A-BITE' : 'Tambah Menu — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('admin.menu') }}" class="back-btn">←</a>
    <span class="nav-title">{{ $food->exists ? 'Edit Menu' : 'Tambah Menu' }}</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <form method="POST" action="{{ $food->exists ? route('admin.menu.update', $food->id) : route('admin.menu.store') }}" enctype="multipart/form-data">
        @csrf
        @if($food->exists) @method('PUT') @endif

        <div class="card">
            <div class="field">
                <label>Foto menu</label>
                @if($food->image_url)
                    <img src="{{ $food->image_url }}" style="width:100%;height:160px;object-fit:cover;border-radius:12px;display:block;margin-bottom:8px">
                @endif
                <input type="file" name="image" accept="image/*" class="form-input">
                <span class="hint">JPG/PNG maksimal 5 MB, rasio 4:3</span>
            </div>

            <div class="field">
                <label>Nama menu</label>
                <input class="form-input" type="text" name="name" value="{{ old('name', $food->name) }}" placeholder="Nama menu">
                @error('name')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Harga satuan (Rp)</label>
                <input class="form-input" type="number" name="price" value="{{ old('price', $food->price) }}" placeholder="28000">
                @error('price')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Deskripsi</label>
                <textarea class="form-input" name="description" rows="3">{{ old('description', $food->description) }}</textarea>
                @error('description')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label>Kategori</label>
                <select class="form-input" name="category">
                    <option value="">Pilih kategori</option>
                    <option value="nasi" {{ old('category', $food->category) == 'nasi' ? 'selected' : '' }}>Nasi</option>
                    <option value="ayam" {{ old('category', $food->category) == 'ayam' ? 'selected' : '' }}>Ayam</option>
                    <option value="mie" {{ old('category', $food->category) == 'mie' ? 'selected' : '' }}>Mie</option>
                    <option value="minuman" {{ old('category', $food->category) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
            </div>

            <div class="field">
                <label>Status</label>
                <select class="form-input" name="status">
                    <option value="active" {{ old('status', $food->status ?? 'active') == 'active' ? 'selected' : '' }}>Tersedia</option>
                    <option value="inactive" {{ old('status', $food->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                {{ $food->exists ? 'Simpan perubahan' : 'Tambah menu' }}
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
