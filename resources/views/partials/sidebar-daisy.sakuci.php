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
    if (!$currentUser && $dbConnected) {
        try {
            $canRegister = \App\Models\Role::where('can_register', 1)->exists();
        } catch (\Throwable $e) {
            $canRegister = false;
        }
    }
@endphp


<aside class="h-full w-64 flex flex-col" style="background: var(--surface); border-right: 1px solid var(--line);">
 
    {{-- Brand + status koneksi database + toggle tema --}}
    <div class="flex items-center justify-between gap-2 px-5 py-5" style="border-bottom: 1px solid var(--line);">
        <div class="flex items-center gap-2 min-w-0">
            <span class="relative flex-none w-2.5 h-2.5 rounded-full"
                  style="background: {{ $dbConnected ? '#22c55e' : '#ef4444' }};"
                  title="Database {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }}"
                  aria-label="Status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }}"></span>
            <a href="{{ route('home') }}" class="font-display font-semibold truncate" style="color: var(--text);">
                {{ config('app.name') }}
            </a>
        </div>
 
        <button type="button" onclick="toggleSakuciTheme()"
                class="flex-none btn btn-ghost btn-xs btn-circle"
                style="color: var(--text-dim);"
                aria-label="Ganti mode terang/gelap" title="Ganti mode terang/gelap">
            {{-- Ikon matahari: tampil saat mode gelap aktif (klik untuk ke mode terang) --}}
            <svg class="theme-icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4"/>
                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
            </svg>
            {{-- Ikon bulan: tampil saat mode terang aktif (klik untuk ke mode gelap) --}}
            <svg class="theme-icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
            </svg>
        </button>
    </div>
 
    {{-- Menu --}}
    <nav class="flex-1 px-3 py-4 overflow-y-auto">
        <ul class="menu w-full gap-1 p-0">
            <li>
                <a href="{{ route('home') }}"
                   class="{{ is_route('home') ? 'font-medium' : '' }}"
                   style="color: {{ is_route('home') ? 'var(--brand-bright)' : 'var(--text-dim)' }};
                          background: {{ is_route('home') ? 'var(--surface-2)' : 'transparent' }};">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('kategori.index') }}"
                   class="{{ is_route('kategori.index') ? 'font-medium' : '' }}"
                   style="color: {{ is_route('kategori.index') ? 'var(--brand-bright)' : 'var(--text-dim)' }};
                          background: {{ is_route('kategori.index') ? 'var(--surface-2)' : 'transparent' }};">
                    Kategori
                </a>
            </li>
            <li>
                <a href="{{ route('alat.index') }}"
                   class="{{ is_route('alat.index') ? 'font-medium' : '' }}"
                   style="color: {{ is_route('alat.index') ? 'var(--brand-bright)' : 'var(--text-dim)' }};
                          background: {{ is_route('alat.index') ? 'var(--surface-2)' : 'transparent' }};">
                    Alat
                </a>
            </li>
 
            @if ($currentUser)
                <li>
                    <a href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                       class="{{ is_route('admin.dashboard', 'dashboard') ? 'font-medium' : '' }}"
                       style="color: {{ is_route('admin.dashboard', 'dashboard') ? 'var(--brand-bright)' : 'var(--text-dim)' }};
                              background: {{ is_route('admin.dashboard', 'dashboard') ? 'var(--surface-2)' : 'transparent' }};">
                        Dashboard
                    </a>
                </li>
            @else
                @if ($canRegister)
                    <li>
                        <a href="{{ route('register') }}"
                           class="{{ is_route('register') ? 'font-medium' : '' }}"
                           style="color: {{ is_route('register') ? 'var(--brand-bright)' : 'var(--text-dim)' }};
                                  background: {{ is_route('register') ? 'var(--surface-2)' : 'transparent' }};">
                            Daftar
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
 
    {{-- Aksi akun, ditempel di bawah --}}
    <div class="px-3 py-4" style="border-top: 1px solid var(--line);">
        @if ($currentUser)
            <div class="px-3 mb-2 text-sm" style="color: var(--text-dim);">{{ $currentUser->username }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-block border-none"
                        style="background: var(--surface-2); color: var(--text);">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="btn btn-sm btn-block border-none text-white"
               style="background: var(--brand);">
                Masuk
            </a>
        @endif
    </div>
</aside>
 