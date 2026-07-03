@extends('layouts.app')
@section('content')

 <div class="mb-8">
        <br>
        <a href="{{ route('kube.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Ubah Data Kelompok Usaha Bersama</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui Data Kelompok Usaha Bersama Kabupaten Cilacap.</p>
    </div>



       <form action="{{ route('kube.update', $kube->id) }}" method="POST"
      class="bg-white p-6 rounded-lg shadow-md"
      x-data="{ statusVerifikasi: '{{ old('status_verifikasi', $kube->status_verifikasi) }}' }">
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
                    <label class="block text-sm font-semibold text-gray-700">Sumber Anggaran *</label>
                    <select name="sumber_anggaran" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        @foreach(['APBN', 'APBD', 'CSR', 'Lainnya'] as $sumber)
                            <option value="{{ $sumber }}" {{ old('sumber_anggaran', $kube->sumber_anggaran) == $sumber ? 'selected' : '' }}>{{ $sumber }}</option>
                        @endforeach
                    </select>
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
    <select name="status_verifikasi" x-model="statusVerifikasi" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="pending" {{ old('status_verifikasi', $kube->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="disetujui" {{ old('status_verifikasi', $kube->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="ditolak" {{ old('status_verifikasi', $kube->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
 
    {{-- Muncul otomatis hanya saat status = ditolak --}}
    <div x-show="statusVerifikasi === 'ditolak'" x-cloak x-transition class="mt-4">
        <label class="block text-sm font-bold text-rose-700 mb-2">Alasan Penolakan *</label>
        <textarea name="catatan_penolakan" rows="3"
                  x-bind:required="statusVerifikasi === 'ditolak'"
                  class="w-full rounded-xl border-rose-200 bg-white text-sm p-3 focus:border-rose-500 focus:ring-rose-500"
                  placeholder="Jelaskan alasan penolakan agar pemohon bisa memperbaiki data">{{ old('catatan_penolakan', $kube->catatan_penolakan) }}</textarea>
        @error('catatan_penolakan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
    </div>
</div>

           <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Perbarui Data
                    </button>
                    <a href="{{ route('kube.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                </div>
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
                "Cilacap Utara": ["Tritih Kulon", "Kebonmanis", "Mertasinga", "Gumilir", "Karangtalun"],
                "Cilacap Selatan": ["Cilacap", "Sidakaya", "Tambakreja", "Tegalkamulyan", "Tegalreja"],
                "Adipala": ["Adipala", "Adiraja", "Adireja Kulon", "Adireja Wetan", "Doplang", "Glempangpasir", "Gombolharjo", "Kalikudi", "Bunton", "Karanganyar", "Karangbenda", "Penggalang", "Karangsari", "Pedasong", "Welahan Wetan", "Wlahar"],
                "Majenang": ["Bener", "Boja", "Cibeunying", "Pandangsari", "Cilopadang", "Jenang", "Mulyadadi", "Mulyasari", "Padangjaya", "Pahonjean", "Pengadegan", "Sadabumi", "Sadahayu", "Salebu", "Sepatnunggal", "Sindangsari", "Ujungbarang"],
                "Cimanggu": ["Bantarpanjang", "Bantarmangu", "Cibalung", "Cijati", "Cilempuyang", "Cimanggu", "Cisalak", "Karangreja", "Karangsari", "Kutabumi", "Mandala", "Negarajati", "Panimbang", "Pesahangan", "Rejodadi"],
                "Bantarsari": ["Bantarsari", "Binangun", "Bulaksari", "Cikedondong", "Citembong", "Kamulyan", "Kedungwadas", "Rawajaya"],
                "Cipari": ["Caruy", "Cipari", "Cisuru", "Karangreja", "Kutasari", "Mekarsari", "Mulyadadi", "Pegadingan", "Segaralangu", "Serang", "Sidasari"],
                "Kedungreja": ["Bangunreja", "Bojongsari", "Bumireja", "Ciklapa", "Jatisari", "Kaliwungu", "Kedungreja", "Rejamulya", "Sidanegara", "Tambakreja", "Tambaksari"],
                "Kesugihan": ["Bulupayung", "Ciwuni", "Dondong", "Jangrana", "Kalisabuk", "Karangjengkol", "Karangkandri", "Keleng", "Kesugihan", "Kesugihan Kidul", "Kuripan", "Kuripan Kidul", "Menganti", "Pesanggrahan", "Planjan", "Slarang"],
                "Binangun": ["Alangamba", "Bangkal", "Binangun", "Jati", "Jepara Kulon", "Jepara Wetan", "Karangnangka", "Kemojing", "Kepudang", "Pagubugan", "Pagubugan Kulon", "Pasuruhan", "Pesawahan", "Sidaurip", "Widarapayung Kulon", "Sidayu", "Widarapayung Wetan"],
                "Nusawungu": ["Banjareja", "Banjarsari", "Banjarwaru", "Danasri", "Danasri Kidul", "Danasri Lor", "Jetis", "Karangpakis", "Karangputat", "Karangsembung", "Karangtawang", "Kedungbenda", "Klumprit", "Nusawangkal", "Nusawungu", "Purwadadi", "Sikanco"],
                "Kroya": ["Ayamalas", "Bajing", "Bajing Kulon", "Buntu", "Gentasari", "Karangmangu", "Karangturi", "Kedawung", "Kroya", "Mergawati", "Mujur", "Mujur Lor", "Pekuncen", "Pesanggrahan", "Pucung Kidul", "Pucung Lor", "Sikampuh"],
                "Maos": ["Glempang", "Kalijaran", "Karangkemiri", "Karangreja", "Karangrena", "Klapagada", "Maos Kidul", "Maos Lor", "Mernek", "Penisihan"],
                "Jeruklegi": ["Brebeg", "Cilibang", "Citepus", "Jambusari", "Jeruklegi Kulon", "Jeruklegi Wetan", "Karangkemiri", "Mendala", "Prapagan", "Sawangan", "Sumingkir", "Tritih Lor", "Tritih Wetan"],
                "Kawunganten": ["Babakan", "Bojong", "Bringkeng", "Grugu", "Kalijeruk", "Kawunganten", "Kawunganten Lor", "Kubangkangkung", "Mentasan", "Sarwadadi", "Sidaurip", "Ujungmanik"],
                "Gandrungmangu": ["Bulusari", "Cinangsi", "Cisumur", "Gandrungmangu", "Gandrungmanis", "Gintungreja", "Karanganyar", "Karanggintung", "Kertajaya", "Layansari", "Muktisari", "Rungkang", "Sidaurip", "Wringinharjo"],
                "Sidareja": ["Gunungreja", "Karanggedang", "Kunci", "Margasari", "Penyarang", "Sidamulya", "Sidareja", "Sudagaran", "Tegalsari", "Tinggarjaya"],
                "Karangpucung": ["Babakan", "Bengbulang", "Cidadap", "Ciporos", "Ciruyung", "Gunungtelu", "Karangpucung", "Pamulihan", "Pengawaren", "Sidamulya", "Sindangbarang", "Surusunda", "Tayem", "Tayemtimur"],
                "Wanareja": ["Adimulya", "Bantar", "Cigintung", "Cilongkrang", "Jambu", "Limbangan", "Madura", "Madusari", "Majingklak", "Malabar", "Palugon", "Purwasari", "Sidamulya", "Tambaksari", "Tarisi","Wanareja"],
                "Dayeuhluhur": ["Bingkeng", "Bolang", "Cijeruk", "Cilumping", "Ciwalen", "Datar", "Dayeuhluhur", "Hanum", "Kutaagung", "Matenggeng", "Panulisan", "Panulisan Barat", "Panulisan Timur", "Sumpinghayu"],
                "Sampang": ["Brani", "Karangasem", "Karangjati", "Karangtengah", "Ketanggung", "Nusajati", "Paberasan", "Paketingan", "Sampang", "Sidasari"],
                "Patimuan": ["Bulupayung", "Cimrutu", "Cinyawang", "Patimuan", "Purwodadi", "Rawaapu", "Sidamukti"],
                "Kampung Laut": ["Klaces", "Panikel", "Ujungalang", "Ujunggagak"]
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