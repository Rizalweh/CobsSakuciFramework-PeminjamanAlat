@extends('layouts.app')

@section('title', config('app.name') . ' -- Peminjaman Alat')

@section('content')

    {{--
        $stat, $kategori, $alatTerbaru, $currentUser dikirim dari
        App\Controllers\Core\WelcomeController@index -- lihat file itu.
    --}}
    @php
        // TODO: sesuaikan cara baca role kalau di User model kamu bentuknya
        // beda (misal $currentUser->role->nama_role atau method hasRole()).
        $role = $currentUser->role ?? null;
    @endphp

    {{-- =============== CDN & font khusus halaman ini =============== --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    <style>
        #welcome-page { font-family:'Inter',sans-serif;
            --wp-panel-bg:#F4F5F5; --wp-panel-alt:#F7F7F5;
            --wp-text:#232427; --wp-text-strong:#2E3034;
            --wp-text-dim:#55575c; --wp-text-faint:#8a8c91;
            --wp-card-bg:#ffffff; --wp-card-border:rgba(0,0,0,0.05);
            --wp-cta-bg:#171719; --wp-cta-text:#ffffff;
            --wp-accent:#E34A32; --wp-accent-soft:#F4F5F5;
            --wp-shadow-panel:0 1px 0 rgba(255,255,255,0.9) inset, 0 20px 60px -30px rgba(35,36,39,0.25);
            --wp-shadow-card:0 1px 0 rgba(255,255,255,0.9) inset, 0 14px 30px -18px rgba(35,36,39,0.25);
        }
        [data-bs-theme="dark"] #welcome-page {
            --wp-panel-bg:#18191b; --wp-panel-alt:#1d1e21;
            --wp-text:#ECEDEE; --wp-text-strong:#ffffff;
            --wp-text-dim:rgba(236,237,238,0.62); --wp-text-faint:rgba(236,237,238,0.4);
            --wp-card-bg:#232427; --wp-card-border:rgba(255,255,255,0.08);
            --wp-cta-bg:#ECEDEE; --wp-cta-text:#171719;
            --wp-accent:#F05A3C; --wp-accent-soft:#2a2b2e;
            --wp-shadow-panel:0 1px 0 rgba(255,255,255,0.05) inset, 0 20px 60px -30px rgba(0,0,0,0.6);
            --wp-shadow-card:0 1px 0 rgba(255,255,255,0.04) inset, 0 14px 30px -18px rgba(0,0,0,0.5);
        }
        #welcome-page h1, #welcome-page h2 { letter-spacing:-0.035em; }
        #welcome-page .font-serif-accent { font-family:'Instrument Serif',Georgia,serif; font-weight:400; font-style:italic; letter-spacing:-0.01em; }
        #welcome-page .wchar { display:inline-block; font-variation-settings:'wght' 600; transition:font-variation-settings .15s linear; will-change:font-variation-settings; }
        #welcome-page [data-rise] { opacity:0; transform:translateY(16px); transition:all .7s ease; }
        #welcome-page.is-ready [data-rise] { opacity:1; transform:translateY(0); }
        #welcome-page [data-reveal] { opacity:0; transform:translateY(16px); transition:all .7s ease; }
        #welcome-page [data-reveal].is-visible { opacity:1; transform:translateY(0); }
        #welcome-page .wp-card { transition:transform .3s ease, box-shadow .3s ease; }
        #welcome-page .wp-card:hover { transform:translateY(-4px); }
        @media (prefers-reduced-motion: reduce) {
            #welcome-page [data-rise], #welcome-page [data-reveal] { transition:none; opacity:1; transform:none; }
        }
    </style>

    <div id="welcome-page">

        {{-- =============== HERO =============== --}}
        <section id="welcome-hero" class="relative overflow-hidden mb-6" style="border-radius:32px; background:var(--wp-panel-bg); box-shadow:var(--wp-shadow-panel); min-height:min(78vh, 620px);">

            <canvas id="sarprasMesh" class="pointer-events-none absolute inset-0 z-0 h-full w-full opacity-60"></canvas>
            <div class="pointer-events-none absolute -right-40 top-0 h-[560px] w-[560px] rounded-full opacity-70 blur-3xl" style="background: radial-gradient(circle at 55% 45%, rgba(227,74,50,0.5), rgba(240,120,70,0.24) 40%, rgba(244,245,245,0) 70%)"></div>
            <div class="pointer-events-none absolute -left-40 top-20 h-[480px] w-[480px] rounded-full opacity-50 blur-3xl" style="background: radial-gradient(circle at 50% 50%, rgba(46,48,52,0.3), rgba(120,124,130,0.12) 45%, rgba(244,245,245,0) 72%)"></div>

            <div class="relative z-10 mx-auto flex max-w-4xl flex-col items-center px-6 py-16 sm:py-20 text-center">

                <div data-rise class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium backdrop-blur" style="border-color:var(--wp-card-border); background:var(--wp-card-bg); color:var(--wp-accent);">
                    <i data-lucide="zap" class="h-4 w-4" stroke-width="1.5"></i>
                   Aplikasi Peminjaman Sarana Dan Prasarana Sekolah
                </div>

                <div class="relative mt-7">
                    <h1 data-rise style="transition-delay:.1s; color:var(--wp-text-strong);" class="text-5xl sm:text-6xl lg:text-7xl font-semibold leading-[1.03]">
                        Selamat datang{{ $currentUser ? ', ' . $currentUser->username : '' }}
                        <br>
                        di <span class="relative inline-block font-serif-accent" style="color:var(--wp-accent);">
                            SARPRAS TECH
                            <span class="absolute -right-6 top-1/2 hidden h-14 w-32 -translate-y-1/2 translate-x-full rounded-full opacity-80 blur-[1px] lg:block" style="background:linear-gradient(135deg,#F05A3C,#C93A24);"></span>
                        </span>
                    </h1>

                    <div data-drift class="absolute -right-6 -top-8 hidden rotate-6 md:flex h-14 w-14 items-center justify-center rounded-2xl border" style="background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500 text-white">
                            <i data-lucide="wrench" class="h-4 w-4" stroke-width="1.5"></i>
                        </span>
                    </div>
                    <div data-drift class="absolute -right-20 top-14 hidden -rotate-6 lg:flex h-14 w-14 items-center justify-center rounded-2xl border" style="transition-delay:.2s; background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white">
                            <i data-lucide="clipboard-check" class="h-4 w-4" stroke-width="1.5"></i>
                        </span>
                    </div>
                    <div data-drift class="absolute -bottom-10 right-2 hidden rotate-3 md:flex h-14 w-14 items-center justify-center rounded-2xl border" style="transition-delay:.4s; background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl" style="background:var(--wp-accent-soft); color:var(--wp-accent);">
                            <i data-lucide="package" class="h-4 w-4" stroke-width="1.5"></i>
                        </span>
                    </div>
                </div>

                <p data-rise style="transition-delay:.2s; max-width:34rem; color:var(--wp-text-dim);" class="mt-8 text-lg leading-relaxed">
                    Cek ketersediaan, ajukan peminjaman, dan pantau alat semua dari satu halaman.
                </p>

                <div data-rise style="transition-delay:.3s;" class="mt-8 flex flex-col items-center gap-3 sm:flex-row">
                    @if (!$currentUser)
                        <a href="{{ route('login') }}" class="group inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="background:var(--wp-cta-bg); color:var(--wp-cta-text);">
                            Masuk untuk pinjam alat
                            <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5"></i>
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-full border px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="border-color:var(--wp-card-border); background:var(--wp-card-bg); color:var(--wp-text-strong);">
                            Daftar akun
                        </a>
                    @elseif ($role === 'peminjam')
                        <a href="{{ route('peminjam.alat.index') }}" class="group inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="background:var(--wp-cta-bg); color:var(--wp-cta-text);">
                            Lihat daftar alat
                            <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5"></i>
                        </a>
                        <a href="{{ route('peminjam.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-full border px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="border-color:var(--wp-card-border); background:var(--wp-card-bg); color:var(--wp-text-strong);">
                            Riwayat peminjaman
                        </a>
                    @elseif ($role === 'petugas')
                        <a href="{{ route('petugas.peminjaman.index') }}" class="group inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="background:var(--wp-cta-bg); color:var(--wp-cta-text);">
                            Kelola peminjaman
                            <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5"></i>
                        </a>
                    @elseif ($role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="group inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="background:var(--wp-cta-bg); color:var(--wp-cta-text);">
                            Buka dashboard admin
                            <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5"></i>
                        </a>
                        <a href="{{ route('alat.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="border-color:var(--wp-card-border); background:var(--wp-card-bg); color:var(--wp-text-strong);">
                            Kelola alat
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="group inline-flex items-center justify-center gap-2 rounded-full px-7 py-3.5 text-base font-medium transition-all duration-300 hover:-translate-y-0.5" style="background:var(--wp-cta-bg); color:var(--wp-cta-text);">
                            Buka dashboard
                            <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5"></i>
                        </a>
                    @endif
                </div>

                @if (count($kategori))
                <div data-rise style="transition-delay:.5s;" class="mt-12">
                    <p class="text-xs font-medium uppercase tracking-widest" style="color:var(--wp-text-faint);">Kategori alat tersedia</p>
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-x-7 gap-y-2" style="color:var(--wp-text-dim);">
                        @foreach ($kategori as $k)
                            <span class="text-base font-semibold opacity-70">{{ $k->nama_kategori }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div data-rise style="transition-delay:.6s;" class="absolute bottom-5 right-5 z-20 hidden items-center gap-3 rounded-2xl border p-2.5 pr-4 backdrop-blur lg:flex" style="border-color:var(--wp-card-border); background:var(--wp-card-bg); box-shadow:var(--wp-shadow-card);">
                <span class="flex h-10 w-12 items-center justify-center rounded-xl" style="background:linear-gradient(135deg,var(--wp-text-strong),var(--wp-text-dim));">
                    <i data-lucide="layout-grid" class="h-4 w-4 text-white/80"></i>
                </span>
                <div class="text-left">
                    <p class="text-sm font-semibold leading-tight" style="color:var(--wp-text-strong);">{{ $stat['total'] }} alat terdaftar</p>
                    <p class="text-xs" style="color:var(--wp-text-faint);">{{ $stat['kategori'] }} kategori</p>
                </div>
            </div>
        </section>

        {{-- =============== STAT PILLS =============== --}}
        <section class="mb-14 px-1">
            <div data-reveal class="relative rounded-[32px] border p-6 sm:p-8" style="background:var(--wp-panel-alt); border-color:var(--wp-card-border);">
                <div class="flex flex-col items-stretch gap-4 lg:flex-row lg:items-center lg:-space-x-4">
                    <div class="flex-1 rounded-full border px-8 py-6 text-center lg:rotate-[-1deg]" style="background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <p class="text-3xl sm:text-4xl font-semibold" style="color:var(--wp-text-strong);">{{ $stat['total'] }}</p>
                        <p class="mt-1 text-sm" style="color:var(--wp-text-dim);">Total alat</p>
                    </div>
                    <div class="flex-1 rounded-full border px-8 py-6 text-center lg:z-10 lg:scale-105" style="background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <p class="text-3xl sm:text-4xl font-semibold text-emerald-500">{{ $stat['tersedia'] }}</p>
                        <p class="mt-1 text-sm" style="color:var(--wp-text-dim);">Tersedia</p>
                    </div>
                    <div class="flex-1 rounded-full border px-8 py-6 text-center" style="background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <p class="text-3xl sm:text-4xl font-semibold text-amber-500">{{ $stat['dipinjam'] }}</p>
                        <p class="mt-1 text-sm" style="color:var(--wp-text-dim);">Sedang dipinjam</p>
                    </div>
                    <div class="flex-1 rounded-full border px-8 py-6 text-center lg:rotate-[1deg]" style="background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <p class="text-3xl sm:text-4xl font-semibold" style="color:var(--wp-accent);">{{ $stat['kategori'] }}</p>
                        <p class="mt-1 text-sm" style="color:var(--wp-text-dim);">Kategori</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- =============== CARA MEMINJAM =============== --}}
        <section class="mb-4 px-1">
            <p class="text-sm font-semibold" style="color:var(--wp-accent);">Panduan</p>
            <h2 class="mt-2 text-3xl sm:text-4xl font-semibold leading-tight" style="color:var(--wp-text-strong);">Cara meminjam</h2>

            <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['01', 'search',          'Pilih alat',          'Cari di halaman Alat, cek status ketersediaannya.'],
                    ['02', 'file-text',       'Ajukan peminjaman',   'Isi tanggal dan lama pemakaian, lalu kirim pengajuan.'],
                    ['03', 'clock',           'Tunggu persetujuan',  'Admin memverifikasi pengajuan lewat Dashboard.'],
                    ['04', 'package-check',   'Ambil & kembalikan',  'Ambil alat sesuai jadwal, kembalikan tepat waktu.'],
                ] as [$no, $icon, $title, $desc])
                    <div data-reveal class="wp-card rounded-3xl border p-6" style="background:var(--wp-card-bg); border-color:var(--wp-card-border); box-shadow:var(--wp-shadow-card);">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl border" style="background:var(--wp-panel-bg); border-color:var(--wp-card-border); color:var(--wp-accent);">
                            <i data-lucide="{{ $icon }}" class="h-5 w-5" stroke-width="1.5"></i>
                        </span>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-xs font-mono" style="color:var(--wp-accent);">{{ $no }}</span>
                        </div>
                        <div class="font-semibold mt-1 mb-1" style="color:var(--wp-text-strong);">{{ $title }}</div>
                        <div class="text-sm leading-relaxed" style="color:var(--wp-text-dim);">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        if (window.lucide) lucide.createIcons();

        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Reveal hero sekali saat load
        window.addEventListener('load', function () {
            document.getElementById('welcome-page').classList.add('is-ready');
        });

        // Reveal section di bawah hero saat discroll ke viewport
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });
        document.querySelectorAll('#welcome-page [data-reveal]').forEach(function (el) { io.observe(el); });

        // Tile drift halus
        if (!reduceMotion) {
            var tiles = document.querySelectorAll('#welcome-page [data-drift]');
            var t = 0;
            (function drift() {
                t += 0.008;
                tiles.forEach(function (el, i) {
                    var base = el.classList.contains('rotate-6') ? 6 : el.classList.contains('-rotate-6') ? -6 : 3;
                    el.style.transform = 'translateY(' + (Math.sin(t + i * 2) * 6) + 'px) rotate(' + (base + Math.sin(t * 0.7 + i) * 2) + 'deg)';
                });
                requestAnimationFrame(drift);
            })();
        }

        // Mesh 3D latar hero
        (function () {
            var canvas = document.getElementById('sarprasMesh');
            if (reduceMotion || !canvas || !window.THREE) return;

            var renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
            var scene = new THREE.Scene();
            var camera = new THREE.PerspectiveCamera(35, 1, 0.1, 100);
            camera.position.z = 15;

            var geometry = new THREE.IcosahedronGeometry(2.6, 0);
            var material = new THREE.MeshStandardMaterial({
                color: 0xE34A32, emissive: 0x7a2012, roughness: 0.3, metalness: 0.6, flatShading: true
            });
            var mesh = new THREE.Mesh(geometry, material);
            scene.add(mesh);
            scene.add(new THREE.AmbientLight(0xffffff, 0.5));
            var mainLight = new THREE.DirectionalLight(0xffffff, 1.2);
            mainLight.position.set(10, 10, 10);
            scene.add(mainLight);
            var fillLight = new THREE.DirectionalLight(0xF05A3C, 0.6);
            fillLight.position.set(-10, -5, 5);
            scene.add(fillLight);

            function resize() {
                var w = canvas.clientWidth, h = canvas.clientHeight;
                renderer.setSize(w, h, false);
                renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                camera.aspect = w / h;
                camera.updateProjectionMatrix();
                mesh.position.x = (w < 1024) ? 0 : 4.5;
            }
            window.addEventListener('resize', resize);
            resize();

            var t2 = 0;
            (function frame() {
                t2 += 0.008;
                mesh.rotation.x = t2 * 0.2;
                mesh.rotation.y = t2 * 0.3;
                mesh.position.y = 0.3 + Math.sin(t2 * 1.2) * 0.25;
                renderer.render(scene, camera);
                requestAnimationFrame(frame);
            })();
        })();

        // Split karakter h1 + efek font-weight ngikutin cursor (persis referensi)
        (function () {
            if (reduceMotion) return;
            function splitChars(el) {
                var walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT, null);
                var nodes = []; while (walker.nextNode()) nodes.push(walker.currentNode);
                nodes.forEach(function (node) {
                    if (!node.textContent.trim()) return;
                    var frag = document.createDocumentFragment();
                    node.textContent.split('').forEach(function (ch) {
                        if (ch === ' ') { frag.appendChild(document.createTextNode(' ')); return; }
                        var s = document.createElement('span'); s.className = 'wchar'; s.textContent = ch; frag.appendChild(s);
                    });
                    node.parentNode.replaceChild(frag, node);
                });
            }
            document.querySelectorAll('#welcome-page h1').forEach(splitChars);
            var chars = Array.prototype.slice.call(document.querySelectorAll('#welcome-page .wchar'));
            var mx = -9999, my = -9999;
            window.addEventListener('pointermove', function (e) { mx = e.clientX; my = e.clientY; }, { passive: true });
            (function tick() {
                for (var i = 0; i < chars.length; i++) {
                    var s = chars[i], r = s.getBoundingClientRect();
                    if (r.bottom < -80 || r.top > innerHeight + 80) continue;
                    var d = Math.hypot(mx - (r.left + r.width / 2), my - (r.top + r.height / 2));
                    var w = d < 200 ? 600 + (1 - d / 200) * 300 : 600;
                    s.style.fontVariationSettings = "'wght' " + Math.round(w);
                }
                requestAnimationFrame(tick);
            })();
        })();
    </script>
@endsection