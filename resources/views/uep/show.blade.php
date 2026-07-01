@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Detail Data UEP</h1>
        <a href="{{ route('uep.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-3xl p-8">
        <!-- I. Data Penerima Manfaat -->
        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2">I. Data Penerima Manfaat</h3>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <p><span class="block text-xs text-gray-500">Nama Lengkap</span> {{ $uep->penerimaManfaat->nama_lengkap }}</p>
            <p><span class="block text-xs text-gray-500">NIK</span> {{ $uep->penerimaManfaat->nik }}</p>
            <p><span class="block text-xs text-gray-500">No. KK</span> {{ $uep->penerimaManfaat->no_kk }}</p>
            <p><span class="block text-xs text-gray-500">No. WhatsApp</span> {{ $uep->penerimaManfaat->no_wa }}</p>
        </div>

        <!-- II. Profil Usaha -->
        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2">II. Profil Usaha</h3>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <p><span class="block text-xs text-gray-500">Nama Usaha</span> {{ $uep->nama_usaha }}</p>
            <p><span class="block text-xs text-gray-500">Kategori</span> {{ $uep->kategori_produk }}</p>
            <p><span class="block text-xs text-gray-500">Tahun Realisasi</span> {{ $uep->tahun_realisasi }}</p>
            <p><span class="block text-xs text-gray-500">Wilayah</span> {{ $uep->kecamatan_usaha }}, {{ $uep->desa_kelurahan_usaha }}</p>
            <p class="col-span-2"><span class="block text-xs text-gray-500">Alamat Lengkap</span> {{ $uep->alamat_lengkap }}</p>
            
        </div>

        <!-- III. Data Pembiayaan -->
        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2">III. Data Pembiayaan & Verifikasi</h3>
        <div class="grid grid-cols-3 gap-4">
            
            <p><span class="block text-xs text-gray-500">Sumber Anggaran</span> {{ $uep->sumber_anggaran }}</p>
            <p>
                <span class="block text-xs text-gray-500">Status Verifikasi</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                    {{ $uep->status_verifikasi == 'disetujui' ? 'bg-green-100 text-green-700' : 
                       ($uep->status_verifikasi == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($uep->status_verifikasi) }}
                </span>
            </p>
            <p>
                <span class="block text-xs text-gray-500">Status Usaha</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                    {{ $uep->status_usaha == 'Aktif' ? 'bg-green-100 text-green-700' : 
                       ($uep->status_usaha == 'Tidak Aktif' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($uep->status_usaha) }}
                </span>
            </p>
        </div>
    </div>
</div>
@endsection