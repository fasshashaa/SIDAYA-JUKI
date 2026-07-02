<div class="rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Log</p>
            <h3 class="font-bold" style="color: var(--text-strong)">Aktivitas Terbaru</h3>
        </div>
        <a href="#" class="text-xs font-semibold text-teal-600 hover:text-teal-700">Lihat Semua</a>
    </div>

    <div class="divide-y" style="border-color: var(--surface-border)">
        {{-- Isi $data['recentActivities'] dari controller, mis. Activity::latest()->take(5)->get() --}}
        @forelse($data['recentActivities'] ?? [] as $activity)
            <div class="flex items-start gap-4 py-4">
                <div class="w-9 h-9 shrink-0 rounded-full bg-teal-50 flex items-center justify-center text-xs font-bold text-teal-600 uppercase">
                    {{ Str::substr($activity->causer_name ?? 'SY', 0, 2) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm" style="color: var(--text-body)">
                        <span class="font-semibold" style="color: var(--text-strong)">{{ $activity->causer_name ?? 'Sistem' }}</span>
                        {{ $activity->description ?? 'melakukan perubahan data' }}
                    </p>
                    <p class="text-xs mt-0.5" style="color: var(--text-muted)">{{ optional($activity->created_at ?? null)->diffForHumans() ?? '-' }}</p>
                </div>
            </div>
        @empty
            <div class="py-10 text-center">
                <p class="text-sm" style="color: var(--text-muted)">Belum ada aktivitas untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>
</div>