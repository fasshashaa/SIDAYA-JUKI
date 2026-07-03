@extends('layouts.app')
@section('content')

 <div class="mb-8">
        <br>
           @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
        <a href="{{ route('kube.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        @else
         <a href="{{ route('kube.status') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        @endif
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Data Kelompok Usaha Bersama</h1>
        <p class="text-sm text-gray-500 mt-1">Tambah Data Kelompok Usaha Bersama Kabupaten Cilacap.</p>
    </div>


<div class="max-w-4xl mx-auto"
    x-data="{ 
        pms: {{ $pms->toJson() }},
        selectedKetua: null,
        kecamatan: '{{ old('kecamatan_kube', '') }}',
        desaTerpilih: '{{ old('desa_kube', '') }}',
        listWilayah: {
            'Cilacap Tengah': ['Donan', 'Gunungsimping', 'Kutawaru', 'Lomanis', 'Sidanegara'],
            'Cilacap Utara': ['Bangunkerto', 'Kebonmanis', 'Mertasinga', 'Trisula', 'Gumilir'],
            'Cilacap Selatan': ['Cilacap', 'Sidakaya', 'Tambakreja', 'Tegalkamulyan', 'Sentolokawat'],
            'Adipala': ['Adipala', 'Bunton', 'Glempangpasir', 'Gombolharjo', 'Karanganyar', 'Karangbenda', 'Karangreja', 'Pedasong', 'Penggalang', 'Pluneng', 'Wlahar'],
            'Majenang': ['Bener', 'Boja', 'Cibeunying', 'Cilopadang', 'Jenang', 'Mulyadadi', 'Mulyasari', 'Padangjaya', 'Pahang', 'Sindangsari', 'Ujungbarang'],
            'Cimanggu': ['Bantarpanjang', 'Cibalung', 'Cilempuyang', 'Cimanggu', 'Cisumur', 'Karangreja', 'Mandala', 'Negarajati', 'Pesahangan', 'Rejodadi'],
            'Bantarsari': ['Bantarsari', 'Binangun', 'Cikedondong', 'Kamulyan', 'Kedungwringin', 'Rawajaya'],
            'Kedungreja': ['Bangunreja', 'Bojongsari', 'Ciklapa', 'Jatisari', 'Kaliwuri', 'Kedungreja', 'Rebamulya', 'Sidanegara', 'Tambakreja'],
            'Kesugihan': ['Bulupayung', 'Ciwuni', 'Dengkeng', 'Karangjengkol', 'Karangkandri', 'Kesugihan', 'Kuris', 'Menganti', 'Slarang'],
            'Binangun': ['Alangamba', 'Bangkal', 'Binangun', 'Karangnangka', 'Kepudang', 'Pasuruhan', 'Pekuncen', 'Sidayu', 'Widarapayung'],
            'Nusawungu': ['Banjareja', 'Banjarwaru', 'Danasri', 'Jedug', 'Karangpakis', 'Karangsembung', 'Kedungbenda', 'Nusawungu', 'Purwosari'],
            'Kroya': ['Bajing', 'Buntu', 'Karangmangu', 'Kroya', 'Merwung', 'Mujur', 'Pucungkidul', 'Pekuncen', 'Sikampuh'],
            'Maos': ['Glempang', 'Karangkemiri', 'Klapagada', 'Maos Kidul', 'Maos Lor', 'Mergangsan', 'Panisian', 'Punthuk'],
            'Jeruklegi': ['Brebeg', 'Cilibang', 'Citepus', 'Jambusari', 'Jeruklegi Kulon', 'Jeruklegi Wetan', 'Prapagan', 'Sumingkir'],
            'Kawunganten': ['Babakan', 'Bo Bo', 'Boong', 'Glempang', 'Kalijeruk', 'Kawunganten', 'Mentasan', 'Sarwadadi', 'Ujungmanik'],
            'Gandrungmangu': ['Bantarmangu', 'Cisumur', 'Gandrungmangu', 'Gandrungmanis', 'Karanganyar', 'Kertajaya', 'Layansari', 'Muktisari'],
            'Sidareja': ['Gunungreja', 'Kunci', 'Margasari', 'Penolih', 'Sidamulya', 'Sidareja', 'Sudagaran', 'Tinggarjaya'],
            'Karangpucung': ['Bengbulang', 'Cidadap', 'Cipasung', 'Karangpucung', 'Tayem', 'Pangawaren', 'Surusunda'],
            'Wanareja': ['Adimulya', 'Bantar', 'Cigintung', 'Cilongkrang', 'Jatisari', 'Majingklak', 'Malabar', 'Palugon', 'Wanareja'],
            'Dayeuhluhur': ['Bingkeng', 'Cigerendeng', 'Cilumping', 'Dayeuhluhur', 'Hanum', 'Kutaagung', 'Matenggeng', 'Samping'],
            'Sampang': ['Karangtengah', 'Ketanggung', 'Nusajati', 'Pakuwon', 'Sampang', 'Sidasari'],
            'Cipari': ['Caruy', 'Cipari', 'Cisuru', 'Karangreja', 'Kutasari', 'Mulyadadi', 'Pegadingan', 'Serang'],
            'Patimuan': ['Bulupayung', 'Cinyawang', 'Patimuan', 'Purwodadi', 'Rawaapu', 'Sidamukti'],
            'Kampung Laut': ['Klaces', 'Panikel', 'Ujungalor', 'Ujunggagak']
        },
        updateKetua(id) {
            this.selectedKetua = this.pms.find(pm => pm.id == id) || {};
        },
        get desas() {
            return this.listWilayah[this.kecamatan] || [];
        }
    }">

    <form action="{{ route('kube.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- ============ SECTION 1: DATA KELOMPOK ============ --}}
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                <h4 class="text-sm font-bold text-slate-800">Data Kelompok</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kelompok KUBE *</label>
                    <input type="text"  placeholder="Masukkan Nama Kelompok Usaha Bersama" name="nama_kelompok_kube" value="{{ old('nama_kelompok_kube') }}" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" required>
                    @error('nama_kelompok_kube') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                    {{-- ===== ADMIN / SUPER ADMIN: pilih ketua dari dropdown PM yang belum berkelompok ===== --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Ketua KUBE *</label>
                        <select name="ketua_penerima_manfaat_id" @change="updateKetua($event.target.value)" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" required>
                            <option value="">-- Pilih Ketua --</option>
                            @foreach($pms as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('ketua_penerima_manfaat_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                @else
                    {{-- ===== USER: otomatis jadi ketua dari profil PM miliknya sendiri ===== --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ketua Kelompok (Anda)</label>
                        <input type="text" value="{{ $myProfile->nama_lengkap ?? 'Data profil tidak ditemukan' }}" readonly
                               class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">

                        @if(!$myProfile)
                            <div class="mt-3 flex items-start gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">
                                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                <p class="text-sm text-amber-700">Data profil Penerima Manfaat kamu belum ditemukan. Hubungi admin sebelum mengajukan KUBE.</p>
                            </div>
                        @elseif($myProfile->kube_id)
                            <div class="mt-3 flex items-start gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">
                                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                <p class="text-sm text-amber-700">Kamu sudah tergabung dalam kelompok KUBE lain. Tidak bisa mengajukan kelompok baru.</p>
                            </div>
                        @endif

                        {{-- Dikirim langsung dari server, bukan dari input yang bisa diedit user di browser --}}
                        <input type="hidden" name="ketua_penerima_manfaat_id" value="{{ $myProfile->id ?? '' }}">
                    </div>
                @endif
            </div>
        </div>

        {{-- ============ SECTION 2: PROFIL USAHA & TEKNIS ============ --}}
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                <h4 class="text-sm font-bold text-slate-800">Profil Usaha &amp; Teknis</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Usaha *</label>
                    <input type="text" placeholder="Masukkan Jenis Usaha" name="jenis_usaha_kube" value="{{ old('jenis_usaha_kube') }}" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" required>
                    @error('jenis_usaha_kube') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telp KUBE</label>
                    <input type="number" maxlength="13" placeholder="Masukkan Nomor Telepon" name="no_telp_kube" value="{{ old('no_telp_kube') }}" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan *</label>
                    <select name="kecamatan_kube"
                            x-model="kecamatan"
                            @change="desaTerpilih = ''"
                            required
                            class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        <option value="">-- Pilih Kecamatan --</option>
                        <option value="Kedungreja">Kedungreja</option>
                        <option value="Kesugihan">Kesugihan</option>
                        <option value="Adipala">Adipala</option>
                        <option value="Binangun">Binangun</option>
                        <option value="Nusawungu">Nusawungu</option>
                        <option value="Kroya">Kroya</option>
                        <option value="Maos">Maos</option>
                        <option value="Jeruklegi">Jeruklegi</option>
                        <option value="Kawunganten">Kawunganten</option>
                        <option value="Gandrungmangu">Gandrungmangu</option>
                        <option value="Sidareja">Sidareja</option>
                        <option value="Karangpucung">Karangpucung</option>
                        <option value="Cimanggu">Cimanggu</option>
                        <option value="Majenang">Majenang</option>
                        <option value="Wanareja">Wanareja</option>
                        <option value="Dayeuhluhur">Dayeuhluhur</option>
                        <option value="Sampang">Sampang</option>
                        <option value="Cipari">Cipari</option>
                        <option value="Patimuan">Patimuan</option>
                        <option value="Bantarsari">Bantarsari</option>
                        <option value="Cilacap Selatan">Cilacap Selatan</option>
                        <option value="Cilacap Tengah">Cilacap Tengah</option>
                        <option value="Cilacap Utara">Cilacap Utara</option>
                        <option value="Kampung Laut">Kampung Laut</option>
                    </select>
                    @error('kecamatan_kube') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Desa / Kelurahan *</label>
                    <select name="desa_kube"
                            x-model="desaTerpilih"
                            required
                            :disabled="desas.length === 0"
                            class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all disabled:opacity-60 disabled:cursor-not-allowed">

                        <template x-if="desas.length === 0">
                            <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
                        </template>

                        <template x-if="desas.length > 0">
                            <option value="">-- Pilih Desa --</option>
                        </template>

                        <template x-for="(namaDesa, index) in desas" :key="index">
                            <option :value="namaDesa"
                                    x-text="namaDesa"></option>
                        </template>
                    </select>
                    @error('desa_kube') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap *</label>
                    <textarea name="alamat_lengkap_kube" rows="3" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" placeholder="Nama jalan, RT/RW, Dusun tempat kelompok berada" required>{{ old('alamat_lengkap_kube') }}</textarea>
                    @error('alamat_lengkap_kube') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- ============ SECTION 3: INFORMASI PENDUKUNG ============ --}}
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">3</span>
                <h4 class="text-sm font-bold text-slate-800">Informasi Pendukung</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Anggota *</label>
                    <input type="number" name="jumlah_anggota" value="{{ old('jumlah_anggota') }}" min="1" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" required placeholder="Masukkan jumlah anggota">
                    @error('jumlah_anggota') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                 @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Realisasi *</label>
                    <input type="number" name="tahun_realisasi" value="{{ old('tahun_realisasi', date('Y')) }}" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Sumber Anggaran *</label>
                    <select name="sumber_anggaran" class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" required>
                        <option value="APBD" {{ old('sumber_anggaran') == 'APBD' ? 'selected' : '' }}>APBD</option>
                        <option value="APBN" {{ old('sumber_anggaran') == 'APBN' ? 'selected' : '' }}>APBN</option>
                        <option value="Mandiri" {{ old('sumber_anggaran') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                    </select>
                </div>
@endif
                <input type="hidden" name="status_verifikasi" value="pending">
            </div>
        </div>

        {{-- ============ ACTIONS ============ --}}
         <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Baru
                    </button>
                       @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <a href="{{ route('kube.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    @else 
                      <a href="{{ route('kube.status') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    @endif
                </div>
            </div>
    </form>
</div>
@endsection