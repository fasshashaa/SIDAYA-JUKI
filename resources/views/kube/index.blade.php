@extends('layouts.app')
@section('content')
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Kelompok KUBE</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar Kelompok Usaha Bersama Binaan Dinsos PPPA Cilacap.</p>
        </div>
        <div>
            <a href="{{ route('kube.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl text-sm transition-all shadow-sm shadow-blue-500/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kelompok Baru
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Data Register KUBE</h3>
           <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-2.5 py-1 rounded-full">Total: {{ $kubes->count() }} Kelompok</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-500 font-semibold">
                    <th class="p-4 pl-6">Nama Kelompok</th>
        <th class="p-4">Ketua</th>
        <th class="p-4 text-center">Anggota</th>
        <th class="p-4">Lokasi</th>
        <th class="p-4">Status</th>
        <th class="p-4 pr-6 text-center">Aksi</th>
                    </tr>
                </thead>
            <tbody class="divide-y divide-gray-50 text-gray-700 font-medium">
    @forelse($kubes as $kube)
    <tr>
        <td class="p-4 pl-6">{{ $kube->nama_kelompok_kube }}</td>
        <td class="p-4">{{ $kube->ketua ? $kube->ketua->nama_lengkap : '-' }}</td>
        <td>
    {{ $kube->jumlah_anggota }} 
   
</td>
        <td class="p-4 text-xs">{{ $kube->desa_kube }}, {{ $kube->kecamatan_kube }}</td>
        <td class="p-4">
            {{-- Badge Status --}}
            @if($kube->status_verifikasi == 'disetujui')
                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">Disetujui</span>
            @elseif($kube->status_verifikasi == 'ditolak')
                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">Ditolak</span>
            @else
                <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full">Pending</span>
            @endif
        </td>

        <td class="p-4 pr-6 text-right">
    <div class="inline-flex gap-2">
        <!-- Lihat Detail -->
        <a href="{{ route('kube.show', $kube->id) }}" class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </a>
        
        <!-- Edit -->
        <a href="{{ route('kube.edit', $kube->id) }}" class="p-2 text-gray-400 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </a>

        <!-- Hapus -->
        <form action="{{ route('kube.destroy', $kube->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
        <td colspan="6" class="p-12 text-center text-gray-400">Belum ada data...</td>
    </tr>
    @endforelse
            </table>
        </div>
    </div>
@endsection