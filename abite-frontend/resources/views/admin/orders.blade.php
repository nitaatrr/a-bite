@extends('layouts.app')

@section('title', 'Pesanan — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('admin.dashboard') }}" class="back-btn">←</a>
    <span class="nav-title">Pesanan</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <div class="section-head">
        <h2>Pesanan & driver</h2>
        <span class="muted small-text">{{ $activeOrders ?? 8 }} aktif · {{ $pendingDrivers ?? 3 }} menunggu</span>
    </div>

    <div class="tabs">
        <a href="{{ route('admin.orders', ['status' => 'all']) }}" class="tab-item {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('admin.orders', ['status' => 'new']) }}" class="tab-item {{ request('status') == 'new' ? 'active' : '' }}">Baru · {{ $newOrdersCount ?? 3 }}</a>
        <a href="{{ route('admin.orders', ['status' => 'assigned']) }}" class="tab-item {{ request('status') == 'assigned' ? 'active' : '' }}">Diantar · {{ $assignedCount ?? 2 }}</a>
    </div>

    @forelse($orders as $order)
        <div class="card">
            <div class="row-flex">
                <b>{{ $order->order_number }}</b>
                <span class="badge-status {{ $order->status == 'Selesai' ? 'green' : ($order->status == 'Dibatalkan' ? 'red' : '') }}">
                    {{ $order->status_label ?? $order->status }}
                </span>
            </div>
            <div class="row-flex" style="margin-top:8px">
                <span class="muted small-text">{{ $order->customer_name }} · {{ $order->created_at->format('H.i') }}</span>
                <b>{{ $order->total }}</b>
            </div>
            <div class="divider-line"></div>
            <div class="muted small-text">Item pesanan · Detail pelanggan & pembayaran</div>

            @if($order->status == 'Baru' && $order->driver_id === null)
                <button class="btn btn-soft btn-block btn-sm" style="margin-top:10px" onclick="openDriverModal({{ $order->id }}, '{{ $order->order_number }}')">
                    Tugaskan driver →
                </button>
            @else
                <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-soft btn-block btn-sm" style="margin-top:10px">
                    Lihat detail →
                </a>
            @endif
        </div>
    @empty
        <div class="empty-state">Tidak ada pesanan.</div>
    @endforelse
</div>

{{-- Driver Assignment Modal --}}
<div class="modal-overlay" id="driverModal">
    <div class="modal-box">
        <h3>Tugaskan Driver</h3>
        <p>Pilih driver yang tersedia untuk pesanan <b id="modalOrderNumber"></b></p>
        <div id="driverOptions">
            @foreach($drivers ?? [] as $driver)
                <div class="driver-option {{ $driver->is_busy ? 'disabled' : '' }}"
                     onclick="{{ $driver->is_busy ? '' : "selectDriver({$driver->id}, '${$driver->name}')" }}">
                    <div class="driver-avatar">{{ substr($driver->name, 0, 2) }}</div>
                    <div class="driver-info">
                        <b>{{ $driver->name }}</b>
                        <small>{{ $driver->vehicle }} · {{ $driver->active_tasks ?? 0 }} tugas aktif</small>
                    </div>
                    <span class="driver-status {{ $driver->is_busy ? 'busy' : 'available' }}">
                        {{ $driver->is_busy ? 'Sibuk' : 'Tersedia' }}
                    </span>
                </div>
            @endforeach
        </div>
        <div class="modal-actions" style="margin-top:16px">
            <button class="btn btn-outline" onclick="closeDriverModal()">Batal</button>
            <button class="btn btn-primary" id="confirmDriverBtn" onclick="confirmDriverAssignment()" disabled>Konfirmasi</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentOrderId = null;
let selectedDriverId = null;

function openDriverModal(orderId, orderNumber) {
    currentOrderId = orderId;
    document.getElementById('modalOrderNumber').textContent = orderNumber;
    document.getElementById('driverModal').classList.add('show');
    selectedDriverId = null;
    document.getElementById('confirmDriverBtn').disabled = true;
    document.querySelectorAll('.driver-option').forEach(el => el.classList.remove('selected'));
}

function closeDriverModal() {
    document.getElementById('driverModal').classList.remove('show');
    currentOrderId = null;
}

function selectDriver(driverId, driverName) {
    selectedDriverId = driverId;
    document.getElementById('confirmDriverBtn').disabled = false;
    document.querySelectorAll('.driver-option').forEach(el => el.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
}

function confirmDriverAssignment() {
    if (!selectedDriverId || !currentOrderId) return;
    showToast(`Driver berhasil ditugaskan ke pesanan #${currentOrderId}`);
    closeDriverModal();
    location.reload();
}
</script>
@endpush
@endsection
