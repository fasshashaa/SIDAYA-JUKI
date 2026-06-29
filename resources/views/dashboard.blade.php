<x-app-layout>
    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Utama</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Informasi Pemberdayaan dan Data Pemberian Bantuan Sosial Cilacap</p>
        </div>
        
        <div class="bg-white border border-gray-100 px-4 py-2 rounded-xl shadow-sm text-sm font-medium text-gray-700 flex items-center gap-2">
            <span class="text-gray-400">📅</span> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-gray-100/70 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Penerima Manfaat</span>
                <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ number_format($totalPenerima) }}</span>
                <span class="text-xs text-emerald-600 block mt-1 font-medium">👤 Individu Terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-xl text-blue-600">
                👥
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100/70 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Kelolaan UEP</span>
                <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ number_format($totalUEP) }}</span>
                <span class="text-xs text-orange-600 block mt-1 font-medium">🛍️ Usaha Ekonomi Produktif</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-xl text-orange-500">
                🛍️
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100/70 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Kelompok KUBE</span>
                <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ number_format($totalKUBE) }}</span>
                <span class="text-xs text-indigo-600 block mt-1 font-medium">🏢 Kelompok Bersama Binaan</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-xl text-indigo-600">
                🏢
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100/50 lg:col-span-2">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Sebaran Wilayah Penerima Manfaat</h3>
                <p class="text-xs text-gray-400 mt-0.5">Top 5 wilayah Kecamatan dengan intensitas binaan tertinggi di Cilacap</p>
            </div>

            <div class="space-y-5">
                @forelse($sebaranKecamatan as $kec)
                    <div>
                        <div class="flex justify-between text-sm font-medium text-gray-700 mb-1.5">
                            <span>Kecamatan {{ $kec->kecamatan }}</span>
                            <span class="text-gray-500 font-semibold">{{ $kec->total }} Jiwa</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" 
                                 style="width: {{ $totalPenerima > 0 ? min(($kec->total / $totalPenerima) * 100, 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-sm text-gray-400 font-medium">
                        📭 Belum ada data persebaran wilayah di database.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100/50">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Registrasi Terbaru</h3>
                <p class="text-xs text-gray-400 mt-0.5">Entri data master paling mutakhir</p>
            </div>

            <div class="flow-root">
                <ul class="-mb-8">
                    @forelse($aktivitasTerbaru as $index => $aktivitas)
                        <li>
                            <div class="relative pb-6">
                                @if($index !== count($aktivitasTerbaru) - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-xl bg-orange-50 flex items-center justify-center text-xs">
                                            👤
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $aktivitas->nama_lengkap }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5 mb-1">
                                            Daftar di {{ $aktivitas->kecamatan }}, {{ $aktivitas->desa }}
                                        </p>
                                        <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                            Baru
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <div class="py-12 text-center text-sm text-gray-400 font-medium">
                            📭 Tidak ada aktivitas pendaftaran baru.
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>