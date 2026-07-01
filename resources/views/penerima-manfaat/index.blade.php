@extends('layouts.app')
@section('content')

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Penerima Manfaat</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar Penerima Manfaat Binaan Dinsos PPPA Kabupaten Cilacap.</p>
        </div>
        <div>
            <a href="{{ route('penerima-manfaat.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl text-sm transition-all shadow-sm shadow-blue-500/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Penerima Manfaat
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 text-sm font-medium rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Data Register Penerima</h3>
            <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-2.5 py-1 rounded-full">Total: {{ $penerimaManfaat->total() }} Orang</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="p-4 pl-6">Nama Lengkap</th>
                        <th class="p-4">NIK</th>
                        <th class="p-4">Wilayah</th>
                        <th class="p-4">WhatsApp</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700 font-medium">
                    @forelse($penerimaManfaat as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 pl-6 font-bold text-gray-900">{{ $item->nama_lengkap }}</td>
                            <td class="p-4 font-mono text-gray-500">{{ Str::mask($item->nik, '*', 4, 8) }}</td>
                            <td class="p-4">
                                <div class="text-gray-900">{{ $item->desa }}</div>
                                <div class="text-gray-400 text-[11px] mt-0.5">Kec. {{ $item->kecamatan }}</div>
                            </td>
                            <td class="p-4">
                                @if($item->no_wa)
                                    <a href="https://wa.me/{{ str_starts_with($item->no_wa, '0') ? '62'.substr($item->no_wa, 1) : $item->no_wa }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $item->no_wa }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'disetujui' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$item->status_verifikasi] ?? 'bg-gray-100' }}">
                                    {{ ucfirst($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('penerima-manfaat.show', $item->id) }}" class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('penerima-manfaat.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('penerima-manfaat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 font-normal">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                    Belum ada data penerima manfaat.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-50">
            {{ $penerimaManfaat->links() }}
        </div>
    </div>
@endsection