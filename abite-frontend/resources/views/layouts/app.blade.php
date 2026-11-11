<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffdadd">
    <title>@yield('title', 'A-BITE — Fast Delivery, Every Bite')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
</head>
<body>
    <div class="phone-frame">

        {{-- Status Bar (iPhone style) --}}
        <div class="status-bar">
            <span class="time">{{ now()->format('H:i') }}</span>
            <div class="notch-area"></div>
            <span class="icons">●●●●○ 🔋</span>
        </div>

        {{-- Page Content --}}
        @yield('content')

        {{-- Home Indicator --}}
        <div class="home-indicator"></div>
    </div>

    {{-- Toast Notification --}}
    <div class="toast-notif" id="toast"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
