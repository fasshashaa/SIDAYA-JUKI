@extends('layouts.app')
@section('content')

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Kelolaan UEP</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar Usaha Ekonomi Produktif Kabupaten Cilacap.</p>
        </div>
        <div>
            <a href="{{ route('uep.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl text-sm transition-all shadow-sm shadow-blue-500/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Usaha Baru
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
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Data Register UEP</h3>
            <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-2.5 py-1 rounded-full">Total: {{ $ueps->count() }} Usaha</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="p-4 pl-6">Nama Usaha / Pemilik</th>
                        <th class="p-4">Kategori Produk</th>
                        <th class="p-4">Wilayah Usaha</th>
                        <th class="p-4">Perkembangan</th>
                          <th class="p-4">Verifikasi</th>
                          <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700 font-medium">
                    @forelse($ueps as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                         <td class="p-4 pl-6">
    <div class="font-bold text-gray-900">{{ $item->nama_usaha }}</div>
    
    @if($item->penerimaManfaat)
        <div class="text-xs text-gray-400 mt-0.5">
            {{ $item->penerimaManfaat->nama_lengkap }} • NIK {{ substr($item->nik, 0, 4) }}...
        </div>
    @else
        <div class="text-xs text-red-400 mt-0.5">Data Penerima Tidak Ditemukan</div>
    @endif
</td>
                            <td class="p-4">
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-semibold">{{ $item->kategori_produk }}</span>
                            </td>
                            <td class="p-4">
                                <div class="text-gray-900 text-xs">{{ $item->desa_kelurahan_usaha }}</div>
                                <div class="text-gray-400 text-[11px] mt-0.5">Kec. {{ $item->kecamatan_usaha }}</div>
                            </td>
                            <td class="p-4">
                                @if($item->status_perkembangan == 'mandiri')
                                    <span class="bg-green-50 text-green-600 px-2.5 py-1 rounded-full text-xs font-bold">Mandiri</span>
                                @elseif($item->status_perkembangan == 'berkembang')
                                    <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-bold">Berkembang</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full text-xs font-bold">Rintisan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
    @if($item->status_verifikasi == 'disetujui')
        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Disetujui</span>
    @elseif($item->status_verifikasi == 'ditolak')
        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Ditolak</span>
    @else
        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Pending</span>
    @endif
</td>
<td class="px-6 py-4 whitespace-nowrap">
    @if($item->status_usaha == 'Aktif')
        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Aktif</span>
    @elseif($item->status_verifikasi == 'Tidak Aktif')
        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Tidak Aktif</span>
    @else
        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Tutup Sementara</span>
    @endif
</td>

                            <td class="p-4 pr-6 text-right">
    <div class="inline-flex gap-2">
        <!-- Lihat Detail -->
        <a href="{{ route('uep.show', $item->id) }}" class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </a>
        
        <!-- Edit -->
        <a href="{{ route('uep.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </a>

        <!-- Hapus -->
        <form action="{{ route('uep.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 font-normal">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    Belum ada data register mitra UEP.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection