@extends('layouts.app')

@section('title', 'Profil Driver — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('driver.tasks') }}" class="back-btn">←</a>
    <span class="nav-title">Profil</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Profil driver</h2>
        <span class="muted small-text">Akun pengantaran A-BITE</span>
    </div>

    <div class="card">
        <div style="display:flex;align-items:center;gap:14px">
            <div class="avatar-pill" style="width:52px;height:52px;font-size:18px">{{ substr(Auth::user()->name ?? 'Budi Santoso', 0, 2) }}</div>
            <div>
                <b style="font-size:16px">{{ Auth::user()->name }}</b>
                <div class="muted small-text">{{ Auth::user()->vehicle ?? 'Honda Vario' }} · {{ Auth::user()->plate_number ?? 'B 4821 SJT' }}</div>
                <div class="muted small-text">{{ Auth::user()->phone }}</div>
                <span class="badge-status green" style="margin-top:6px;display:inline-block">Aktif</span>
            </div>
        </div>
    </div>

    <div class="card">
        <b style="font-size:14px">Statistik pengantar</b>
        <div class="stat-grid" style="margin-top:12px">
            <div class="stat-card">
                <span class="stat-label">Total selesai</span>
                <span class="stat-value">{{ $totalCompleted ?? 8 }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Bulan ini</span>
                <span class="stat-value">{{ $monthlyCompleted ?? 24 }}</span>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-outline btn-block" onclick="showToast('Edit profil')">Edit profil</a>

    <form method="POST" action="{{ route('logout') }}" style="margin-top:12px">
        @csrf
        <button type="submit" class="btn btn-outline btn-block">Keluar</button>
    </form>

    <div style="height:20px"></div>
</div>

<div class="bottom-nav">
    <a href="{{ route('driver.tasks') }}" class="nav-link-item {{ request()->routeIs('driver.tasks') ? 'active' : '' }}">
        <b>▤</b><span>Tugas</span>
    </a>
    <a href="{{ route('driver.profile') }}" class="nav-link-item {{ request()->routeIs('driver.profile') ? 'active' : '' }}">
        <b>♙</b><span>Profil</span>
    </a>
</div>
@endsection
