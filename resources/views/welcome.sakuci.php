@extends('layouts.app')

@section('title', config('app.name') . ' -- Peminjaman Alat')

@section('content')

    @php
        // $stat = ['total' => Alat::count(), 'tersedia' => Alat::where('status','tersedia')->count(), ...];
        // $kategori = Kategori::all();
        // $alatTerbaru = Alat::with('kategori')->latest()->take(6)->get();
        $stat = [
            'total'    => 48,
            'tersedia' => 31,
            'dipinjam' => 17,
            'kategori' => 6,
        ];

        $kategori = ['Pertukangan', 'Elektronik', 'Laboratorium', 'Olahraga', 'Kebersihan', 'Dapur'];

        $alatTerbaru = [
            ['nama' => 'Bor Listrik Bosch',      'kategori' => 'Pertukangan',  'status' => 'tersedia'],
            ['nama' => 'Multimeter Digital',      'kategori' => 'Elektronik',   'status' => 'dipinjam'],
            ['nama' => 'Mikroskop Binokuler',      'kategori' => 'Laboratorium', 'status' => 'tersedia'],
            ['nama' => 'Gergaji Mesin',            'kategori' => 'Pertukangan',  'status' => 'tersedia'],
            ['nama' => 'Proyektor Epson',          'kategori' => 'Elektronik',   'status' => 'dipinjam'],
            ['nama' => 'Timbangan Digital 5kg',    'kategori' => 'Laboratorium', 'status' => 'tersedia'],
        ];
    @endphp

    <section class="grid lg:grid-cols-12 gap-8 items-center mb-14">
        <div class="lg:col-span-7">
            <div class="font-mono text-sm mb-4" style="color: var(--text-dim);">Selamat datang{{ ($currentUser ?? null) ? ', ' . $currentUser->username : '' }}</div>
            <h1 class="font-display text-4xl lg:text-[3rem] font-semibold leading-[1.1] mb-4">
                Pinjam Sarana Prasarana di
                <span style="color: var(--brand-bright);">SARPRAS TECH</span>
            </h1>
            <p class="text-lg leading-relaxed mb-6" style="color: var(--text-dim); max-width: 34rem;">
                Cek ketersediaan, ajukan peminjaman, dan pantau alat semua dari satu halaman.
            </p>
        </div>

        <div class="lg:col-span-5">
            <div class="grid grid-cols-2 gap-4">
                <div class="surface rounded-lg p-5">
                    <div class="font-display text-3xl font-semibold" style="color: var(--brand-bright);">{{ $stat['total'] }}</div>
                    <div class="text-sm mt-1" style="color: var(--text-dim);">Total alat</div>
                </div>
                <div class="surface rounded-lg p-5">
                    <div class="font-display text-3xl font-semibold" style="color: #22c55e;">{{ $stat['tersedia'] }}</div>
                    <div class="text-sm mt-1" style="color: var(--text-dim);">Tersedia</div>
                </div>
                <div class="surface rounded-lg p-5">
                    <div class="font-display text-3xl font-semibold" style="color: #eab308;">{{ $stat['dipinjam'] }}</div>
                    <div class="text-sm mt-1" style="color: var(--text-dim);">Sedang dipinjam</div>
                </div>
                <div class="surface rounded-lg p-5">
                    <div class="font-display text-3xl font-semibold" style="color: var(--text);">{{ $stat['kategori'] }}</div>
                    <div class="text-sm mt-1" style="color: var(--text-dim);">Kategori</div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <h2 class="font-display text-xl font-semibold mb-6">Cara meminjam</h2>
        <div class="grid md:grid-cols-4 gap-5">
            <div class="surface rounded-lg p-5">
                <span class="font-mono text-sm" style="color: var(--brand-bright);">01</span>
                <div class="font-medium mt-2 mb-1">Pilih alat</div>
                <div class="text-sm" style="color: var(--text-dim);">Cari di halaman Alat, cek status ketersediaannya.</div>
            </div>
            <div class="surface rounded-lg p-5">
                <span class="font-mono text-sm" style="color: var(--brand-bright);">02</span>
                <div class="font-medium mt-2 mb-1">Ajukan peminjaman</div>
                <div class="text-sm" style="color: var(--text-dim);">Isi tanggal dan lama pemakaian, lalu kirim pengajuan.</div>
            </div>
            <div class="surface rounded-lg p-5">
                <span class="font-mono text-sm" style="color: var(--brand-bright);">03</span>
                <div class="font-medium mt-2 mb-1">Tunggu persetujuan</div>
                <div class="text-sm" style="color: var(--text-dim);">Admin memverifikasi pengajuan lewat Dashboard.</div>
            </div>
            <div class="surface rounded-lg p-5">
                <span class="font-mono text-sm" style="color: var(--brand-bright);">04</span>
                <div class="font-medium mt-2 mb-1">Ambil &amp; kembalikan</div>
                <div class="text-sm" style="color: var(--text-dim);">Ambil alat sesuai jadwal, kembalikan tepat waktu.</div>
            </div>
        </div>
    </section>

@endsection