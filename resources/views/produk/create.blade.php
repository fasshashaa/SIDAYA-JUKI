@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
        <p class="text-sm text-gray-500">Isikan detail informasi produk UMKM dengan lengkap.</p>
    </div>

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        @csrf
   <div class="space-y-2 md:col-span-2">
    <label class="text-xs font-bold text-gray-500 uppercase">Pilih Mitra UEP *</label>
    <select name="uep_id" id="uep_select" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white" required>
        <option value="" disabled selected>-- Pilih UEP Pemilik Produk --</option>
        @foreach($ueps as $uep)
            {{-- Tambahkan data-wa dan data-kategori agar bisa dibaca JS --}}
            <option value="{{ $uep->id }}" 
                    data-wa="{{ $uep->no_wa ?? '' }}" 
                    data-kategori="{{ $uep->kategori_produk ?? '' }}">
                {{ $uep->nama_usaha }} - {{ $uep->penerimaManfaat->nama_lengkap ?? 'Tanpa Pemilik' }}
            </option>
        @endforeach
    </select>
</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Nama Produk *</label>
                <input type="text" name="nama_produk" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

           <div class="space-y-2">
    <label class="text-xs font-bold text-gray-500 uppercase">Kategori *</label>
    <input type="text" name="kategori" id="kategori_input" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
</div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Harga Jual *</label>
                <input type="number" name="harga_jual" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Stok *</label>
                <input type="number" name="stok" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>

            <div class="space-y-2 md:col-span-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Deskripsi Produk</label>
                <textarea name="deskripsi_produk" rows="3" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

           <div class="space-y-2">
    <label class="text-xs font-bold text-gray-500 uppercase">WhatsApp Sales</label>
    <input type="text" name="whatsapp_sales" id="wa_input" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
</div>
            <!-- Status Publikasi -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Status Publikasi *</label>
                <select name="status_publikasi" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white" required>
                    <option value="Ditampilkan">Ditampilkan</option>
                    <option value="Draft">Draft</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Foto Produk</label>
                <input type="file" name="foto_produk" class="w-full p-3 border border-gray-200 rounded-xl file:bg-gray-100 file:border-none file:px-3 file:py-1 file:rounded-lg">
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('produk.index') }}" class="px-6 py-3 rounded-xl text-gray-600 font-semibold hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-lg shadow-blue-200">Simpan Produk</button>
        </div>
    </form>
</div>
<script>
document.getElementById('uep_select').addEventListener('change', function() {
    // Ambil option yang terpilih
    let selectedOption = this.options[this.selectedIndex];
    
    // Ambil data dari atribut data-*
    let wa = selectedOption.getAttribute('data-wa');
    let kategori = selectedOption.getAttribute('data-kategori');
    
    // Isi ke input
    document.getElementById('wa_input').value = wa;
    document.getElementById('kategori_input').value = kategori;
});
</script>
@endsection