<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- DaisyUI + Tailwind (CDN, tanpa Node/npm). Layout terpisah dari
         Bootstrap -- tidak pernah dimuat bersamaan, jadi tidak ada bentrok class. --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Terapkan tema tersimpan sebelum apa pun dirender, biar tidak ada flash warna.
         Key localStorage sengaja beda dari sisi Bootstrap ('sakuci-theme'), supaya
         toggle di kedua sisi tidak saling ganggu. --}}
    <script>
        (function () {
            var saved = localStorage.getItem('sakuci-daisy-theme');
            var theme = saved || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();

        function toggleSakuciTheme() {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            var next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('sakuci-daisy-theme', next);
        }
    </script>

    <style>
        :root,
        [data-theme="dark"] {
            --ink: #17140f;
            --surface: #211c15;
            --surface-2: #2b241a;
            --line: #3a2f22;
            --text: #ede6d6;
            --text-dim: #b3a890;
            --brand: #c2410c;
            --brand-bright: #f97316;
        }

        [data-theme="light"] {
            --ink: #fbf7f0;
            --surface: #ffffff;
            --surface-2: #f0e9da;
            --line: #e3d9c6;
            --text: #221c14;
            --text-dim: #6b6152;
            --brand: #c2410c;
            --brand-bright: #9a3412;
        }

        body {
            background: var(--ink);
            color: var(--text);
            font-family: 'Inter', system-ui, sans-serif;
            transition: background .15s ease, color .15s ease;
        }

        h1, h2, h3, .font-display {
            font-family: 'Space Grotesk', system-ui, sans-serif;
        }

        code, .font-mono, .mockup-code {
            font-family: 'IBM Plex Mono', ui-monospace, monospace !important;
        }

        .surface {
            background: var(--surface);
            border: 1px solid var(--line);
        }

        .mockup-code {
            background: #1f1b15 !important;
            border: 1px solid #3a2f22;
        }

        .mockup-code pre::before {
            color: #8a8171 !important;
        }

        .inline-code {
            background: var(--surface-2);
            border: 1px solid var(--line);
            color: var(--brand-bright);
            border-radius: 4px;
            padding: 1px 6px;
            font-size: 0.85em;
        }

        .brand-link {
            color: var(--brand-bright);
            text-decoration: underline;
            text-decoration-color: var(--line);
            text-underline-offset: 3px;
        }

        .brand-link:hover {
            text-decoration-color: var(--brand-bright);
        }

        [data-theme="light"] .theme-icon-sun { display: none !important; }
        [data-theme="light"] .theme-icon-moon { display: inline !important; }

        /* ===== Utility class reusable, biar halaman baru tinggal pakai
           nama class ini -- tidak perlu tulis style="" berulang ===== */

        .card-surface {
            background: var(--surface);
            border: 1px solid var(--line);
        }

        .text-muted-sakuci { color: var(--text-dim); }
        .text-brand-sakuci { color: var(--brand-bright); }

        .btn-brand-fill {
            background: var(--brand);
            color: #fff;
            border: none;
        }
        .btn-brand-fill:hover { background: var(--brand-bright); color: #fff; }

        .btn-neutral-sakuci {
            background: var(--surface-2);
            color: var(--text);
            border: none;
        }

        .btn-danger-soft {
            background: rgba(239,68,68,.15);
            color: #ef4444;
            border: none;
        }
        .btn-danger-soft:hover { background: rgba(239,68,68,.25); color: #ef4444; }

        .badge-soft-success { background: rgba(34,197,94,.12); color: #22c55e; }
        .badge-soft-warning { background: rgba(234,179,8,.12); color: #eab308; }
        .badge-soft-danger  { background: rgba(239,68,68,.12); color: #ef4444; }
        .badge-soft-neutral { background: var(--surface-2); color: var(--text-dim); }
        .badge-soft-success, .badge-soft-warning, .badge-soft-danger, .badge-soft-neutral {
            border-radius: 9999px;
            padding: .25rem .65rem;
            font-size: .75rem;
        }

        /* Tabel gelap: thead/tbody/tr/td otomatis kepakai tanpa style inline */
        .table-sakuci thead th {
            background: transparent;
            color: var(--text-dim);
            font-family: 'IBM Plex Mono', ui-monospace, monospace;
            font-weight: 400;
            font-size: .75rem;
            border-bottom: 1px solid var(--line);
        }
        .table-sakuci tbody td {
            background: transparent;
            border-bottom: 1px solid var(--line);
            color: var(--text);
        }

        /* Pagination bawaan Laravel-style paginator, disamakan ke tema gelap */
        .pagination-sakuci nav { display: flex; justify-content: center; }
        .pagination-sakuci ul { display: flex; gap: 4px; list-style: none; padding: 0; margin: 0; }
        .pagination-sakuci a, .pagination-sakuci span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 32px; height: 32px; padding: 0 8px;
            border-radius: 6px; font-size: .85rem;
            color: var(--text-dim); text-decoration: none;
        }
        .pagination-sakuci .active span, .pagination-sakuci a:hover {
            background: var(--surface-2); color: var(--text);
        }

        /* ===== Animasi ===== */

        /* Elemen fade + naik dikit waktu masuk viewport saat di-scroll.
           Tinggal tambah class="reveal" di elemen manapun -- otomatis jalan
           di semua halaman lewat script IntersectionObserver di bawah. */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .5s ease, transform .5s ease;
        }
        .reveal.is-visible {
            opacity: 1;
            transform: none;
        }

        /* Card terangkat halus saat di-hover */
        .card-surface, .surface {
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .card-surface:hover, .surface:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(0,0,0,.28);
        }

        /* Tombol: sedikit mengecil saat diklik, transisi warna halus */
        .btn {
            transition: transform .12s ease, background-color .15s ease, opacity .15s ease;
        }
        .btn:active { transform: scale(.96); }

        /* Ikon toggle tema berputar pelan saat berganti */
        .theme-icon-sun, .theme-icon-moon {
            transition: transform .35s ease;
        }

        /* Badge status: sedikit membesar saat hover, biar terasa hidup di tabel */
        .badge-soft-success, .badge-soft-warning, .badge-soft-danger, .badge-soft-neutral {
            transition: transform .15s ease;
            display: inline-block;
        }
        .badge-soft-success:hover, .badge-soft-warning:hover,
        .badge-soft-danger:hover, .badge-soft-neutral:hover {
            transform: scale(1.06);
        }
    </style>
</head>
<body class="min-h-screen">

<div class="drawer lg:drawer-open">
    <input id="sakuci-sidebar" type="checkbox" class="drawer-toggle" />

    <div class="drawer-content flex flex-col min-h-screen">

        {{-- Top bar -- hanya tampil di mobile, buka sidebar --}}
        <div class="lg:hidden flex items-center gap-3 px-5 py-4" style="border-bottom: 1px solid var(--line);">
            <label for="sakuci-sidebar" class="btn btn-sm btn-square border-none" style="background: var(--surface-2); color: var(--text);" aria-label="Buka menu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </label>
            <span class="font-display font-semibold">{{ config('app.name') }}</span>
        </div>

        <main class="flex-1">
            <div class="max-w-6xl mx-auto px-6 py-10 lg:py-20">
                @include('partials.flash-daisy')
                @yield('content')
            </div>
        </main>

        @include('partials.footer-daisy')
    </div>

    <div class="drawer-side z-30">
        <label for="sakuci-sidebar" class="drawer-overlay"></label>
        @include('partials.sidebar-daisy')
    </div>
</div>

{{-- Animasi reveal-on-scroll: berlaku otomatis untuk elemen manapun
     yang diberi class="reveal", di halaman manapun --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var els = document.querySelectorAll('.reveal');
        if (!('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        els.forEach(function (el) { obs.observe(el); });
    });
</script>

@yield('scripts')

</body>
</html>