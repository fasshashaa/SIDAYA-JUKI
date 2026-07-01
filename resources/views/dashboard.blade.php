@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-slate-800">Dashboard Admin Verifikator</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-amber-50 p-6 rounded-2xl border border-amber-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-amber-800 font-semibold">Data Menunggu Verifikasi</p>
                <p class="text-3xl font-bold text-amber-900">{{ $data['pendingVerifikasi'] }}</p>
            </div>
            <a href="#" class="bg-amber-500 text-white px-4 py-2 rounded-xl text-sm font-bold">Proses Verifikasi</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-500 uppercase">Total PM</p>
            <h3 class="text-2xl font-bold">{{ $data['totalPM'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-500 uppercase">Total UEP</p>
            <h3 class="text-2xl font-bold">{{ $data['totalUEP'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-500 uppercase">Total KUBE</p>
            <h3 class="text-2xl font-bold">{{ $data['totalKUBE'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs text-slate-500 uppercase">Total Produk</p>
            <h3 class="text-2xl font-bold">{{ $data['totalProduk'] }}</h3>
        </div>
    </div>
</div>
@endsection