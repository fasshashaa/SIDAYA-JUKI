@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>
    
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl border">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Mitra UEP</label>
                <select name="uep_id" class="w-full p-3 border rounded-xl">
                    @foreach($ueps as $uep)
                        <option value="{{ $uep->id }}" {{ $produk->uep_id == $uep->id ? 'selected' : '' }}>
                            {{ $uep->nama_usaha }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-500 uppercase">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="w-full p-3 border rounded-xl" required>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-500 uppercase">Kategori</label>
                <input type="text" name="kategori" value="{{ $produk->kategori }}" class="w-full p-3 border rounded-xl" required>
            </div>

            <input type="number" name="harga_jual" value="{{ $produk->harga_jual }}" class="w-full p-3 border rounded-xl" placeholder="Harga">
            <input type="number" name="stok" value="{{ $produk->stok }}" class="w-full p-3 border rounded-xl" placeholder="Stok">

            <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Status</label>
                <select name="status_publikasi" class="w-full p-3 border rounded-xl">
                    <option value="Ditampilkan" {{ $produk->status_publikasi == 'Ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                    <option value="Draft" {{ $produk->status_publikasi == 'Draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <p class="text-xs text-gray-400 mb-2">Foto Saat Ini:</p>
                <img src="{{ asset('storage/' . $produk->foto_produk) }}" class="w-32 h-32 object-cover rounded-xl mb-2">
                <input type="file" name="foto_produk" class="w-full">
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('produk.index') }}" class="px-6 py-3 text-gray-600">Batal</a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl">Update Produk</button>
        </div>
    </form>
</div>
@endsection