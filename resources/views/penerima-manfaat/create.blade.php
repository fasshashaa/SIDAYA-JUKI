@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <br>
        <a href="{{ route('penerima-manfaat.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Penerima Manfaat</h1>
        <p class="text-sm text-gray-500 mt-1">Isi data kependudukan dan domisili Kabupaten Cilacap dengan benar.</p>
    </div>

    <div class="max-w-4xl"
         x-data="{ 
            kecamatan: '{{ old('kecamatan', '') }}',
            desaTerpilih: '{{ old('desa', '') }}',
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
            
            get desas() {
                return this.listWilayah[this.kecamatan] || [];
            }
         }">
         
        <form action="{{ route('penerima-manfaat.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="status_verifikasi" value="pending">

            {{-- ================= SECTION: KAITKAN AKUN PENGGUNA ================= --}}
            <div class="bg-indigo-50/50 rounded-3xl border border-indigo-100 p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5m6-10a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-indigo-900">Kaitkan Akun Pengguna</h3>
                        <p class="text-xs text-indigo-600/70">Tautkan data ini dengan akun masyarakat yang sudah terdaftar</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-indigo-900 mb-2">Pilih Akun Pengguna (Masyarakat) <span class="text-rose-500">*</span></label>
                    <select name="user_id" required class="w-full rounded-xl border-indigo-200 bg-white text-sm p-3 focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            {{-- Hanya tampilkan user yang rolenya 'user' --}}
                            @if($user->role === 'user')
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endif
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- ================= SECTION: DATA PRIBADI ================= --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Data Pribadi</h3>
                        <p class="text-xs text-gray-400">Sesuaikan dengan dokumen kependudukan resmi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama sesuai KTP">
                        @error('nama_lengkap') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_ibu_kandung" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_ibu_kandung') }}" placeholder="Masukkan nama ibu kandung">
                        @error('nama_ibu_kandung') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                        <input type="number" name="nik" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 font-mono transition-all" value="{{ old('nik') }}" placeholder="Masukkan NIK">
                        @error('nik') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kartu Keluarga (16 Digit) <span class="text-rose-500">*</span></label>
                        <input type="number" name="no_kk" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 font-mono transition-all" value="{{ old('no_kk') }}" placeholder="Masukkan Nomor KK">
                        @error('no_kk') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                            </span>
                            <input type="text" name="no_wa" maxlength="13" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 pl-10 transition-all" value="{{ old('no_wa') }}" placeholder="Contoh: 08123456789">
                        </div>
                        @error('no_wa') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- ================= SECTION: DOMISILI ================= --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Domisili</h3>
                        <p class="text-xs text-gray-400">Wilayah tempat tinggal saat ini di Kabupaten Cilacap</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan <span class="text-rose-500">*</span></label>
                        <select name="kecamatan" 
                                x-model="kecamatan" 
                                @change="desaTerpilih = ''"
                                required 
                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all">
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
                        @error('kecamatan') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan <span class="text-rose-500">*</span></label>
                        <select name="desa" 
                                x-model="desaTerpilih"
                                required
                                :disabled="desas.length === 0"
                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:bg-white focus:border-blue-500 focus:ring-blue-500 disabled:opacity-60 disabled:cursor-not-allowed transition-all">
                            
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
                        @error('desa') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Detail (RT/RW, Jalan, Dusun) <span class="text-rose-500">*</span></label>
                        <textarea name="alamat_detail" rows="3" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" placeholder="Contoh: Jl. Gatot Subroto No. 12, RT 03/RW 05, Dusun Manis">{{ old('alamat_detail') }}</textarea>
                        @error('alamat_detail') <span class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- ================= ACTIONS ================= --}}
            <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Baru
                    </button>
                    <a href="{{ route('penerima-manfaat.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection