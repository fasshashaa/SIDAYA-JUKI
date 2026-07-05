@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ================= HEADER ================= --}}
    <div class="mb-8">
        <br>
        <a href="{{ route('produk.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Katalog
        </a>
        {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Produk</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi produk <span class="font-semibold text-gray-700">{{ $produk->nama_produk }}</span>.</p>
    </div>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 🔒 TAMBAHAN: ringkasan semua pesan error validasi.
             Sebelumnya form ini tidak menampilkan @error/errors sama sekali,
             jadi kalau validasi gagal (mis. foto ditolak karena ukuran,
             dimensi, tipe file, atau kasus antivirus/file rusak) halaman
             cuma terlihat "reload diam-diam" tanpa penjelasan ke pengguna. --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
                <p class="text-sm font-bold text-red-700 mb-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Terjadi kesalahan saat menyimpan:
                </p>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ================= SECTION: MITRA UEP ================= --}}
 <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900">Pemilik Produk</h3>
            <p class="text-xs text-gray-400">Pilih mitra UEP atau kelompok KUBE sebagai pemilik</p>
        </div>
    </div>

    <div class="space-y-2">
        <label class="text-xs font-bold text-gray-500 uppercase">Pilih Pemilik Produk <span class="text-rose-500">*</span></label>

        <select name="pemilik_id" id="pemilik_select" class="w-full p-3 border {{ $errors->has('pemilik_id') ? 'border-red-400' : 'border-gray-200' }} rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
            <option value="" disabled>-- Pilih UEP atau KUBE --</option>

            <optgroup label="Daftar UEP">
                @foreach($ueps as $uep)
                    <option value="uep_{{ $uep->id }}" {{ (old('pemilik_id', 'uep_' . $produk->uep_id) == 'uep_' . $uep->id) ? 'selected' : '' }}>
                        [UEP] {{ $uep->nama_usaha }} - {{ $uep->penerimaManfaat->nama_lengkap ?? 'Tanpa Pemilik' }}
                    </option>
                @endforeach
            </optgroup>

            <optgroup label="Daftar KUBE">
                @foreach($kubes as $kube)
                    <option value="kube_{{ $kube->id }}" {{ (old('pemilik_id', 'kube_' . $produk->kube_id) == 'kube_' . $kube->id) ? 'selected' : '' }}>
                        [KUBE] {{ $kube->nama_kelompok_kube }} - Ketua: {{ $kube->ketua->nama_lengkap ?? 'Tanpa Ketua' }}
                    </option>
                @endforeach
            </optgroup>
        </select>
        @error('pemilik_id')
            <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

        {{-- ================= SECTION: INFORMASI PRODUK ================= --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Informasi Produk</h3>
                    <p class="text-xs text-gray-400">Nama, kategori, harga, stok, dan status publikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Nama Produk <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="w-full p-3 border {{ $errors->has('nama_produk') ? 'border-red-400' : 'border-gray-200' }} rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                    @error('nama_produk')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="kategori" value="{{ old('kategori', $produk->kategori) }}" class="w-full p-3 border {{ $errors->has('kategori') ? 'border-red-400' : 'border-gray-200' }} rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                    @error('kategori')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Harga Jual</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" class="w-full p-3 pl-10 border {{ $errors->has('harga_jual') ? 'border-red-400' : 'border-gray-200' }} rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="0">
                    </div>
                    @error('harga_jual')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="w-full p-3 border {{ $errors->has('stok') ? 'border-red-400' : 'border-gray-200' }} rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="0">
                    @error('stok')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Status Publikasi</label>
                    <select name="status_publikasi" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <option value="Ditampilkan" {{ old('status_publikasi', $produk->status_publikasi) == 'Ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                        <option value="Draft" {{ old('status_publikasi', $produk->status_publikasi) == 'Draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ================= SECTION: FOTO PRODUK (UPLOAD CANGGIH) ================= --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Foto Produk</h3>
                    <p class="text-xs text-gray-400">Klik atau seret foto baru untuk mengganti foto saat ini</p>
                </div>
            </div>

            <div id="dropzone"
                 class="relative rounded-2xl border-2 {{ $errors->has('foto_produk') ? 'border-red-300 bg-red-50/40' : 'border-dashed border-gray-200 bg-gray-50/50' }} hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-200 cursor-pointer overflow-hidden"
                 onclick="document.getElementById('foto_input').click()">

                <input type="file" name="foto_produk" id="foto_input" accept="image/*" class="hidden">

                {{-- State: belum ada foto sama sekali --}}
                <div id="dropzone_placeholder" class="{{ $produk->foto_produk ? 'hidden' : '' }} flex flex-col items-center justify-center gap-3 py-14 px-6 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Klik untuk unggah, atau seret foto ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">PNG atau JPG &middot; maks. 2MB &middot; maks. 4000&times;4000px</p>
                    </div>
                </div>

                {{-- State: preview foto (foto lama ATAU foto baru yang baru dipilih) --}}
                <div id="dropzone_preview" class="{{ $produk->foto_produk ? '' : 'hidden' }} relative">
                    <img id="preview_img" src="{{ $produk->foto_url ?? '' }}" class="w-full max-h-80 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-2">
                        <span id="preview_filename" class="text-xs font-medium text-white truncate bg-black/30 px-2.5 py-1 rounded-lg">
                            {{ $produk->foto_produk ? 'Foto saat ini' : '' }}
                        </span>
                        <button type="button" onclick="event.stopPropagation(); triggerReplace()" class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Ganti Foto
                        </button>
                    </div>
                </div>
            </div>

            {{-- 🔒 TAMBAHAN: pesan error khusus foto_produk, tepat di bawah kotak upload.
                 Ini yang sebelumnya hilang total dari form, padahal backend
                 sudah mengirim pesan error MIME/dimensi/ukuran/antivirus. --}}
            @error('foto_produk')
                <p class="text-red-600 text-xs font-semibold mt-3 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- ================= ACTIONS ================= --}}
        <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Perbarui Data
                    </button>
                    <a href="{{ route('produk.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    {{-- <span class="ml-auto text-xs text-gray-400 hidden sm:flex items-center gap-1.5">
                        <span class="text-rose-500">*</span> wajib diisi
                    </span> --}}
                </div>
            </div>
    </form>
</div>

<script>
(function () {
    const dropzone = document.getElementById('dropzone');
    const fotoInput = document.getElementById('foto_input');
    const placeholder = document.getElementById('dropzone_placeholder');
    const preview = document.getElementById('dropzone_preview');
    const previewImg = document.getElementById('preview_img');
    const previewFilename = document.getElementById('preview_filename');

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewFilename.textContent = file.name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    fotoInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            showPreview(this.files[0]);
        }
    });

    ['dragenter', 'dragover'].forEach(evt => {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('border-blue-400', 'bg-blue-50/30');
        });
    });

    ['dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('border-blue-400', 'bg-blue-50/30');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        const file = e.dataTransfer.files[0];
        if (file) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fotoInput.files = dataTransfer.files;
            showPreview(file);
        }
    });

    window.triggerReplace = function () {
        fotoInput.click();
    };
})();
</script>
@endsection