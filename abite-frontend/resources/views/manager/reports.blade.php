@extends('layouts.app')

@section('title', 'Laporan — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('manager.analytics') }}" class="back-btn">←</a>
    <span class="nav-title">Laporan</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Laporan usaha</h2>
        <span class="muted small-text">Ringkas, jelas, siap dibagikan</span>
    </div>

    <form method="POST" action="{{ route('manager.reports.generate') }}">
        @csrf
        <div class="card">
            <b style="font-size:14px">Buat laporan</b>

            <div class="field">
                <label>Jenis laporan</label>
                <select class="form-input" name="report_type">
                    <option value="sales_profit" {{ old('report_type') == 'sales_profit' ? 'selected' : '' }}>Penjualan & profit</option>
                    <option value="transactions" {{ old('report_type') == 'transactions' ? 'selected' : '' }}>Transaksi</option>
                </select>
            </div>

            <div class="field">
                <label>Dari tanggal</label>
                <input class="form-input" type="date" name="from_date" id="fromDate" value="{{ old('from_date', request('from_date', '2026-11-01')) }}">
            </div>

            <div class="field">
                <label>Sampai tanggal</label>
                <input class="form-input" type="date" name="to_date" id="toDate" value="{{ old('to_date', request('to_date', '2026-11-06')) }}">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Buat laporan</button>
        </div>
    </form>

    @if(session('report_success'))
        <div class="alert-success">{{ session('report_success') }}</div>
    @endif

    @if($reportData)
        <div class="card" style="margin-top:12px">
            <div class="row-flex">
                <b>Ringkasan periode</b>
                <span class="badge-status green">Siap</span>
            </div>
            <p class="muted small-text">{{ $reportData['period'] }}</p>

            <div class="stat-card" style="margin-top:12px">
                <span class="stat-label">Pendapatan</span>
                <span class="stat-value">{{ $reportData['revenue'] }}</span>
                <small class="muted" style="font-size:10px">Total pembayaran setelah diskon dan termasuk ongkir.</small>
            </div>

            <div class="stat-card" style="margin-top:9px">
                <span class="stat-label">Profit estimasi · Data simulasi</span>
                <span class="stat-value">{{ $reportData['estimated_profit'] }}</span>
                <small class="muted" style="font-size:10px">Margin estimasi {{ $reportData['margin'] }}</small>
            </div>

            <div class="summary-line" style="margin-top:10px">
                <span>Pesanan dibayar</span>
                <b>{{ $reportData['total_orders'] }} pesanan</b>
            </div>

            <div class="summary-line">
                <span>Rata-rata transaksi</span>
                <b>{{ $reportData['avg_transaction'] }}</b>
            </div>

            <div class="two-actions" style="margin-top:12px">
                <a href="{{ route('manager.reports.download', ['type' => 'pdf']) }}" class="btn btn-soft">Unduh PDF</a>
                <a href="{{ route('manager.reports.download', ['type' => 'csv']) }}" class="btn btn-outline">Unduh CSV</a>
            </div>
        </div>
    @endif

    {{-- Riwayat Laporan --}}
    <div class="section-head" style="margin-top:20px">
        <h2>Riwayat laporan</h2>
    </div>
    @forelse($reportHistory ?? [] as $report)
        <div class="card">
            <div class="row-flex">
                <div>
                    <b style="font-size:13px">{{ $report['type'] }}</b>
                    <div class="muted small-text">{{ $report['period'] }}</div>
                </div>
                <a href="#" class="btn btn-outline btn-sm" onclick="showToast('Mengunduh laporan {{ $report['type'] }}')">
                    {{ $report['format'] }}
                </a>
            </div>
        </div>
    @empty
        <div class="empty-state">Belum ada riwayat laporan.</div>
    @endforelse
</div>

<div class="bottom-nav">
    <a href="{{ route('manager.analytics') }}" class="nav-link-item {{ request()->routeIs('manager.analytics') ? 'active' : '' }}">
        <b>▥</b><span>Statistik</span>
    </a>
    <a href="{{ route('manager.transactions') }}" class="nav-link-item {{ request()->routeIs('manager.transactions') ? 'active' : '' }}">
        <b>▤</b><span>Transaksi</span>
    </a>
    <a href="{{ route('manager.reports') }}" class="nav-link-item {{ request()->routeIs('manager.reports') ? 'active' : '' }}">
        <b>▧</b><span>Laporan</span>
    </a>
</div>
@endsection
