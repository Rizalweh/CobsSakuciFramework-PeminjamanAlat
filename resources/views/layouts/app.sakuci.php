<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    {{-- Terapkan tema tersimpan sebelum apa pun dirender, supaya tidak ada flash warna --}}
    <script>
        (function () {
            var saved = localStorage.getItem('sakuci-theme');
            var theme = saved || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    {{-- Bootstrap 5.3.8 dan Bootstrap Icons -- file lokal, tidak butuh internet --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bi/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    
</head>
<body class="bg-body-tertiary">

@include('partials.navbar')

<div class="app-content d-flex flex-column min-vh-100">
    <main class="container-fluid px-3 px-lg-4 flex-grow-1 py-4">
        @include('partials.flash')

        @yield('content')
    </main>

    @include('partials.footer')
</div>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>
@yield('scripts')

<script>
    // Ciutkan / lebarkan sidebar (layar besar). Pilihan disimpan di localStorage.
(function () {
    var btn = document.getElementById('sidebarToggle');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var root = document.documentElement;
        var collapsed = root.classList.toggle('sidebar-collapsed');
        try {
            localStorage.setItem('sakuci-sidebar', collapsed ? 'collapsed' : 'expanded');
        } catch (e) {}
    });
})();
</script>
</body>
</html>