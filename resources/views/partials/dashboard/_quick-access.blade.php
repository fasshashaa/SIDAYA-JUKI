<div class="rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
    <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400 mb-1">Shortcut</p>
    <h3 class="font-bold mb-5" style="color: var(--text-strong)">Akses Cepat</h3>

    <div class="space-y-2.5">
        {{-- Sesuaikan nama route dengan route list kamu --}}
        <a href="{{ route('penerima-manfaat.create') }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
            <div class="w-9 h-9 rounded-lg bg-teal-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </div>
            <span class="text-sm font-medium" style="color: var(--text-body)">Tambah Penerima Manfaat</span>
        </a>
        <a href="{{ route('produk.create') }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
            <div class="w-9 h-9 rounded-lg bg-cyan-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5" /></svg>
            </div>
            <span class="text-sm font-medium" style="color: var(--text-body)">Tambah Produk</span>
        </a>
        <a href="{{ route($data['targetRoute'], ['status_verifikasi' => 'pending']) }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
            <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-sm font-medium" style="color: var(--text-body)">Verifikasi Data Pending</span>
        </a>
    </div>
</div>