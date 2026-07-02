@php
    $stats = [
        [
            'label' => 'Total Penerima Manfaat', 'value' => $data['totalPM'], 'trend' => '+4.2%', 'up' => true,
            'ring' => 'ring-teal-500/10', 'iconBg' => 'bg-teal-50', 'iconText' => 'text-teal-600', 'dot' => 'bg-teal-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />',
        ],
        [
            'label' => 'Total UEP', 'value' => $data['totalUEP'], 'trend' => '+1.8%', 'up' => true,
            'ring' => 'ring-cyan-500/10', 'iconBg' => 'bg-cyan-50', 'iconText' => 'text-cyan-700', 'dot' => 'bg-cyan-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />',
        ],
        [
            'label' => 'Total KUBE', 'value' => $data['totalKUBE'], 'trend' => '-0.6%', 'up' => false,
            'ring' => 'ring-slate-500/10', 'iconBg' => 'bg-slate-100', 'iconText' => 'text-slate-600', 'dot' => 'bg-slate-400',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477" />',
        ],
        [
            'label' => 'Total Katalog Produk', 'value' => $data['totalProduk'], 'trend' => '+7.4%', 'up' => true,
            'ring' => 'ring-emerald-500/10', 'iconBg' => 'bg-emerald-50', 'iconText' => 'text-emerald-600', 'dot' => 'bg-emerald-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />',
        ],
    ];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    @foreach($stats as $stat)
    <div class="group relative p-6 rounded-2xl border shadow-sm ring-1 {{ $stat['ring'] }} transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
         style="background: var(--surface); border-color: var(--surface-border)">
        <div class="flex items-start justify-between">
            <div class="w-11 h-11 rounded-xl {{ $stat['iconBg'] }} flex items-center justify-center">
                <svg class="w-5 h-5 {{ $stat['iconText'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $stat['icon'] !!}
                </svg>
            </div>
            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-1 rounded-full {{ $stat['up'] ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                <svg class="w-3 h-3 {{ $stat['up'] ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                </svg>
                {{ $stat['trend'] }}
            </span>
        </div>
        <p class="text-[11px] font-bold uppercase tracking-wider mt-5" style="color: var(--text-muted)">{{ $stat['label'] }}</p>
        <h3 class="text-3xl font-extrabold mt-1 tabular-nums" style="color: var(--text-strong)">{{ number_format($stat['value']) }}</h3>
        <div class="mt-4 flex items-center gap-2 pt-4 border-t" style="border-color: var(--surface-border)">
            <span class="h-1.5 w-1.5 rounded-full {{ $stat['dot'] }}"></span>
            <span class="text-xs font-medium" style="color: var(--text-muted)">Data aktif &middot; diperbarui hari ini</span>
        </div>
    </div>
    @endforeach
</div>