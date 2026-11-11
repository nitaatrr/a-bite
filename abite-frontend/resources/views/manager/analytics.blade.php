@extends('layouts.app')

@section('title', 'Statistik — A-BITE')

@push('styles')
<style>
    .chart-container {
        position: relative;
        width: 100%;
        height: 200px;
    }
    .chart-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>
@endpush

@section('content')
<div class="app-header">
    <a href="{{ route('logout', ['role' => 'manager']) }}" class="back-btn">←</a>
    <span class="nav-title">Statistik</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Statistik penjualan</h2>
        <span class="muted small-text">Keputusan baik dimulai dari data</span>
    </div>

    <div class="tabs">
        <a href="{{ route('manager.analytics', ['period' => 'today']) }}" class="tab-item {{ !request('period') || request('period') == 'today' ? 'active' : '' }}">Hari ini</a>
        <a href="{{ route('manager.analytics', ['period' => '7days']) }}" class="tab-item {{ request('period') == '7days' ? 'active' : '' }}">7 hari</a>
        <a href="{{ route('manager.analytics', ['period' => 'month']) }}" class="tab-item {{ request('period') == 'month' ? 'active' : '' }}">Bulan ini</a>
    </div>

    {{-- Calendar / Date Range Picker --}}
    <div class="card">
        <b style="font-size:13px">Pilih rentang tanggal</b>
        <div class="date-range-picker" style="margin-top:10px">
            <input type="date" name="from_date" value="{{ old('from_date', request('from_date', '2026-11-01')) }}" id="fromDatePicker">
            <div class="date-separator">—</div>
            <input type="date" name="to_date" value="{{ old('to_date', request('to_date', '2026-11-06')) }}" id="toDatePicker">
        </div>
        <div style="display:flex;gap:8px;margin-top:10px">
            <button class="btn btn-primary btn-sm" style="flex:1" onclick="applyDateFilter()">Terapkan</button>
            <button class="btn btn-outline btn-sm" style="flex:1" onclick="resetDateFilter()">Reset</button>
        </div>
    </div>

    <div class="card" style="background:#fff;border:1px solid var(--line)">
        <span class="muted small-text">Total pendapatan</span>
        <div class="price" style="font:800 26px 'Plus Jakarta Sans'">{{ $analytics['total_revenue'] ?? 'Rp14.860.000' }}</div>
        <span class="alert-success">{{ $analytics['revenue_growth'] ?? '↑ 12,4% vs periode sebelumnya' }}</span>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-label">Pesanan dibayar</span>
            <span class="stat-value">{{ $analytics['paid_orders'] ?? '186' }}</span>
            <span class="stat-change">{{ $analytics['order_growth'] ?? '↑ 9,4%' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Rata-rata transaksi</span>
            <span class="stat-value">{{ $analytics['avg_transaction'] ?? 'Rp79.892' }}</span>
            <span class="stat-change">{{ $analytics['avg_growth'] ?? '↑ 2,7%' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Profit estimasi</span>
            <span class="stat-value">{{ $analytics['estimated_profit'] ?? 'Rp3,72 jt' }}</span>
            <span class="stat-change">{{ $analytics['profit_growth'] ?? '↑ 10,1%' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Margin estimasi</span>
            <span class="stat-value">{{ $analytics['margin'] ?? '25,0%' }}</span>
            <span class="stat-change">Data simulasi</span>
        </div>
    </div>

    <div class="card">
        <b style="font-size:14px">Pendapatan vs Profit</b>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
        <div style="display:flex;gap:16px;justify-content:center;margin-top:8px">
            <span style="font-size:11px;color:var(--red)">● Pendapatan</span>
            <span style="font-size:11px;color:var(--green)">● Profit</span>
        </div>
        <p class="muted small-text" style="margin-top:8px;text-align:center">November 2026 · Rp juta</p>
    </div>

    <div class="card">
        <b style="font-size:14px">Menu terlaris</b>
        @foreach($analytics['top_foods'] ?? [] as $food)
            <div class="summary-line" style="margin-top:6px">
                <span>{{ $food['name'] }}</span>
                <b>{{ $food['sold'] }} porsi</b>
            </div>
        @endforeach
        @if(empty($analytics['top_foods']))
            <div class="summary-line"><span>Nasi Goreng Spesial</span><b>124 porsi</b></div>
            <div class="summary-line"><span>Ayam Geprek</span><b>96 porsi</b></div>
            <div class="summary-line"><span>Mie Goreng</span><b>68 porsi</b></div>
        @endif
    </div>

    <p class="hint">Profit adalah data simulasi laporan, bukan perhitungan biaya dari database pesanan.</p>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    const labels = {!! json_encode($analytics['chart_labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!};
    const revenueData = {!! json_encode($analytics['chart_revenue'] ?? [1.2, 1.8, 1.5, 2.1, 2.4, 3.2, 2.8]) !!};
    const profitData = {!! json_encode($analytics['chart_profit'] ?? [0.3, 0.5, 0.4, 0.6, 0.7, 0.9, 0.8]) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: revenueData,
                    backgroundColor: 'rgba(189, 64, 87, 0.85)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Profit',
                    data: profitData,
                    backgroundColor: 'rgba(46, 154, 112, 0.85)',
                    borderRadius: 6,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 }, color: '#8e8990' }
                },
                y: {
                    grid: { color: '#f0ebeb' },
                    ticks: { font: { size: 10 }, color: '#8e8990' }
                }
            }
        }
    });
});

function applyDateFilter() {
    const from = document.getElementById('fromDatePicker').value;
    const to = document.getElementById('toDatePicker').value;
    if (!from || !to) {
        showToast('Pilih tanggal mulai dan akhir');
        return;
    }
    window.location.href = '{{ route("manager.analytics") }}?from_date=' + from + '&to_date=' + to;
}

function resetDateFilter() {
    document.getElementById('fromDatePicker').value = '';
    document.getElementById('toDatePicker').value = '';
    showToast('Filter tanggal direset');
}
</script>
@endpush
@endsection
