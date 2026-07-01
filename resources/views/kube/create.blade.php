@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto"
    x-data="{ 
        pms: {{ $pms->toJson() }},
        selectedKetua: null,
        kecamatan: '{{ old('kecamatan', '') }}',
        desaTerpilih: '{{ old('desa', '') }}',
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
            'Binangus': ['Alangamba', 'Bangkal', 'Binangun', 'Karangnangka', 'Kepudang', 'Pasuruhan', 'Pekuncen', 'Sidayu', 'Widarapayung'],
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
        updateKetua(id) {
            this.selectedKetua = this.pms.find(pm => pm.id == id) || {};
        },
        get desas() {
            return this.listWilayah[this.kecamatan] || [];
        }
    }">

    <h1 class="text-3xl font-bold mb-6">Tambah Kelompok KUBE</h1>

    <form action="{{ route('kube.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h4 class="text-sm font-bold text-blue-600 uppercase mb-4 border-b pb-2">Data Kelompok</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-sm">Nama Kelompok KUBE *</label>
                    <input type="text" name="nama_kelompok_kube" class="w-full mt-2 p-3 border rounded-xl bg-gray-50" required>
                </div>

                <div>
                    <label class="font-semibold text-sm">Pilih Ketua KUBE *</label>
                    <select name="ketua_penerima_manfaat_id" @change="updateKetua($event.target.value)" class="w-full mt-2 p-3 border rounded-xl bg-gray-50" required>
                        <option value="">-- Pilih Ketua --</option>
                        @foreach($pms as $pm)
                            <option value="{{ $pm->id }}">{{ $pm->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

              <input type="hidden" name="kecamatan_kube" x-model="kecamatan">
                <input type="hidden" name="desa_kube" x-model="desaTerpilih">
                        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h4 class="text-sm font-bold text-blue-600 uppercase mb-4 border-b pb-2">Profil Usaha & Teknis</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-sm">Jenis Usaha *</label>
                    <input type="text" name="jenis_usaha_kube" class="w-full mt-2 p-3 border rounded-xl" required>
                </div>
                <div>
                    <label class="font-semibold text-sm">No. Telp KUBE</label>
                    <input type="text" name="no_telp_kube" class="w-full mt-2 p-3 border rounded-xl">
                </div>
  
 <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan *</label>
                    <select name="kecamatan_kube" 
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
                    <select name="desa_kube" 
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
                    <label class="font-semibold text-sm">Alamat Lengkap *</label>
                    <textarea name="alamat_lengkap_kube" class="w-full mt-2 p-3 border rounded-xl" rows="3"></textarea>
                </div>
                
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h4 class="text-sm font-bold text-blue-600 uppercase mb-4 border-b pb-2">Informasi Pendukung</h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <div>
    <label class="font-semibold text-sm">Jumlah Anggota *</label>
    <input type="number" name="jumlah_anggota" class="w-full mt-2 p-3 border rounded-xl bg-gray-50" required placeholder="Masukkan jumlah anggota">
</div>
        <div>
            <label class="font-semibold text-sm">Tahun Realisasi *</label>
            <input type="number" name="tahun_realisasi" value="{{ date('Y') }}" class="w-full mt-2 p-3 border rounded-xl bg-gray-50" required>
        </div>

        <div>
            <label class="font-semibold text-sm">Sumber Anggaran *</label>
            <select name="sumber_anggaran" class="w-full mt-2 p-3 border rounded-xl bg-gray-50" required>
                <option value="APBD">APBD</option>
                <option value="APBN">APBN</option>
                <option value="Mandiri">Mandiri</option>
            </select>
        </div>

        <input type="hidden" name="status_verifikasi" value="pending">
        
    </div>
</div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold">Simpan KUBE</button>
    </form>
</div>
@endsection