@extends('layouts.app')

@section('title', 'Pesanan — A-BITE')

@section('content')
<div class="app-header">
    <a href="{{ route('menu') }}" class="back-btn">←</a>
    <span class="nav-title">Pesanan</span>
    <span class="nav-spacer"></span>
</div>

<div class="content">
    <h2 style="font:800 20px 'Plus Jakarta Sans';margin:0 0 4px">Pesananmu</h2>
    <p class="muted small-text">Cerita enak, dari suapan pertama</p>

    <div class="tabs">
        @foreach(['Semua','Berlangsung','Selesai','Dibatalkan'] as $filter)
            <a href="{{ route('orders', ['filter' => $filter]) }}" class="tab-item {{ request('filter') == $filter || (!request('filter') && $filter == 'Semua') ? 'active' : '' }}">{{ $filter }}</a>
        @endforeach
    </div>

    @forelse($orders as $order)
        <div class="card">
            <div class="row-flex">
                <b>{{ $order->order_number }}</b>
                <span class="badge-status {{ $order->status == 'Selesai' ? 'green' : ($order->status == 'Dibatalkan' ? 'red' : '') }}">
                    {{ $order->status }}
                </span>
            </div>
            <div class="muted small-text" style="margin:7px 0">{{ $order->created_at->format('d M Y') }} · {{ $order->created_at->format('H.i') }}</div>
            <b>{{ $order->items_summary }}</b>
            <div class="row-flex" style="margin-top:12px">
                <strong class="food-price">{{ $order->total }}</strong>
                <a href="{{ route('tracking', ['order' => $order->order_number]) }}" class="btn btn-outline btn-sm">
                    {{ $order->status == 'Dalam perjalanan' ? 'Lacak pesanan' : 'Lihat detail' }}
                </a>
            </div>

            @if($order->status == 'Selesai' && !$order->rated)
                <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--line)">
                    <div style="font-weight:700;font-size:12px;margin-bottom:8px">Beri rating</div>
                    <div style="display:flex;gap:6px" id="stars-{{ $order->order_number }}">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="btn btn-sm" style="padding:6px 10px;background:var(--pink2);color:var(--red);font-size:16px" onclick="setRating('{{ $order->order_number }}', {{ $i }})">★</button>
                        @endfor
                    </div>
                    <textarea class="form-input" placeholder="Tulis ulasan (opsional)" style="margin-top:8px" rows="2"></textarea>
                    <button class="btn btn-primary btn-sm btn-block" style="margin-top:8px" onclick="submitRating('{{ $order->order_number }}')">Kirim ulasan</button>
                </div>
            @endif

            @if($order->status == 'Selesai')
                <a href="{{ route('order.reorder', $order->id) }}" class="btn btn-soft btn-block btn-sm" style="margin-top:8px">🔄 Pesan lagi</a>
            @endif
        </div>
    @empty
        <div class="empty-state">Belum ada pesanan.</div>
    @endforelse
</div>

@include('layouts.partials._bottom-nav', [
    'items' => [
        ['route' => route('menu'), 'icon' => '⌂', 'label' => 'Menu', 'active' => request()->routeIs('menu')],
        ['route' => route('cart'), 'icon' => '▣', 'label' => 'Keranjang', 'active' => request()->routeIs('cart')],
        ['route' => route('orders'), 'icon' => '▤', 'label' => 'Pesanan', 'active' => request()->routeIs('orders')],
    ]
])

@push('scripts')
<script>
function setRating(orderId, rating) {
    const container = document.getElementById('stars-' + orderId);
    if (!container) return;
    const buttons = container.querySelectorAll('button');
    buttons.forEach((btn, index) => {
        btn.style.background = index < rating ? 'var(--red)' : 'var(--pink2)';
        btn.style.color = index < rating ? '#fff' : 'var(--red)';
    });
    container.dataset.rating = rating;
}

function submitRating(orderId) {
    const container = document.getElementById('stars-' + orderId);
    const rating = container?.dataset.rating;
    if (!rating) {
        showToast('Pilih jumlah rating terlebih dahulu');
        return;
    }
    const review = container?.parentElement?.querySelector('textarea')?.value || '';
    showToast(`Terima kasih! Rating ${rating} bintang dikirim.`);
    location.reload();
}
</script>
@endpush
@endsection
