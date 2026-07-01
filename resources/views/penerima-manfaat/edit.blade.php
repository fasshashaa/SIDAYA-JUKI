@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <a href="{{ route('penerima-manfaat.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1 mb-2">
            ← Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Penerima Manfaat</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui data kependudukan atau wilayah jika terdapat perubahan data master.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-4xl">
        <form action="{{ route('penerima-manfaat.update', $penerima->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
<input type="hidden" name="status_verifikasi" value="{{ $penerima->status_verifikasi }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_lengkap', $penerima->nama_lengkap) }}">
                    @error('nama_lengkap') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Ibu Kandung -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung *</label>
                    <input type="text" name="nama_ibu_kandung" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_ibu_kandung', $penerima->nama_ibu_kandung ?? '') }}">
                    @error('nama_ibu_kandung') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIK *</label>
                    <input type="text" name="nik" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nik', $penerima->nik) }}">
                    @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- No KK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kartu Keluarga *</label>
                    <input type="text" name="no_kk" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('no_kk', $penerima->no_kk ?? '') }}">
                    @error('no_kk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nomor WhatsApp -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('no_wa', $penerima->no_wa) }}">
                    @error('no_wa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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

    <select id="kecamatan_select" name="kecamatan" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="">-- Pilih Kecamatan --</option>
        @foreach($kecamatanList as $kec)
            <option value="{{ $kec }}" 
                {{ strtoupper(old('kecamatan', $penerima->kecamatan)) == strtoupper($kec) ? 'selected' : '' }}>
                {{ $kec }}
            </option>
        @endforeach
    </select>
    @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>

                <!-- Desa -->
               <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan *</label>
    <select id="desa_select" name="desa" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3">
        <option value="">Pilih Kecamatan dahulu</option>
    </select>
    @error('desa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>

                <!-- Alamat Detail -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Detail (RT/RW, Jalan, Dusun) *</label>
                    <textarea name="alamat_detail" rows="3" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all">{{ old('alamat_detail', $penerima->alamat_detail ?? '') }}</textarea>
                    @error('alamat_detail') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
<div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mt-6">
    <label class="block text-sm font-bold text-blue-900 mb-2">Status Verifikasi *</label>
    <select name="status_verifikasi" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="pending" {{ old('status_verifikasi', $penerima->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="disetujui" {{ old('status_verifikasi', $penerima->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="ditolak" {{ old('status_verifikasi', $penerima->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
</div>
            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-sm">
                    Perbarui Data
                </button>
                <a href="{{ route('penerima-manfaat.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Script AJAX Cepat -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kecamatanSelect = document.getElementById('kecamatan_select');
        const desaSelect = document.getElementById('desa_select');
        const dbKecamatan = "{{ $penerima->kecamatan ?? '' }}";
        const dbDesa = "{{ $penerima->desa ?? '' }}";
        
           
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