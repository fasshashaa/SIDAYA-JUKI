@extends('layouts.app')
@section('content')

<div class="mb-8">
    <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1 mb-2">
        ← Kembali ke Daftar UEP
    </a>
    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Data UEP</h1>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-4xl"
     x-data="{ 
        kecamatan: '{{ old('kecamatan', '') }}',
        desaTerpilih: '{{ old('desa', '') }}',
        selectedPm: {},
        pmList: {{ $penerimaManfaats->toJson() }},
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
            'Ciapri': ['Caruy', 'Cipari', 'Cisuru', 'Karangreja', 'Kutasari', 'Mulyadadi', 'Pegadingan', 'Serang'],
            'Patimuan': ['Bulupayung', 'Cinyawang', 'Patimuan', 'Purwodadi', 'Rawaapu', 'Sidamukti'],
            'Kampung Laut': ['Klaces', 'Panikel', 'Ujungalor', 'Ujunggagak']
        },
        get desas() { return this.listWilayah[this.kecamatan] || []; },
       updateFields(id) { 
        let data = this.pmList.find(pm => pm.id == id);
        this.selectedPm = data ? data : {}; // Jika tidak ditemukan, set ke objek kosong
    }   }">

    <form action="{{ route('uep.store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="status_verifikasi" value="pending">
        <input type="hidden" name="status_usaha" value="Aktif">
<input type="hidden" name="nama_lengkap" :value="selectedPm.nama_lengkap">
<input type="hidden" name="no_wa" :value="selectedPm.no_wa">
<input type="hidden" name="nama_ibu_kandung" :value="selectedPm.nama_ibu_kandung">
<input type="hidden" name="nik" :value="selectedPm.nik">
<input type="hidden" name="no_kk" :value="selectedPm.no_kk">
        <div>
    <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">I. Identitas Pemilik Usaha</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Penerima Manfaat *</label>
            <select name="penerima_manfaat_id" @change="updateFields($event.target.value)" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                <option value="">-- Pilih Nama Penerima --</option>
                @foreach($penerimaManfaats as $pm)
                    <option value="{{ $pm->id }}">{{ $pm->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
    <input type="text" 
           :value="selectedPm.nama_lengkap || ''" 
           readonly 
           class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
</div>

<input type="hidden" name="nama_lengkap" :value="selectedPm.nama_lengkap || ''">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ibu Kandung</label>
                <input type="text" name="nama_ibu_kandung" 
                       :value="selectedPm ? selectedPm.nama_ibu_kandung : ''" 
                       readonly class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">NIK</label>
                <input type="text" name="nik" 
                       :value="selectedPm ? selectedPm.nik : ''" 
                       readonly class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor KK</label>
                <input type="text" name="no_kk" 
                       :value="selectedPm ? selectedPm.no_kk : ''" 
                       readonly class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
            </div>
            <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">No. WhatsApp</label>
    <input type="text" name="no_wa" 
           :value="selectedPm.no_wa || ''" 
           readonly class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
</div>
        </div>
    </div>
</div>

<div class="pt-4">
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">II. Profil & Legalisasi Usaha</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Usaha / Merk Dagang *</label>
                        <input type="text" name="nama_usaha" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_usaha') }}">
                        @error('nama_usaha') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Produk *</label>
                        <select name="kategori_produk" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kuliner / Makanan Olahan" {{ old('kategori_produk') == 'Kuliner / Makanan Olahan' ? 'selected' : '' }}>Kuliner / Makanan Olahan</option>
                            <option value="Kerajinan / Craft" {{ old('kategori_produk') == 'Kerajinan / Craft' ? 'selected' : '' }}>Kerajinan / Craft</option>
                            <option value="Fashion / Konveksi" {{ old('kategori_produk') == 'Fashion / Konveksi' ? 'selected' : '' }}>Fashion / Konveksi</option>
                            <option value="Pertanian / Peternakan" {{ old('kategori_produk') == 'Pertanian / Peternakan' ? 'selected' : '' }}>Pertanian / Peternakan</option>
                            <option value="Jasa / Service" {{ old('kategori_produk') == 'Jasa / Service' ? 'selected' : '' }}>Jasa / Service</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Perkembangan *</label>
                        <select name="status_perkembangan" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="rintisan" {{ old('status_perkembangan') == 'rintisan' ? 'selected' : '' }}>Rintisan</option>
                            <option value="berkembang" {{ old('status_perkembangan') == 'berkembang' ? 'selected' : '' }}>Berkembang</option>
                            <option value="mandiri" {{ old('status_perkembangan') == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                        </select>
                    </div>

                      <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan *</label>
                    <select name="kecamatan_usaha" 
                            x-model="kecamatan" 
                            @change="desaTerpilih = ''"
                            required 
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
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
                    @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan *</label>
                    <select name="desa_kelurahan_usaha" 
                            x-model="desaTerpilih"
                            required
                            :disabled="desas.length === 0"
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-60 disabled:cursor-not-allowed">
                        
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
                    @error('desa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>


                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Detail Usaha *</label>
                        <textarea name="alamat_lengkap" rows="3" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" placeholder="Nama jalan, RT/RW, Dusun tempat usaha beroperasi">{{ old('alamat_lengkap') }}</textarea>
                    </div>
                </div>
            </div>
<div class="pt-4">
    <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">III. Sumber Pembiayaan Realisasi</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Realisasi Bantuan *</label>
            <select name="tahun_realisasi" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                @php
                    $tahunSekarang = date('Y');
                    $tahunMulai = 2020; // Silakan sesuaikan tahun mulai
                @endphp
                @for ($tahun = $tahunSekarang; $tahun >= $tahunMulai; $tahun--)
                    <option value="{{ $tahun }}" {{ old('tahun_realisasi', $tahunSekarang) == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Sumber Anggaran *</label>
            <select name="sumber_anggaran" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                <option value="">-- Pilih Sumber Anggaran --</option>
                <option value="APBN" {{ old('sumber_anggaran') == 'APBN' ? 'selected' : '' }}>APBN</option>
                <option value="APBD" {{ old('sumber_anggaran') == 'APBD' ? 'selected' : '' }}>APBD</option>
                <option value="CSR" {{ old('sumber_anggaran') == 'CSR' ? 'selected' : '' }}>CSR</option>
                <option value="Lainnya" {{ old('sumber_anggaran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        {{-- <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Usaha *</label>
    <select name="status_usaha" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="">-- Pilih Status --</option>
        <option value="Aktif" {{ old('status_usaha') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="Tidak Aktif" {{ old('status_usaha') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="Tutup Sementara" {{ old('status_usaha') == 'Tutup Sementara' ? 'selected' : '' }}>Tutup Sementara</option>
    </select>
    @error('status_usaha') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div> --}}
    </div>
</div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-sm">
                    Simpan UEP
                </button>
                <a href="{{ route('uep.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                    Batal
                </a>
            </div>
        </form> 
</div>
@endsection