<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400 mb-1">Overview</p>
        <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--text-strong)">Dashboard</h1>
        <p class="text-sm mt-1" style="color: var(--text-muted)">
            Selamat datang kembali, <span class="font-semibold" style="color: var(--text-body)">{{ auth()->user()->name }}</span>.
        </p>
    </div>
</div>

<div class="mt-8">
    @include('partials.dashboard._stat-cards', ['data' => $data])
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-8">
    <div class="lg:col-span-2">@include('partials.dashboard._recent-activity', ['data' => $data])</div>
    <div>@include('partials.dashboard._quick-access', ['data' => $data])</div>
</div>