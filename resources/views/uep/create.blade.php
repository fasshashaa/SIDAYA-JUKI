@extends('layouts.app')
@section('content')

<div class="mb-8">
        <div class="mb-8">
        <br>
          @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        @else 
          <a href="{{ route('uep.status') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        @endif
        {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
       <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Tambah Data UEP</h1>
    <p class="text-sm text-slate-500 mt-1">Lengkapi identitas pemilik, profil usaha, dan sumber pembiayaan.</p>
  </div>


<div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 p-6 md:p-8 max-w-4xl"
     x-data="{ 
        kecamatan: '{{ old('kecamatan', '') }}',
        desaTerpilih: '{{ old('desa', '') }}',
        selectedPm: {},
        pmList: {{ $penerimaManfaats->toJson() }},
              listWilayah: {
    'Cilacap Tengah': ['Donan', 'Gunungsimping', 'Kutawaru', 'Lomanis', 'Sidanegara'],
    'Cilacap Utara': ['Tritih Kulon', 'Kebonmanis', 'Mertasinga', 'Gumilir', 'Karangtalun'],
    'Cilacap Selatan': ['Cilacap', 'Sidakaya', 'Tambakreja', 'Tegalkamulyan', 'Tegalreja'],
    'Adipala': ['Adipala', 'Adiraja', 'Adireja Kulon', 'Adireja Wetan', 'Doplang', 'Glempangpasir', 'Gombolharjo', 'Kalikudi', 'Bunton', 'Karanganyar', 'Karangbenda', 'Penggalang', 'Karangsari', 'Pedasong', 'Welahan Wetan', 'Wlahar'],
    'Majenang': ['Bener', 'Boja', 'Cibeunying', 'Pandangsari', 'Cilopadang', 'Jenang', 'Mulyadadi', 'Mulyasari', 'Padangjaya', 'Pahonjean', 'Pengadegan', 'Sadabumi', 'Sadahayu', 'Salebu', 'Sepatnunggal', 'Sindangsari', 'Ujungbarang'],
    'Cimanggu': ['Bantarpanjang', 'Bantarmangu', 'Cibalung', 'Cijati', 'Cilempuyang', 'Cimanggu', 'Cisalak', 'Karangreja', 'Karangsari', 'Kutabumi', 'Mandala', 'Negarajati', 'Panimbang', 'Pesahangan', 'Rejodadi'],
    'Bantarsari': ['Bantarsari', 'Binangun', 'Bulaksari', 'Cikedondong', 'Citembong', 'Kamulyan', 'Kedungwadas', 'Rawajaya'],
    'Cipari': ['Caruy', 'Cipari', 'Cisuru', 'Karangreja', 'Kutasari', 'Mekarsari', 'Mulyadadi', 'Pegadingan', 'Segaralangu', 'Serang', 'Sidasari'],
    'Kedungreja': ['Bangunreja', 'Bojongsari', 'Bumireja', 'Ciklapa', 'Jatisari', 'Kaliwungu', 'Kedungreja', 'Rejamulya', 'Sidanegara', 'Tambakreja', 'Tambaksari'],
    'Kesugihan': ['Bulupayung', 'Ciwuni', 'Dondong', 'Jangrana', 'Kalisabuk', 'Karangjengkol', 'Karangkandri', 'Keleng', 'Kesugihan', 'Kesugihan Kidul', 'Kuripan', 'Kuripan Kidul', 'Menganti', 'Pesanggrahan', 'Planjan', 'Slarang'],
    'Binangun': ['Alangamba', 'Bangkal', 'Binangun', 'Jati', 'Jepara Kulon', 'Jepara Wetan', 'Karangnangka', 'Kemojing', 'Kepudang', 'Pagubugan', 'Pagubugan Kulon', 'Pasuruhan', 'Pesawahan', 'Sidaurip', 'Widarapayung Kulon', 'Sidayu', 'Widarapayung Wetan'],
    'Nusawungu': ['Banjareja', 'Banjarsari', 'Banjarwaru', 'Danasri', 'Danasri Kidul', 'Danasri Lor', 'Jetis', 'Karangpakis', 'Karangputat', 'Karangsembung', 'Karangtawang', 'Kedungbenda', 'Klumprit', 'Nusawangkal', 'Nusawungu', 'Purwadadi', 'Sikanco'],
    'Kroya': ['Ayamalas', 'Bajing', 'Bajing Kulon', 'Buntu', 'Gentasari', 'Karangmangu', 'Karangturi', 'Kedawung', 'Kroya', 'Mergawati', 'Mujur', 'Mujur Lor', 'Pekuncen', 'Pesanggrahan', 'Pucung Kidul', 'Pucung Lor', 'Sikampuh'],
    'Maos': ['Glempang', 'Kalijaran', 'Karangkemiri', 'Karangreja', 'Karangrena', 'Klapagada', 'Maos Kidul', 'Maos Lor', 'Mernek', 'Penisihan'],
    'Jeruklegi': ['Brebeg', 'Cilibang', 'Citepus', 'Jambusari', 'Jeruklegi Kulon', 'Jeruklegi Wetan', 'Karangkemiri', 'Mendala', 'Prapagan', 'Sawangan', 'Sumingkir', 'Tritih Lor', 'Tritih Wetan'],
    'Kawunganten': ['Babakan', 'Bojong', 'Bringkeng', 'Grugu', 'Kalijeruk', 'Kawunganten', 'Kawunganten Lor', 'Kubangkangkung', 'Mentasan', 'Sarwadadi', 'Sidaurip', 'Ujungmanik'],
    'Gandrungmangu': ['Bulusari', 'Cinangsi', 'Cisumur', 'Gandrungmangu', 'Gandrungmanis', 'Gintungreja', 'Karanganyar', 'Karanggintung', 'Kertajaya', 'Layansari', 'Muktisari', 'Rungkang', 'Sidaurip', 'Wringinharjo'],
    'Sidareja': ['Gunungreja', 'Karanggedang', 'Kunci', 'Margasari', 'Penyarang', 'Sidamulya', 'Sidareja', 'Sudagaran', 'Tegalsari', 'Tinggarjaya'],
    'Karangpucung': ['Babakan', 'Bengbulang', 'Cidadap', 'Ciporos', 'Ciruyung', 'Gunungtelu', 'Karangpucung', 'Pamulihan', 'Pengawaren', 'Sidamulya', 'Sindangbarang', 'Surusunda', 'Tayem', 'Tayemtimur'],
    'Wanareja': ['Adimulya', 'Bantar', 'Cigintung', 'Cilongkrang', 'Jambu', 'Limbangan', 'Madura', 'Madusari', 'Majingklak', 'Malabar', 'Palugon', 'Purwasari', 'Sidamulya', 'Tambaksari', 'Tarisi','Wanareja'],
    'Dayeuhluhur': ['Bingkeng', 'Bolang', 'Cijeruk', 'Cilumping', 'Ciwalen', 'Datar', 'Dayeuhluhur', 'Hanum', 'Kutaagung', 'Matenggeng', 'Panulisan', 'Panulisan Barat', 'Panulisan Timur', 'Sumpinghayu'],
    'Sampang': ['Brani', 'Karangasem', 'Karangjati', 'Karangtengah', 'Ketanggung', 'Nusajati', 'Paberasan', 'Paketingan', 'Sampang', 'Sidasari'],
    'Patimuan': ['Bulupayung', 'Cimrutu', 'Cinyawang', 'Patimuan', 'Purwodadi', 'Rawaapu', 'Sidamukti'],
    'Kampung Laut': ['Klaces', 'Panikel', 'Ujungalang', 'Ujunggagak']
},
        get desas() { return this.listWilayah[this.kecamatan] || []; },
       updateFields(id) { 
        let data = this.pmList.find(pm => pm.id == id);
        this.selectedPm = data ? data : {}; // Jika tidak ditemukan, set ke objek kosong
    }   }">

    <form action="{{ route('uep.store') }}" method="POST" class="space-y-8">
        @csrf
        <input type="hidden" name="status_verifikasi" value="pending">
        <input type="hidden" name="status_usaha" value="Aktif">

    
{{-- ============ SECTION I ============ --}}
<div>
    <div class="flex items-center gap-3 mb-5">
        <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
        <h4 class="text-sm font-bold text-slate-800">Identitas Pemilik Usaha</h4>
    </div>

    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
        {{-- ===== ADMIN / SUPER ADMIN: pilih dari dropdown, field lain auto-fill via Alpine ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Penerima Manfaat *</label>
                <select name="penerima_manfaat_id" @change="updateFields($event.target.value)" required
                        class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    <option value="">-- Pilih Nama Penerima --</option>
                    @foreach($penerimaManfaats as $pm)
                        <option value="{{ $pm->id }}">{{ $pm->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" :value="selectedPm.nama_lengkap || ''" readonly
                       placeholder="Terisi otomatis setelah memilih penerima"
                       class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 placeholder:text-slate-400 cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp</label>
                <input type="text" :value="selectedPm.no_wa || ''" readonly
                       placeholder="Terisi otomatis setelah memilih penerima"
                       class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 placeholder:text-slate-400 cursor-not-allowed">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:col-span-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ibu Kandung</label>
                    <input type="text" :value="selectedPm.nama_ibu_kandung || ''" readonly
                           placeholder="Terisi otomatis setelah memilih penerima"
                           class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIK</label>
                    <input type="text" :value="selectedPm.nik || ''" readonly
                           placeholder="Terisi otomatis setelah memilih penerima"
                           class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor KK</label>
                    <input type="text" :value="selectedPm.no_kk || ''" readonly
                           placeholder="Terisi otomatis setelah memilih penerima"
                           class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
                </div>
            </div>
        </div>

        {{-- Hidden input dikirim dari data Alpine hasil pilihan dropdown --}}
        <input type="hidden" name="nama_lengkap" :value="selectedPm.nama_lengkap || ''">
        <input type="hidden" name="no_wa" :value="selectedPm.no_wa || ''">
        <input type="hidden" name="nama_ibu_kandung" :value="selectedPm.nama_ibu_kandung || ''">
        <input type="hidden" name="nik" :value="selectedPm.nik || ''">
        <input type="hidden" name="no_kk" :value="selectedPm.no_kk || ''">

    @else
        {{-- ===== USER: data profil sendiri, tidak bisa memilih/mengubah ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Penerima Manfaat</label>
                <input type="text" value="{{ $myProfile->nama_lengkap ?? 'Data profil tidak ditemukan' }}" readonly
                       class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp</label>
                <input type="text" value="{{ $myProfile->no_wa ?? '-' }}" readonly
                       class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ibu Kandung</label>
                <input type="text" value="{{ $myProfile->nama_ibu_kandung ?? '-' }}" readonly
                       class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:col-span-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIK</label>
                    <input type="text" value="{{ $myProfile->nik ?? '-' }}" readonly
                           class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor KK</label>
                    <input type="text" value="{{ $myProfile->no_kk ?? '-' }}" readonly
                           class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-sm p-3 text-slate-500 cursor-not-allowed">
                </div>
            </div>

            @if(!$myProfile)
                <div class="md:col-span-2">
                    <div class="flex items-start gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <p class="text-sm text-amber-700">Data profil Penerima Manfaat kamu belum ditemukan. Hubungi admin sebelum mengajukan UEP.</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Hidden input diisi langsung dari server (bukan dari input yang bisa diedit user di browser) --}}
        <input type="hidden" name="penerima_manfaat_id" value="{{ $myProfile->id ?? '' }}">
        <input type="hidden" name="nama_lengkap" value="{{ $myProfile->nama_lengkap ?? '' }}">
        <input type="hidden" name="no_wa" value="{{ $myProfile->no_wa ?? '' }}">
        <input type="hidden" name="nama_ibu_kandung" value="{{ $myProfile->nama_ibu_kandung ?? '' }}">
        <input type="hidden" name="nik" value="{{ $myProfile->nik ?? '' }}">
        <input type="hidden" name="no_kk" value="{{ $myProfile->no_kk ?? '' }}">
    @endif
</div>
        {{-- ============ SECTION II ============ --}}
        <div class="pt-6 border-t border-slate-100">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                <h4 class="text-sm font-bold text-slate-800">Profil &amp; Legalisasi Usaha</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Usaha / Merk Dagang *</label>
                    <input type="text" name="nama_usaha" required class="w-full rounded-xl border-slate-200 bg-slate-50/60 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 text-sm p-3 transition-all" value="{{ old('nama_usaha') }}">
                    @error('nama_usaha') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Produk *</label>
                    <select name="kategori_produk" required class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kuliner / Makanan Olahan" {{ old('kategori_produk') == 'Kuliner / Makanan Olahan' ? 'selected' : '' }}>Kuliner / Makanan Olahan</option>
                        <option value="Kerajinan / Craft" {{ old('kategori_produk') == 'Kerajinan / Craft' ? 'selected' : '' }}>Kerajinan / Craft</option>
                        <option value="Fashion / Konveksi" {{ old('kategori_produk') == 'Fashion / Konveksi' ? 'selected' : '' }}>Fashion / Konveksi</option>
                        <option value="Pertanian / Peternakan" {{ old('kategori_produk') == 'Pertanian / Peternakan' ? 'selected' : '' }}>Pertanian / Peternakan</option>
                        <option value="Jasa / Service" {{ old('kategori_produk') == 'Jasa / Service' ? 'selected' : '' }}>Jasa / Service</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Perkembangan *</label>
                    <select name="status_perkembangan" required class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        <option value="rintisan" {{ old('status_perkembangan') == 'rintisan' ? 'selected' : '' }}>Rintisan</option>
                        <option value="berkembang" {{ old('status_perkembangan') == 'berkembang' ? 'selected' : '' }}>Berkembang</option>
                        <option value="mandiri" {{ old('status_perkembangan') == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan *</label>
                    <select name="kecamatan_usaha"
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
                    @error('kecamatan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Desa / Kelurahan *</label>
                    <select name="desa_kelurahan_usaha"
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
                    @error('desa') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Detail Usaha *</label>
                    <textarea name="alamat_lengkap" rows="3" required class="w-full rounded-xl border-slate-200 bg-slate-50/60 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 text-sm p-3 transition-all" placeholder="Nama jalan, RT/RW, Dusun tempat usaha beroperasi">{{ old('alamat_lengkap') }}</textarea>
                </div>
            </div>
        </div>
       {{-- ============ SECTION III (tampil untuk SEMUA role, karena wajib di controller) ============ --}}
           @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
<div class="pt-6 border-t border-slate-100">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">3</span>
        <h4 class="text-sm font-bold text-slate-800">Sumber Pembiayaan Realisasi</h4>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Realisasi Bantuan *</label>
            <select name="tahun_realisasi" required class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                @php
                    $tahunSekarang = date('Y');
                    $tahunMulai = 2020;
                @endphp
                @for ($tahun = $tahunSekarang; $tahun >= $tahunMulai; $tahun--)
                    <option value="{{ $tahun }}" {{ old('tahun_realisasi', $tahunSekarang) == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endfor
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Sumber Anggaran *</label>
            <select name="sumber_anggaran" required class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                <option value="">-- Pilih Sumber Anggaran --</option>
                <option value="APBN" {{ old('sumber_anggaran') == 'APBN' ? 'selected' : '' }}>APBN</option>
                <option value="APBD" {{ old('sumber_anggaran') == 'APBD' ? 'selected' : '' }}>APBD</option>
                <option value="CSR" {{ old('sumber_anggaran') == 'CSR' ? 'selected' : '' }}>CSR</option>
                <option value="Lainnya" {{ old('sumber_anggaran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
    </div>
</div>
@endif
        {{-- ============ ACTIONS ============ --}}
         <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Baru
                    </button>
                     @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <a href="{{ route('uep.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    @else
                     <a href="{{ route('uep.status') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    @endif
                    {{-- <span class="ml-auto text-xs text-gray-400 hidden sm:flex items-center gap-1.5">
                        <span class="text-rose-500">*</span> wajib diisi
                    </span> --}}
                </div>
            </div>
    </form>
</div>
@endsection