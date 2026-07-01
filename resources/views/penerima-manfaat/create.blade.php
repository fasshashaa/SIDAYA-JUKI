@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <a href="{{ route('penerima-manfaat.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1 mb-2">
            ← Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Penerima Manfaat</h1>
        <p class="text-sm text-gray-500 mt-1">Isi data kependudukan dan domisili Kabupaten Cilacap dengan benar.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-4xl"
         x-data="{ 
            kecamatan: '{{ old('kecamatan', '') }}',
            desaTerpilih: '{{ old('desa', '') }}',
            listWilayah: {
                'CILACAP TENGAH': ['Donan', 'Gunungsimping', 'Kutawaru', 'Lomanis', 'Sidanegara'],
                'CILACAP UTARA': ['Bangunkerto', 'Kebonmanis', 'Mertasinga', 'Trisula', 'Gumilir'],
                'CILACAP SELATAN': ['Cilacap', 'Sidakaya', 'Tambakreja', 'Tegalkamulyan', 'Sentolokawat'],
                'ADIPALA': ['Adipala', 'Bunton', 'Glempangpasir', 'Gombolharjo', 'Karanganyar', 'Karangbenda', 'Karangreja', 'Pedasong', 'Penggalang', 'Pluneng', 'Wlahar'],
                'MAJENANG': ['Bener', 'Boja', 'Cibeunying', 'Cilopadang', 'Jenang', 'Mulyadadi', 'Mulyasari', 'Padangjaya', 'Pahang', 'Sindangsari', 'Ujungbarang'],
                'CIMANGGU': ['Bantarpanjang', 'Cibalung', 'Cilempuyang', 'Cimanggu', 'Cisumur', 'Karangreja', 'Mandala', 'Negarajati', 'Pesahangan', 'Rejodadi'],
                'BANTARSARI': ['Bantarsari', 'Binangun', 'Cikedondong', 'Kamulyan', 'Kedungwringin', 'Rawajaya'],
                'KEDUNGREJA': ['Bangunreja', 'Bojongsari', 'Ciklapa', 'Jatisari', 'Kaliwuri', 'Kedungreja', 'Rebamulya', 'Sidanegara', 'Tambakreja'],
                'KESUGIHAN': ['Bulupayung', 'Ciwuni', 'Dengkeng', 'Karangjengkol', 'Karangkandri', 'Kesugihan', 'Kuris', 'Menganti', 'Slarang'],
                'BINANGUN': ['Alangamba', 'Bangkal', 'Binangun', 'Karangnangka', 'Kepudang', 'Pasuruhan', 'Pekuncen', 'Sidayu', 'Widarapayung'],
                'NUSAWUNGU': ['Banjareja', 'Banjarwaru', 'Danasri', 'Jedug', 'Karangpakis', 'Karangsembung', 'Kedungbenda', 'Nusawungu', 'Purwosari'],
                'KROYA': ['Bajing', 'Buntu', 'Karangmangu', 'Kroya', 'Merwung', 'Mujur', 'Pucungkidul', 'Pekuncen', 'Sikampuh'],
                'MAOS': ['Glempang', 'Karangkemiri', 'Klapagada', 'Maos Kidul', 'Maos Lor', 'Mergangsan', 'Panisian', 'Punthuk'],
                'JERUKLEGI': ['Brebeg', 'Cilibang', 'Citepus', 'Jambusari', 'Jeruklegi Kulon', 'Jeruklegi Wetan', 'Prapagan', 'Sumingkir'],
                'KAWUNGANTEN': ['Babakan', 'Bo Bo', 'Boong', 'Glempang', 'Kalijeruk', 'Kawunganten', 'Mentasan', 'Sarwadadi', 'Ujungmanik'],
                'GANDRUNGMANGU': ['Bantarmangu', 'Cisumur', 'Gandrungmangu', 'Gandrungmanis', 'Karanganyar', 'Kertajaya', 'Layansari', 'Muktisari'],
                'SIDAREJA': ['Gunungreja', 'Kunci', 'Margasari', 'Penolih', 'Sidamulya', 'Sidareja', 'Sudagaran', 'Tinggarjaya'],
                'KARANGPUCUNG': ['Bengbulang', 'Cidadap', 'Cipasung', 'Karangpucung', 'Tayem', 'Pangawaren', 'Surusunda'],
                'WANAREJA': ['Adimulya', 'Bantar', 'Cigintung', 'Cilongkrang', 'Jatisari', 'Majingklak', 'Malabar', 'Palugon', 'Wanareja'],
                'DAYEUHLUHUR': ['Bingkeng', 'Cigerendeng', 'Cilumping', 'Dayeuhluhur', 'Hanum', 'Kutaagung', 'Matenggeng', 'Samping'],
                'SAMPANG': ['Karangtengah', 'Ketanggung', 'Nusajati', 'Pakuwon', 'Sampang', 'Sidasari'],
                'CIPARI': ['Caruy', 'Cipari', 'Cisuru', 'Karangreja', 'Kutasari', 'Mulyadadi', 'Pegadingan', 'Serang'],
                'PATIMUAN': ['Bulupayung', 'Cinyawang', 'Patimuan', 'Purwodadi', 'Rawaapu', 'Sidamukti'],
                'KAMPUNG LAUT': ['Klaces', 'Panikel', 'Ujungalor', 'Ujunggagak']
            },
            
            get desas() {
                return this.listWilayah[this.kecamatan] || [];
            }
         }">
         
        <form action="{{ route('penerima-manfaat.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="status_verifikasi" value="pending">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama sesuai KTP">
                    @error('nama_lengkap') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung *</label>
                    <input type="text" name="nama_ibu_kandung" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_ibu_kandung') }}" placeholder="Masukkan nama ibu kandung">
                    @error('nama_ibu_kandung') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIK (16 Digit) *</label>
                    <input type="text" name="nik" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nik') }}" placeholder="Masukkan NIK">
                    @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kartu Keluarga (16 Digit) *</label>
                    <input type="text" name="no_kk" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('no_kk') }}" placeholder="Masukkan Nomor KK">
                    @error('no_kk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                    <input type="text" name="no_wa" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('no_wa') }}" placeholder="Contoh: 08123456789">
                    @error('no_wa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan *</label>
                    <select name="kecamatan" 
                            x-model="kecamatan" 
                            @change="desaTerpilih = ''"
                            required 
                            class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Pilih Kecamatan --</option>
                        <option value="KEDUNGREJA">Kedungreja</option>
                        <option value="KESUGIHAN">Kesugihan</option>
                        <option value="ADIPALA">Adipala</option>
                        <option value="BINANGUN">Binangun</option>
                        <option value="NUSAWUNGU">Nusawungu</option>
                        <option value="KROYA">Kroya</option>
                        <option value="MAOS">Maos</option>
                        <option value="JERUKLEGI">Jeruklegi</option>
                        <option value="KAWUNGANTEN">Kawunganten</option>
                        <option value="GANDRUNGMANGU">Gandrungmangu</option>
                        <option value="SIDAREJA">Sidareja</option>
                        <option value="KARANGPUCUNG">Karangpucung</option>
                        <option value="CIMANGGU">Cimanggu</option>
                        <option value="MAJENANG">Majenang</option>
                        <option value="WANAREJA">Wanareja</option>
                        <option value="DAYEUHLUHUR">Dayeuhluhur</option>
                        <option value="SAMPANG">Sampang</option>
                        <option value="CIPARI">Cipari</option>
                        <option value="PATIMUAN">Patimuan</option>
                        <option value="BANTARSARI">Bantarsari</option>
                        <option value="CILACAP SELATAN">Cilacap Selatan</option>
                        <option value="CILACAP TENGAH">Cilacap Tengah</option>
                        <option value="CILACAP UTARA">Cilacap Utara</option>
                        <option value="KAMPUNG LAUT">Kampung Laut</option>
                    </select>
                    @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan *</label>
                    <select name="desa" 
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Detail (RT/RW, Jalan, Dusun) *</label>
                    <textarea name="alamat_detail" rows="3" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" placeholder="Contoh: Jl. Gatot Subroto No. 12, RT 03/RW 05, Dusun Manis">{{ old('alamat_detail') }}</textarea>
                    @error('alamat_detail') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-sm">
                    Simpan Baru
                </button>
                <a href="{{ route('penerima-manfaat.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection