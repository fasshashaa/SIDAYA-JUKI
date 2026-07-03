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
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Produk Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Isikan detail informasi produk UMKM dengan lengkap.</p>
    </div>

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

      {{-- ================= SECTION: MITRA UEP ================= --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900">Pemilik Produk</h3>
            <p class="text-xs text-gray-400">
                @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                    Pilih mitra UEP atau kelompok KUBE
                @else
                    Pilih dari usaha yang telah Anda daftarkan
                @endif
            </p>
        </div>
    </div>

    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
        {{-- ===== ADMIN / SUPER ADMIN: pilih bebas dari semua UEP/KUBE ===== --}}
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-500 uppercase">Pilih Pemilik Produk <span class="text-rose-500">*</span></label>
            <select name="pemilik_id" id="pemilik_select" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                <option value="" disabled selected>-- Pilih UEP atau KUBE --</option>
                <optgroup label="Daftar UEP">
                    @foreach($ueps as $uep)
                        <option value="uep_{{ $uep->id }}"
                                data-wa="{{ $uep->no_wa ?? '' }}"
                                data-kategori="{{ $uep->kategori_produk ?? '' }}"
                                data-status="disetujui">
                            [UEP] {{ $uep->nama_usaha }} - {{ $uep->penerimaManfaat->nama_lengkap ?? 'Tanpa Pemilik' }}
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Daftar KUBE">
                    @foreach($kubes as $kube)
                        <option value="kube_{{ $kube->id }}"
                                data-wa="{{ $kube->no_telp_kube ?? '' }}"
                                data-kategori="Kelompok Usaha"
                                data-status="disetujui">
                            [KUBE] {{ $kube->nama_kelompok_kube }} - Ketua: {{ $kube->ketua->nama_lengkap ?? 'Tanpa Ketua' }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
        </div>

  @else
        {{-- ===== USER: usaha miliknya sendiri, status "ditolak" disembunyikan ===== --}}
        @php
            $statusLabel = [
                'pending'   => 'Pending',
                'disetujui' => 'Disetujui',
            ];

            $myBusinesses = $myUeps->map(fn($u) => (object)[
                    'value'    => 'uep_' . $u->id,
                    'label'    => '[UEP] ' . $u->nama_usaha,
                    'wa'       => $u->no_wa,
                    'kategori' => $u->kategori_produk,
                    'status'   => $u->status_verifikasi,
                ])
                ->concat($myKubes->map(fn($k) => (object)[
                    'value'    => 'kube_' . $k->id,
                    'label'    => '[KUBE] ' . $k->nama_kelompok_kube,
                    'wa'       => $k->no_telp_kube,
                    'kategori' => 'Kelompok Usaha',
                    'status'   => $k->status_verifikasi,
                ]));
        @endphp

        @if($myBusinesses->isEmpty())
            <div class="flex items-start gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                <p class="text-sm text-amber-700">Anda belum punya usaha yang bisa dipakai untuk mendaftarkan produk. Ajukan UEP/KUBE baru, atau perbaiki pengajuan yang sebelumnya ditolak.</p>
            </div>
        @else
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Pilih Usaha Anda <span class="text-rose-500">*</span></label>
                <select name="pemilik_id" id="pemilik_select" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                    <option value="" disabled selected>-- Pilih Usaha Anda --</option>
                    @foreach($myBusinesses as $b)
                        <option value="{{ $b->value }}" data-wa="{{ $b->wa }}" data-kategori="{{ $b->kategori }}" data-status="{{ $b->status }}">
                            {{ $b->label }} ({{ $statusLabel[$b->status] ?? $b->status }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="status_warning" class="hidden mt-3 flex items-start gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                <p class="text-sm text-amber-700">Usaha ini masih menunggu verifikasi admin. Anda belum bisa menyimpan produk sampai statusnya <strong>disetujui</strong>.</p>
            </div>
        @endif
    @endif
</div>
        {{-- ================= SECTION: INFORMASI PRODUK ================= --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Informasi Produk</h3>
                    <p class="text-xs text-gray-400">Nama, kategori, harga, dan ketersediaan stok</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Nama Produk <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_produk" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: Keripik Singkong Original" required>
                </div>

                <div class="space-y-2">
    <label class="text-xs font-bold text-gray-500 uppercase">Kategori <span class="text-rose-500">*</span></label>
    <input type="text" name="kategori" id="kategori_input" readonly
           class="w-full p-3 border border-gray-200 rounded-xl bg-gray-100 text-gray-600 cursor-not-allowed outline-none transition-all"
           placeholder="Terisi otomatis setelah memilih pemilik produk" required>
</div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Harga Jual <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                        <input type="number" name="harga_jual" class="w-full p-3 pl-10 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="0" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Stok <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="0" required>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Deskripsi Produk</label>
                    <textarea name="deskripsi_produk" rows="3" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Ceritakan keunggulan produk ini..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">WhatsApp Sales</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                        </span>
                        <input type="text" name="whatsapp_sales" id="wa_input" readonly class="w-full p-3 pl-10 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: 08123456789">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Status Publikasi <span class="text-rose-500">*</span></label>
                    <select name="status_publikasi" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                        <option value="Ditampilkan">Ditampilkan</option>
                        <option value="Draft">Draft</option>
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
                    <p class="text-xs text-gray-400">Unggah foto utama yang akan tampil di katalog</p>
                </div>
            </div>

            <div id="dropzone"
                 class="relative rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50/50 hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-200 cursor-pointer overflow-hidden"
                 onclick="document.getElementById('foto_input').click()">

                <input type="file" name="foto_produk" id="foto_input" accept="image/*" class="hidden">

                {{-- State: belum ada gambar --}}
                <div id="dropzone_placeholder" class="flex flex-col items-center justify-center gap-3 py-14 px-6 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Klik untuk unggah, atau seret foto ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, atau WEBP &middot; maks. 2MB &middot; rasio 1:1 direkomendasikan</p>
                    </div>
                </div>

                {{-- State: preview gambar terpilih --}}
                <div id="dropzone_preview" class="hidden relative">
                    <img id="preview_img" src="" class="w-full max-h-80 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-2">
                        <span id="preview_filename" class="text-xs font-medium text-white truncate bg-black/30 px-2.5 py-1 rounded-lg"></span>
                        <button type="button" onclick="event.stopPropagation(); resetFotoInput()" class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= ACTIONS ================= --}}
       {{-- ================= ACTIONS ================= --}}
<div class="sticky bottom-4 z-10">
    <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
        <button type="submit" id="submit_btn" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Baru
        </button>
        <a href="{{ route('produk.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
            Batal
        </a>
    </div>
</div>
<script>
function isiOtomatis(wa, kategori, isKube) {
    const inputKategori = document.getElementById('kategori_input');
    const inputWa = document.getElementById('wa_input');

    if (inputKategori) inputKategori.value = kategori || '';
    if (inputWa) inputWa.value = wa || '';

    if (inputKategori) {
        if (isKube) {
            inputKategori.readOnly = true;
            inputKategori.classList.add('bg-gray-100');
        } else {
            inputKategori.readOnly = false;
            inputKategori.classList.remove('bg-gray-100');
        }
    }
}

function tampilkanWarningStatus(status) {
    const warningBox = document.getElementById('status_warning');
    const submitBtn = document.getElementById('submit_btn');

    const isPending = status === 'pending';

    if (warningBox) {
        warningBox.classList.toggle('hidden', !isPending);
    }
    if (submitBtn) {
        submitBtn.disabled = isPending;
    }
}

const pemilikSelect = document.getElementById('pemilik_select');
if (pemilikSelect) {
    // Kunci submit di awal selama belum ada pilihan valid dipilih
    const submitBtnInit = document.getElementById('submit_btn');
    if (submitBtnInit) submitBtnInit.disabled = true;

    pemilikSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        isiOtomatis(
            selectedOption.getAttribute('data-wa'),
            selectedOption.getAttribute('data-kategori'),
            selectedOption.value.startsWith('kube_')
        );
        tampilkanWarningStatus(selectedOption.getAttribute('data-status'));
    });
}

// ==== Upload foto produk: preview + drag & drop ====
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

    window.resetFotoInput = function () {
        fotoInput.value = '';
        previewImg.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    };
})();
</script>
@endsection