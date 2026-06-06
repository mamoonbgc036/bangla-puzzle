<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopNest') — Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body>

    @include('layouts.partials.side_bar')

    <div class="main-wrap">
        <header class="topbar">
            <div class="topbar-title">@yield('topbar-title', 'Dashboard')</div>
            <div class="topbar-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Quick search...">
            </div>
        </header>
        <main class="page-content">
            @if (session('success'))
                <div class="alert alert-success"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger"><i class="fas fa-circle-exclamation"></i> {{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        document.querySelectorAll('form[data-confirm]').forEach(f => {
            f.addEventListener('submit', e => {
                if (!confirm(f.dataset.confirm)) e.preventDefault();
            });
        });
    </script>
</body>

</html>
