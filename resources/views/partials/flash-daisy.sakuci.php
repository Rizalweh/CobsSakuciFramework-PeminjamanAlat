{{-- Notifikasi flash & daftar error validasi, versi gelap DaisyUI --}}

@if (session('success'))
    <div class="rounded-lg px-4 py-3 mb-4 flex items-start justify-between gap-3"
         style="background: var(--surface-2); border: 1px solid #22c55e; color: var(--text);" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="opacity-60 hover:opacity-100" style="color: var(--text);"
                onclick="this.closest('[role=alert]').remove()" aria-label="Tutup">&times;</button>
    </div>
@endif

@if (session('error'))
    <div class="rounded-lg px-4 py-3 mb-4 flex items-start justify-between gap-3"
         style="background: var(--surface-2); border: 1px solid #ef4444; color: var(--text);" role="alert">
        <span>{{ session('error') }}</span>
        <button type="button" class="opacity-60 hover:opacity-100" style="color: var(--text);"
                onclick="this.closest('[role=alert]').remove()" aria-label="Tutup">&times;</button>
    </div>
@endif

@if (errors()->any())
    <div class="rounded-lg px-4 py-3 mb-4"
         style="background: var(--surface-2); border: 1px solid #ef4444; color: var(--text);" role="alert">
        <div class="flex items-start justify-between gap-3">
            <strong>Periksa kembali isian Anda:</strong>
            <button type="button" class="opacity-60 hover:opacity-100" style="color: var(--text);"
                    onclick="this.closest('[role=alert]').remove()" aria-label="Tutup">&times;</button>
        </div>
        <ul class="mt-2 ps-4 space-y-1 text-sm" style="color: var(--text-dim);">
            @foreach (errors()->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    </div>
@endif
