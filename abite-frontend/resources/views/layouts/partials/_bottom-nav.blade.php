<div class="bottom-nav">
    @foreach($items as $item)
        <a href="{{ $item['route'] }}" class="nav-link-item {{ $item['active'] ? 'active' : '' }}">
            <b>{{ $item['icon'] }}</b>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</div>
