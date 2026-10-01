@php
$dbConnected = false;
try {
\Sakuci\Database\Connection::pdo();
$dbConnected = true;
} catch (\Throwable $e) {
$dbConnected = false;
}

$currentUser = \App\Models\User::current();

$canRegister = false;
if (! $currentUser && $dbConnected) {
try {
$canRegister = \App\Models\Role::where('can_register', 1)->exists();
} catch (\Throwable $e) {
$canRegister = false;
}
}
@endphp

{{-- Bar atas: hanya tampil di layar kecil, berisi tombol pembuka sidebar --}}
<header class="app-topbar d-lg-none border-bottom bg-body sticky-top">
    <button class="btn btn-outline-secondary border-0" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#sidebar"
        aria-controls="sidebar" aria-label="Buka menu">
        <i class="bi bi-list fs-4"></i>
    </button>
    <a class="fw-semibold text-decoration-none text-body" href="{{ route('home') }}">{{ config('app.name') }}</a>
</header>

{{-- Sidebar: laci geser di layar kecil, menetap di layar besar (offcanvas-lg bawaan Bootstrap) --}}
<aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar" aria-label="Menu utama">
    <div class="offcanvas-body">
        <div class="sidebar-brand">
            <button id="themeToggle" type="button" class="logo-toggle"
                aria-label="Ganti tema terang/gelap (status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }})"
                title="Ganti tema terang/gelap">
                <i class="bi bi-sun-fill theme-icon theme-icon-light" aria-hidden="true"></i>
                <i class="bi bi-moon-stars-fill theme-icon theme-icon-dark" aria-hidden="true"></i>
                <span class="db-status-dot {{ $dbConnected ? 'bg-success' : 'bg-danger' }}"></span>
            </button>
            <a class="navbar-brand fw-semibold m-0 me-auto sidebar-text" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas"
                data-bs-target="#sidebar" aria-label="Tutup menu"></button>
        </div>

        <ul class="nav nav-pills flex-column gap-1 sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{ is_route('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="bi bi-house"></i><span>Beranda</span>
                </a>
            </li>


            @if ($currentUser)
            <li class="nav-item">
                <a class="nav-link {{ is_route('admin.dashboard', 'dashboard') ? 'active' : '' }}"
                    href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>
            </li>

            <!--petugas-->
            @if ($currentUser->role === 'petugas')
            <li class="nav-item">
                <span class="small d-block text-body-secondary mb-1 px-3">Peminjaman & Pengembalian</span>
            <li class="nav-item">
                <a class="nav-link {{ is_route('petugas.peminjaman.index') ? 'active' : '' }}" href="{{ route('petugas.peminjaman.index') }}">
                    <i class="bi bi-journal-text"></i><span>Peminjaman</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ is_route('petugas.pengembalian.index') ? 'active' : '' }}" href="{{ route('petugas.pengembalian.index') }}">
                    <i class="bi bi-arrow-counterclockwise"></i><span>Pengembalian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ is_route('petugas.denda.index') ? 'active' : '' }}" href="{{ route('petugas.denda.index') }}">
                    <i class="bi bi-cash-stack"></i><span>Denda Peminjam</span>
                </a>
            <li class="nav-item">
                <a class="nav-link {{ is_route('petugas.peminjaman.riwayat') ? 'active' : '' }}" href="{{ route('petugas.peminjaman.riwayat') }}">
                    <i class="bi bi-clock-history"></i><span>Riwayat Peminjaman</span>
                </a>
                @endif

                <!--peminjam -->
                @if ($currentUser->role === 'peminjam')
                <li class="nav-item">
                    <hr>
                    <span class="small d-block text-body-secondary mt-1 mb-1 px-4">Peminjaman</span>
                </li>
                <a class="nav-link {{ is_route('peminjam.alat.index') ? 'active' : '' }}" href="{{ route('peminjam.alat.index') }}">
                    <i class="bi bi-journal-text"></i><span>Pinjaman Saya</span>
                </a>
                <a class="nav-link {{ is_route('peminjam.riwayat') ? 'active' : '' }}" href="{{ route('peminjam.riwayat') }}">
                    <i class="bi bi-clock-history"></i><span>Riwayat Peminjaman</span>
                </a>
                <a class="nav-link {{ is_route('peminjam.dipinjam') ? 'active' : '' }}" href="{{ route('peminjam.dipinjam') }}">
                    <i class="bi bi-stopwatch"></i><span>Alat Sedang Dipinjam</span>
                </a>
                @endif

                <!-- admin -->
                @if ($currentUser->role === 'admin')
                <li class="nav-item">
                    <hr>
                    <span class="small d-block text-body-secondary mt-1 mb-1 px-4">Manajemen Alat</span>
                </li>
            <li class="nav-item">
                <a class="nav-link {{ is_route('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                    <i class="bi bi-tags"></i><span>Kategori</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ is_route('alat.index') ? 'active' : '' }}" href="{{ route('alat.index') }}">
                    <i class="bi bi-tools"></i><span>Alat</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ is_route('admin.log.index') ? 'active' : '' }}" href="{{ route('admin.log.index') }}">
                    <i class="bi bi-clock-history"></i><span>Log Aktivitas</span>
                </a>
            </li>

                <li class="nav-item">
                    <hr>
                    <span class="small d-block text-body-secondary mt-1 mb-1 pl-6">Manajemen Pengguna</span>
                </li>
            <li class="nav-item">
                <a class="nav-link {{ is_route('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i><span>Users</span>
                </a>
            </li>

            <li class="nav-item">
    <a class="nav-link {{ is_route('admin.peminjam.index') ? 'active' : '' }}" href="{{ route('admin.peminjam.index') }}">
        <i class="bi bi-person-badge"></i><span>Peminjam</span>
    </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ is_route('admin.roles.index') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                    <i class="bi bi-shield-lock"></i><span>Roles</span>
                </a>
            </li>

            @endif

            @endif
        </ul>

        {{-- Bagian bawah: akun --}}
        <div class="sidebar-footer">
            @if ($currentUser)
            <div class="small text-body-secondary mb-2">
                <i class="bi bi-person-circle me-1"></i>{{ $currentUser->username }}
                <span class="badge text-bg-secondary ms-1">{{ $currentUser->role }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </button>
            </form>
            @else
            @if ($canRegister)
            <a class="btn btn-sm btn-outline-secondary w-100 mb-2 {{ is_route('register') ? 'active' : '' }}" href="{{ route('register') }}">Daftar</a>
            @endif
            <a class="btn btn-sm btn-brand rounded-pill w-100" href="{{ route('login') }}">
                <i class="bi bi-person me-1"></i>Masuk
            </a>
            @endif
        </div>

    </div>
</aside>