@extends('layouts.app')
@section('content')

    <div class="mb-8">
        <br>
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Usaha Ekonomi Produktif</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui data Usaha Ekonomi Produktif.</p>
    </div>

        <form action="{{ route('uep.update', $uep->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md"
             x-data="{
    selectedPm: {
        nama_lengkap: '{{ $uep->nama_lengkap }}',
        nama_ibu_kandung: '{{ $uep->nama_ibu_kandung }}',
        nik: '{{ $uep->nik }}',
        no_kk: '{{ $uep->no_kk }}',
        no_wa: '{{ $uep->no_wa }}'
    },
    pmList: {{ $penerimaManfaats->toJson() }},
    statusVerifikasi: '{{ old('status_verifikasi', $uep->status_verifikasi) }}',
    updateFields(id) {
        let data = this.pmList.find(pm => pm.id == id);
        if(data) {
            this.selectedPm = data;
        }
    }
}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Pilih Penerima Manfaat *</label>
                    <select name="penerima_manfaat_id" @change="updateFields($event.target.value)" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        <option value="">-- Pilih Nama Penerima --</option>
                        @foreach($penerimaManfaats as $pm)
                            <option value="{{ $pm->id }}" {{ $uep->penerima_manfaat_id == $pm->id ? 'selected' : '' }}>
                                {{ $pm->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" x-model="selectedPm.nama_lengkap" readonly class="w-full mt-1 p-3 border rounded-xl bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Ibu Kandung</label>
                    <input type="text" name="nama_ibu_kandung" x-model="selectedPm.nama_ibu_kandung" readonly class="w-full mt-1 p-3 border rounded-xl bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">NIK</label>
                    <input type="text" name="nik" x-model="selectedPm.nik" readonly class="w-full mt-1 p-3 border rounded-xl bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">No. KK</label>
                    <input type="text" name="no_kk" x-model="selectedPm.no_kk" readonly class="w-full mt-1 p-3 border rounded-xl bg-gray-100">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">No. WhatsApp</label>
                    <input type="text" name="no_wa" x-model="selectedPm.no_wa" readonly class="w-full mt-1 p-3 border rounded-xl bg-gray-100">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Nama Usaha *</label>
                    <input type="text" name="nama_usaha" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50" value="{{ old('nama_usaha', $uep->nama_usaha) }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Kategori Produk *</label>
                    <select name="kategori_produk" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        @foreach(['Kuliner / Makanan Olahan', 'Kerajinan / Craft', 'Fashion / Konveksi', 'Pertanian / Peternakan', 'Jasa / Service'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori_produk', $uep->kategori_produk) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Status Perkembangan *</label>
                    <select name="status_perkembangan" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        <option value="rintisan" {{ old('status_perkembangan', $uep->status_perkembangan) == 'rintisan' ? 'selected' : '' }}>Rintisan</option>
                        <option value="berkembang" {{ old('status_perkembangan', $uep->status_perkembangan) == 'berkembang' ? 'selected' : '' }}>Berkembang</option>
                        <option value="mandiri" {{ old('status_perkembangan', $uep->status_perkembangan) == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Kecamatan *</label>
                    @php
                        $kecamatanList = [
                            'Cilacap Tengah', 'Cilacap Utara', 'Cilacap Selatan', 'Adipala', 'Majenang',
                            'Cimanggu', 'Bantarsari', 'Cipari', 'Kedungreja', 'Kesugihan', 'Binangun',
                            'Nusawungu', 'Kroya', 'Maos', 'Jeruklegi', 'Kawunganten', 'Gandrungmangu',
                            'Sidareja', 'Karangpucung', 'Wanareja', 'Dayeuhluhur', 'Sampang', 'Patimuan', 'Kampung Laut'
                        ];
                    @endphp
                    <select id="kecamatan_select" name="kecamatan_usaha" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec }}" {{ (old('kecamatan_usaha', $uep->kecamatan_usaha) == $kec) ? 'selected' : '' }}>
                                {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Desa -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Desa / Kelurahan *</label>
                    <select id="desa_select" name="desa_kelurahan_usaha" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        <option value="">Pilih Kecamatan dahulu</option>
                    </select>
                    @error('desa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Tahun Realisasi *</label>
                    <select name="tahun_realisasi" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        @for ($t = date('Y'); $t >= 2020; $t--)
                            <option value="{{ $t }}" {{ old('tahun_realisasi', $uep->tahun_realisasi) == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Sumber Anggaran *</label>
                    <select name="sumber_anggaran" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                        @foreach(['APBN', 'APBD', 'CSR', 'Lainnya'] as $sumber)
                            <option value="{{ $sumber }}" {{ old('sumber_anggaran', $uep->sumber_anggaran) == $sumber ? 'selected' : '' }}>{{ $sumber }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap *</label>
                <textarea name="alamat_lengkap" rows="3" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">{{ old('alamat_lengkap', $uep->alamat_lengkap) }}</textarea>
            </div>

            
{{-- Ganti <select name="status_verifikasi"> yang sudah ada dengan versi ini (tambahkan x-model) --}}
<div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mt-6">
    <label class="block text-sm font-bold text-blue-900 mb-2">Status Verifikasi *</label>
    <select name="status_verifikasi" x-model="statusVerifikasi" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="pending" {{ old('status_verifikasi', $uep->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="disetujui" {{ old('status_verifikasi', $uep->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="ditolak" {{ old('status_verifikasi', $uep->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
 
    {{-- Muncul otomatis hanya saat status = ditolak --}}
    <div x-show="statusVerifikasi === 'ditolak'" x-cloak x-transition class="mt-4">
        <label class="block text-sm font-bold text-rose-700 mb-2">Alasan Penolakan *</label>
        <textarea name="catatan_penolakan" rows="3"
                  x-bind:required="statusVerifikasi === 'ditolak'"
                  class="w-full rounded-xl border-rose-200 bg-white text-sm p-3 focus:border-rose-500 focus:ring-rose-500"
                  placeholder="Jelaskan alasan penolakan agar pemohon bisa memperbaiki data (contoh: NIK tidak sesuai KTP, foto usaha tidak jelas, dsb.)">{{ old('catatan_penolakan', $uep->catatan_penolakan) }}</textarea>
        @error('catatan_penolakan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
    </div>
</div>

            <div class="bg-orange-50/50 p-6 rounded-2xl border border-orange-100 mt-6">
                <label class="block text-sm font-bold text-orange-900 mb-2">Status Usaha *</label>
                <select name="status_usaha" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                    <option value="Aktif" {{ old('status_usaha', $uep->status_usaha) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ old('status_usaha', $uep->status_usaha) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Tutup Sementara" {{ old('status_usaha', $uep->status_usaha) == 'Tutup Sementara' ? 'selected' : '' }}>Tutup Sementara</option>
                </select>
                <p class="text-xs text-orange-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status menjadi Disetujui/Ditolak.</p>
            </div>

          <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Perbarui Data
                    </button>
                    <a href="{{ route('uep.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    {{-- <span class="ml-auto text-xs text-gray-400 hidden sm:flex items-center gap-1.5">
                        <span class="text-rose-500">*</span> wajib diisi
                    </span> --}}
                </div>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const kecamatanSelect = document.getElementById('kecamatan_select');
        const desaSelect = document.getElementById('desa_select');
        const dbKecamatan = "{{ $uep->kecamatan_usaha ?? '' }}";
        const dbDesa = "{{ $uep->desa_kelurahan_usaha ?? '' }}";
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

        if (dbKecamatan) {
            updateDesa(dbKecamatan, dbDesa);
        }

        kecamatanSelect.addEventListener('change', function() {
            updateDesa(this.value);
        });
    });
    </script>
@endsection