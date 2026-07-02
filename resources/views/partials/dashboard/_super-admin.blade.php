<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400 mb-1">Overview</p>
        <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--text-strong)">Dashboard</h1>
        <p class="text-sm mt-1" style="color: var(--text-muted)">
            Selamat datang kembali, <span class="font-semibold" style="color: var(--text-body)">{{ auth()->user()->name }}</span>. Pantau seluruh aktivitas sistem hari ini.
        </p>
    </div>
    <div class="flex items-center gap-2 text-sm px-4 py-2.5 rounded-xl border shadow-sm"
         style="background: var(--surface); border-color: var(--surface-border)">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
        </span>
        <span class="font-medium" style="color: var(--text-muted)">Sistem Berjalan Normal</span>
    </div>
</div>

<div class="relative overflow-hidden rounded-3xl p-8 md:p-10 shadow-xl shadow-slate-900/10 mt-8"
     style="background: linear-gradient(135deg, #0A1F38, #0B2A4A);">
    <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full blur-3xl" style="background: rgba(95, 217, 232, 0.15)"></div>
    <div class="absolute -bottom-24 -left-10 w-72 h-72 rounded-full blur-3xl" style="background: rgba(14, 124, 158, 0.15)"></div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-400/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-amber-400/80 mb-1">Butuh Tindakan</p>
                <h2 class="text-lg font-bold text-white">Perlu Verifikasi</h2>
                <p class="text-slate-400 text-sm mt-1 max-w-md">
                    Terdapat <span class="font-bold text-amber-400">{{ $data['pendingVerifikasi'] }}</span> item yang menunggu tindakan Anda.
                </p>
            </div>
        </div>
        @if($data['pendingVerifikasi'] > 0)
            <a href="{{ route($data['targetRoute'], ['status_verifikasi' => 'pending']) }}"
               class="group inline-flex items-center justify-center gap-2 bg-white hover:bg-cyan-50 text-slate-900 font-semibold px-6 py-3.5 rounded-2xl transition-all shadow-lg shadow-black/10 text-sm whitespace-nowrap">
                Proses Verifikasi Sekarang
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <div class="inline-flex items-center gap-2 px-6 py-3.5 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 rounded-2xl text-sm font-semibold whitespace-nowrap">
                Semua Data Sudah Diverifikasi
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mt-8">
    <div class="group relative p-6 rounded-2xl shadow-sm transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
         style="background: linear-gradient(135deg, #0A1F38, #0B2A4A);">
        <div class="w-11 h-11 rounded-xl bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center">
            <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <p class="text-[11px] font-bold text-cyan-300/70 uppercase tracking-wider mt-5">Total User</p>
        <h3 class="text-3xl font-extrabold text-white mt-1 tabular-nums">{{ number_format($data['totalUser']) }}</h3>
        <div class="mt-4 flex items-center gap-2 pt-4 border-t border-white/10">
            <span class="h-1.5 w-1.5 rounded-full bg-cyan-400"></span>
            <span class="text-xs font-medium text-cyan-100/50">Akses sistem</span>
        </div>
    </div>
    <div class="sm:col-span-1 lg:col-span-4">
        @include('partials.dashboard._stat-cards', ['data' => $data])
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-8">
    <div class="lg:col-span-2 rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Analitik</p>
                <h3 class="font-bold" style="color: var(--text-strong)">Grafik Sebaran Bantuan</h3>
            </div>
        </div>
        <canvas id="bantuanChart" height="110"></canvas>
    </div>
    <div class="rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Proporsi</p>
                <h3 class="font-bold" style="color: var(--text-strong)">Distribusi Bantuan</h3>
            </div>
        </div>
        <canvas id="distribusiChart" height="180"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-8">
    <div class="lg:col-span-2">@include('partials.dashboard._recent-activity', ['data' => $data])</div>
    <div>@include('partials.dashboard._quick-access', ['data' => $data])</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const barCanvas = document.getElementById('bantuanChart');
    if (barCanvas) {
        const gradient = barCanvas.getContext('2d').createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, '#0E7C9E');
        gradient.addColorStop(1, '#5FD9E8');
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: ['PM', 'UEP', 'KUBE'],
                datasets: [{ label: 'Jumlah Bantuan', data: [{{ $data['totalPM'] }}, {{ $data['totalUEP'] }}, {{ $data['totalKUBE'] }}], backgroundColor: gradient, borderRadius: 8, maxBarThickness: 56 }]
            },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.15)' } }, x: { grid: { display: false } } } }
        });
    }
    const donutCanvas = document.getElementById('distribusiChart');
    if (donutCanvas) {
        new Chart(donutCanvas, {
            type: 'doughnut',
            data: { labels: ['PM', 'UEP', 'KUBE'], datasets: [{ data: [{{ $data['totalPM'] }}, {{ $data['totalUEP'] }}, {{ $data['totalKUBE'] }}], backgroundColor: ['#0E7C9E', '#5FD9E8', '#94A3B8'], borderWidth: 0 }] },
            options: { responsive: true, cutout: '68%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } } }
        });
    }
});
</script>