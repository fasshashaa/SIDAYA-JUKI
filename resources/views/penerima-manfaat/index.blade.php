<x-app-layout>
    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Penerima Manfaat</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar Penerima Manfaat Binaan Dinsos PPPA Kabupaten Cilacap</p>
        </div>
        
        <div class="bg-white border border-gray-100 px-4 py-2 rounded-xl shadow-sm text-sm font-medium text-gray-700 flex items-center gap-2">
            <span class="text-gray-400">📅</span> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <div class="flex items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-2">
        </div>
        <a href="{{ route('penerima-manfaat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all shadow-sm">
            + Tambah Penerima Manfaat
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-sm font-medium">
            ✨ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100/50 p-8 min-h-[400px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                        <th class="py-4 px-4 rounded-l-xl">Nama Lengkap</th>
                        <th class="py-4 px-4">NIK</th>
                        <th class="py-4 px-4">Kecamatan</th>
                        <th class="py-4 px-4">Desa</th>
                        <th class="py-4 px-4">WhatsApp</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                    @forelse($penerimaManfaat as $item)
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <td class="py-4 px-4 font-semibold text-gray-900">{{ $item->nama_lengkap }}</td>
                            <td class="py-4 px-4 font-mono text-gray-500">{{ Str::mask($item->nik, '*', 4, 8) }}</td>
                            <td class="py-4 px-4">
                                <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-medium">{{ $item->kecamatan }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-50 text-gray-700 px-2.5 py-1 rounded-lg text-xs font-medium">{{ $item->desa }}</span>
                            </td>
                            <td class="py-4 px-4 font-mono text-xs">
                                @if($item->no_wa)
                                    <a href="https://wa.me/{{ str_starts_with($item->no_wa, '0') ? '62'.substr($item->no_wa, 1) : $item->no_wa }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 font-medium">
                                        📞 {{ $item->no_wa }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('penerima-manfaat.edit', $item->id) }}" class="text-blue-600 hover:underline font-medium">Ubah</a>
                                    <span class="text-gray-200">|</span>
                                    <form action="{{ route('penerima-manfaat.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data master ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- PERBAIKAN: colspan disesuaikan menjadi 6 kolom penuh agar sejajar --}}
                            <td colspan="6" class="py-20 text-center text-gray-400 font-medium">
                                📭 Belum ada data Penerima Manfaat yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $penerimaManfaat->links() }}
        </div>
    </div>
</x-app-layout>