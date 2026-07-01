@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Detail Kelompok KUBE</h1>
        <a href="{{ route('kube.index') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar</a>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-3xl p-8">
        <div class="mb-8 border-b pb-6">
            <h2 class="text-3xl font-extrabold text-gray-900">{{ $kube->nama_kelompok_kube }}</h2>
            <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">
                {{ $kube->jenis_usaha_kube }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Operasional</h4>
                <div class="space-y-4">
                    <p><span class="block text-sm text-gray-500">Kecamatan</span> {{ $kube->kecamatan_kube }}</p>
                    <p><span class="block text-sm text-gray-500">Desa / Kelurahan</span> {{ $kube->desa_kube }}</p>
                    <p><span class="block text-sm text-gray-500">Alamat Lengkap</span> {{ $kube->alamat_lengkap_kube }}</p>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Data Anggota & Kontak</h4>
                <div class="space-y-4">
                    <p><span class="block text-sm text-gray-500">Ketua Kelompok</span> {{ $kube->ketua->nama_lengkap ?? 'Tidak ada data' }}</p>
                    <p><span class="block text-sm text-gray-500">Jumlah Anggota</span> {{ $kube->jumlah_anggota }} Orang</p>
                    <p><span class="block text-sm text-gray-500">No. Telepon</span> {{ $kube->no_telp_kube }}</p>
                </div>
            </div>

            <div class="md:col-span-2 pt-6 border-t">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status & Pembiayaan</h4>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <span class="block text-sm text-gray-500">Tahun Realisasi</span>
                        <p class="font-semibold">{{ $kube->tahun_realisasi }}</p>
                    </div>
                    <div>
                        <span class="block text-sm text-gray-500">Sumber Anggaran</span>
                        <p class="font-semibold">{{ $kube->sumber_anggaran }}</p>
                    </div>
                    <div>
                        <span class="block text-sm text-gray-500">Status Verifikasi</span>
                        <p class="font-semibold capitalize">{{ $kube->status_verifikasi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection