@extends('layouts.app')
@section('content')
    <div class="mb-8">
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1 mb-2">
            ← Kembali ke Daftar UEP
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Data UEP</h1>
    </div>
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-4xl"

     x-data="{ 
        // Mengisi data dari database saat halaman dibuka
        selectedPm: {
            nama_lengkap: '{{ $uep->nama_lengkap }}',
            nama_ibu_kandung: '{{ $uep->nama_ibu_kandung }}',
            nik: '{{ $uep->nik }}',
            no_kk: '{{ $uep->no_kk }}',
            no_wa: '{{ $uep->no_wa }}'
        },
        // Mengubah data JSON penerima manfaat dari Controller
        pmList: {{ $penerimaManfaats->toJson() }},
        
        // Fungsi untuk update saat dropdown diganti
        updateFields(id) { 
            let data = this.pmList.find(pm => pm.id == id);
            if(data) {
                this.selectedPm = data;
            }
        }
     }">

<form action="{{ route('uep.update', $uep->id) }}" method="POST" id="form-update">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Penerima Manfaat *</label>
            <select name="penerima_manfaat_id" @change="updateFields($event.target.value)" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                <option value="">-- Pilih Nama Penerima --</option>
                @foreach($penerimaManfaats as $pm)
                    <option value="{{ $pm->id }}" {{ $uep->penerima_manfaat_id == $pm->id ? 'selected' : '' }}>
                        {{ $pm->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" x-model="selectedPm.nama_lengkap" readonly class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung</label>
                <input type="text" name="nama_ibu_kandung" x-model="selectedPm.nama_ibu_kandung" readonly class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">NIK</label>
                <input type="text" name="nik" x-model="selectedPm.nik" readonly class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">No. KK</label>
                <input type="text" name="no_kk" x-model="selectedPm.no_kk" readonly class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">No. WhatsApp</label>
                <input type="text" name="no_wa" x-model="selectedPm.no_wa" readonly class="w-full rounded-xl border-gray-200 bg-gray-100 p-3">
            </div>
        </div>

        
</div>

            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">II. Profil & Lokasi Usaha</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Usaha *</label>
                        <input type="text" name="nama_usaha" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3" value="{{ old('nama_usaha', $uep->nama_usaha) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Produk *</label>
                        <select name="kategori_produk" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                            @foreach(['Kuliner / Makanan Olahan', 'Kerajinan / Craft', 'Fashion / Konveksi', 'Pertanian / Peternakan', 'Jasa / Service'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori_produk', $uep->kategori_produk) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Perkembangan *</label>
                        <select name="status_perkembangan" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                            <option value="rintisan" {{ old('status_perkembangan', $uep->status_perkembangan) == 'rintisan' ? 'selected' : '' }}>Rintisan</option>
                            <option value="berkembang" {{ old('status_perkembangan', $uep->status_perkembangan) == 'berkembang' ? 'selected' : '' }}>Berkembang</option>
                            <option value="mandiri" {{ old('status_perkembangan', $uep->status_perkembangan) == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
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

   <select id="kecamatan_select" name="kecamatan_usaha" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
    <option value="">-- Pilih Kecamatan --</option>
    @foreach($kecamatanList as $kec)
        <option value="{{ $kec }}" 
            {{ (old('kecamatan_usaha', $uep->kecamatan_usaha) == $kec) ? 'selected' : '' }}>
            {{ $kec }}
        </option>
    @endforeach
</select>
    @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>

                <!-- Desa -->
               <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan *</label>
    <select id="desa_select" name="desa_kelurahan_usaha" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3">
        <option value="">Pilih Kecamatan dahulu</option>
    </select>
    @error('desa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap *</label>
                        <textarea name="alamat_lengkap" rows="3" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">{{ old('alamat_lengkap', $uep->alamat_lengkap) }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">III. Sumber Pembiayaan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Realisasi *</label>
                        <select name="tahun_realisasi" class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                            @for ($t = date('Y'); $t >= 2020; $t--)
                                <option value="{{ $t }}" {{ old('tahun_realisasi', $uep->tahun_realisasi) == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sumber Anggaran *</label>
                        <select name="sumber_anggaran" class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                            @foreach(['APBN', 'APBD', 'CSR', 'Lainnya'] as $sumber)
                                <option value="{{ $sumber }}" {{ old('sumber_anggaran', $uep->sumber_anggaran) == $sumber ? 'selected' : '' }}>{{ $sumber }}</option>
                            @endforeach
                        </select>
                    </div>
<div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mt-6">
    <label class="block text-sm font-bold text-blue-900 mb-2">Status Verifikasi *</label>
    <select name="status_verifikasi" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="pending" {{ old('status_verifikasi', $uep->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="disetujui" {{ old('status_verifikasi', $uep->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="ditolak" {{ old('status_verifikasi', $uep->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
</div>
<div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mt-6">
    <label class="block text-sm font-bold text-blue-900 mb-2">Status Usaha *</label>
    <select name="status_usaha" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="Aktif" {{ old('status_usaha', $uep->status_usaha) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="Tidak Aktif" {{ old('status_usaha', $uep->status_usaha) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        <option value="Tutup Sementara" {{ old('status_usaha', $uep->status_usaha) == 'Tutup Sementara' ? 'selected' : '' }}>Tutup Sementara</option>
    </select>
    <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
</div>
                </div>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-sm">
                    Update Data
                </button>
                <a href="{{ route('uep.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const kecamatanSelect = document.getElementById('kecamatan_select');
        const desaSelect = document.getElementById('desa_select');
        const dbKecamatan = "{{ $uep->kecamatan_usaha?? '' }}";
        const dbDesa = "{{ $uep->desa_kelurahan_usaha ?? '' }}";
        
           
            const dataWilayah = {
                "Cilacap Tengah": ["Donan", "Gunungsimping", "Kutawaru", "Lomanis", "Sidanegara"],
                "Cilacap Utara": ["Bangunkerto", "Kebonmanis", "Mertasinga", "Gumilir"],
                "Cilacap Selatan": ["Cilacap", "Sidakaya", "Tambakreja", "Tegalkamulyan", "Sentolokawat"],
                "Adipala": ["Adipala", "Bunton", "Karanganyar", "Karangbenda", "Penggalang"],
                "Majenang": ["Bener", "Cilopadang", "Jenang", "Mulyadadi", "Mulyasari", "Padangjaya", "Pangasinan", "Sukamaju", "Tanjungsari"],
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