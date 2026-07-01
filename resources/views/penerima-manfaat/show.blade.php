@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Detail Penerima Manfaat</h1>
        <a href="{{ route('penerima-manfaat.index') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar</a>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-3xl p-8">
        <div class="mb-8 border-b pb-6">
            <h2 class="text-3xl font-extrabold text-gray-900">{{ $penerima->nama_lengkap }}</h2>
            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                {{ ucfirst($penerima->status_verifikasi) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            <div class="space-y-6">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Ibu Kandung</span>
                    <p class="text-lg text-gray-800 font-medium">{{ $penerima->nama_ibu_kandung }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">NIK</span>
                    <p class="text-lg text-gray-800 font-medium font-mono">{{ $penerima->nik }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor WhatsApp</span>
                    <p class="text-lg text-gray-800 font-medium">{{ $penerima->no_wa ?? '-' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Kartu Keluarga</span>
                    <p class="text-lg text-gray-800 font-medium font-mono">{{ $penerima->no_kk }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Wilayah (Kecamatan / Desa)</span>
                    <p class="text-lg text-gray-800 font-medium">{{ $penerima->kecamatan }} / {{ $penerima->desa     }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat Detail</span>
                    <p class="text-lg text-gray-800 font-medium">{{ $penerima->alamat_detail }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection