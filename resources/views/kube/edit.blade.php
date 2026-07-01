@extends('layouts.app')
@section('content')

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Edit Data Kelompok KUBE</h2>

        <form action="{{ route('kube.update', $kube->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Kelompok KUBE</label>
                    <input type="text" name="nama_kelompok_kube" value="{{ old('nama_kelompok_kube', $kube->nama_kelompok_kube) }}" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Ketua Kelompok</label>
                    <select name="ketua_penerima_manfaat_id" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                        @foreach($pms as $pm)
                            <option value="{{ $pm->id }}" {{ $kube->ketua_penerima_manfaat_id == $pm->id ? 'selected' : '' }}>
                                {{ $pm->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

        <!-- Kecamatan -->
                <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan *</label>
    
    @php
        // Kita ambil daftar key dari object JS atau definisikan manual di sini
        $kecamatanList = [
            'Cilacap Tengah', 'Cilacap Utara', 'Cilacap Selatan', 'Adipala', 'Majenang', 
            'Cimanggu', 'Bantarsari', 'Cipari', 'Kedungreja', 'Kesugihan', 'Binangun', 
            'Nusawungu', 'Kroya', 'Maos', 'Jeruklegi', 'Kawunganten', 'Gandrungmangu', 
            'Sidareja', 'Karangpucung', 'Wanareja', 'Dayeuhluhur', 'Sampang', 'Patimuan', 'Kampung Laut'
        ];
    @endphp

   <select id="kecamatan_select" name="kecamatan_kube" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
    <option value="">-- Pilih Kecamatan --</option>
    @foreach($kecamatanList as $kec)
        <option value="{{ $kec }}" 
            {{ (old('kecamatan_kube', $kube->kecamatan_kube) == $kec) ? 'selected' : '' }}>
            {{ $kec }}
        </option>
    @endforeach
</select>
    @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>

                <!-- Desa -->
               <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan *</label>
    <select id="desa_select" name="desa_kube" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3">
        <option value="">Pilih Kecamatan dahulu</option>
    </select>
    @error('desa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jenis Usaha</label>
                    <input type="text" name="jenis_usaha_kube" value="{{ old('jenis_usaha_kube', $kube->jenis_usaha_kube) }}" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">No Telp</label>
                    <input type="text" name="no_telp_kube" value="{{ old('no_telp_kube', $kube->no_telp_kube) }}" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Tahun Realisasi</label>
                    <input type="number" name="tahun_realisasi" value="{{ old('tahun_realisasi', $kube->tahun_realisasi) }}" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Sumber Anggaran</label>
                    <input type="text" name="sumber_anggaran" value="{{ old('sumber_anggaran', $kube->sumber_anggaran) }}" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                </div>


                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jumlah Anggota</label>
                    <input type="number" name="jumlah_anggota" value="{{ old('jumlah_anggota', $kube->jumlah_anggota) }}" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" required>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat_lengkap_kube" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" rows="3" required>{{ old('alamat_lengkap_kube', $kube->alamat_lengkap_kube) }}</textarea>
            </div>
            <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mt-6">
    <label class="block text-sm font-bold text-blue-900 mb-2">Status Verifikasi *</label>
    <select name="status_verifikasi" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="pending" {{ old('status_verifikasi', $kube->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="disetujui" {{ old('status_verifikasi', $kube->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="ditolak" {{ old('status_verifikasi', $kube->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
</div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('kube.index') }}" class="mr-4 px-6 py-3 bg-gray-200 rounded-xl hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold">Update Data</button>
            </div>
        </form>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const kecamatanSelect = document.getElementById('kecamatan_select');
        const desaSelect = document.getElementById('desa_select');
        const dbKecamatan = "{{ $kube->kecamatan_kube?? '' }}";
        const dbDesa = "{{ $kube->desa_kube ?? '' }}";
        
           
            const dataWilayah = {
                "Cilacap Tengah": ["Donan", "Gunungsimping", "Kutawaru", "Lomanis", "Sidanegara"],
                "Cilacap Utara": ["Bangunkerto", "Kebonmanis", "Mertasinga", "Gumilir"],
                "Cilacap Selatan": ["Cilacap", "Sidakaya", "Tambakreja", "Tegalkamulyan", "Sentolokawat"],
                "Adipala": ["Adipala", "Bunton", "Karanganyar", "Karangbenda", "Penggalang"],
                "Majenang": ["Bener", "Cilopadang", "Jenang", "Mulyadadi", "Mulyasari"],
                "Cimanggu": ["Bantarpanjang", "Cimanggu", "Cisumur", "Karangreja"],
                "Bantarsari": ["Bantarsari", "Binangun", "Rawajaya"],
                "Cipari": ["Caruy", "Cipari", "Cisuru", "Karangreja", "Kutasari", "Mulyadadi", "Pegadingan", "Serang"],
                "Kedungreja": ["Bangunreja", "Bojongsari", "Ciklapa", "Jatisari", "Kaliwuri", "Kedungreja", "Rebamulya", "Sidanegara", "Tambakreja"],
                "Kesugihan": ["Bulupayung", "Ciwuni", "Dengkeng", "Karangjengkol", "Karangkandri", "Kesugihan", "Kuris", "Menganti", "Slarang"],
                "Binangun": ["Alangamba", "Bangkal", "Binangun", "Karangnangka", "Kepudang", "Pasuruhan", "Pekuncen", "Sidayu", "Widarapayung"],
                "Nusawungu": ["Banjareja", "Banjarwaru", "Danasri", "Jedug", "Karangpakis", "Karangsembung", "Kedungbenda", "Nusawungu", "Purwosari"],
                "Kroya": ["Bajing", "Buntu", "Karangmangu", "Kroya", "Merwung", "Mujur", "Pucungkidul", "Pekuncen", "Sikampuh"],
                "Maos": ["Glempang", "Karangkemiri", "Klapagada", "Maos Kidul", "Maos Lor", "Mergangsan", "Panisian", "Punthuk"],
                "Jeruklegi": ["Brebeg", "Cilibang", "Citepus", "Jambusari", "Jeruklegi Kulon", "Jeruklegi Wetan", "Prapagan", "Sumingkir"],
                "Kawunganten": ["Babakan", "Bo Bo", "Boong", "Glempang", "Kalijeruk", "Kawunganten", "Mentasan", "Sarwadadi", "Ujungmanik"],
                "Gandrungmangu": ["Bantarmangu", "Cisumur", "Gandrungmangu", "Gandrungmanis", "Karanganyar", "Kertajaya", "Layansari", "Muktisari"],
                "Sidareja": ["Gunungreja", "Kunci", "Margasari", "Penolih", "Sidamulya", "Sidareja", "Sudagaran", "Tinggarjaya"],
                "Karangpucung": ["Bengbulang", "Cidadap", "Cipasung", "Karangpucung", "Tayem", "Pangawaren", "Surusunda"],
                "Wanareja": ["Adimulya", "Bantar", "Cigintung", "Cilongkrang", "Jatisari", "Majingklak", "Malabar", "Palugon", "Wanareja"],
                "Dayeuhluhur": ["Bingkeng", "Cigerendeng", "Cilumping", "Dayeuhluhur", "Hanum", "Kutaagung", "Matenggeng", "Samping"],
                "Sampang": ["Karangtengah", "Ketanggung", "Nusajati", "Pakuwon", "Sampang", "Sidasari"],
                "Patimuan": ["Bulupayung", "Cinyawang", "Patimuan", "Purwodadi", "Rawaapu", "Sidamukti"],
                "Kampung Laut": ["Klaces", "Panikel", "Ujungalor", "Ujunggagak"]
            };


        function updateDesa(kecValue, targetDesa = "") {
            // Cari key yang cocok tanpa peduli besar/kecil huruf
            const foundKey = Object.keys(dataWilayah).find(k => 
                k.toLowerCase() === kecValue.toLowerCase()
            );

            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';

            if (foundKey && dataWilayah[foundKey]) {
                dataWilayah[foundKey].forEach(desa => {
                    const isSelected = (desa.toLowerCase() === targetDesa.toLowerCase()) ? 'selected' : '';
                    desaSelect.innerHTML += `<option value="${desa}" ${isSelected}>${desa}</option>`;
                });
            }
        }

        // Pemicu saat halaman dimuat
        if (dbKecamatan) {
            updateDesa(dbKecamatan, dbDesa);
        }

        // Pemicu saat user pilih ulang
        kecamatanSelect.addEventListener('change', function() {
            updateDesa(this.value);
        });
    });
</script>

@endsection