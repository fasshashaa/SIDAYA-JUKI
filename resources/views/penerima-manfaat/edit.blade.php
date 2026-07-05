@extends('layouts.app')

@section('content')

    <div class="mb-8">
        <br>
        <a href="{{ route('penerima-manfaat.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Penerima Manfaat</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui data kependudukan atau wilayah jika terdapat perubahan data master.</p>
    </div>

    <form action="{{ route('penerima-manfaat.update', $penerima->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700">Pilih Akun Pengguna *</label>
                <select name="user_id" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $penerima->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50" value="{{ old('nama_lengkap', $penerima->nama_lengkap) }}">
                @error('nama_lengkap') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Ibu Kandung *</label>
                <input type="text" name="nama_ibu_kandung" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50" value="{{ old('nama_ibu_kandung', $penerima->nama_ibu_kandung ?? '') }}">
                @error('nama_ibu_kandung') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">NIK *</label>
                <input type="text" name="nik" maxlength="16" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50" value="{{ old('nik', $penerima->nik) }}">
                @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Nomor Kartu Keluarga *</label>
                <input type="text" name="no_kk" maxlength="16" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50" value="{{ old('no_kk', $penerima->no_kk ?? '') }}">
                @error('no_kk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700">Nomor WhatsApp</label>
                <input type="text" name="no_wa" class="w-full mt-1 p-3 border rounded-xl bg-gray-50" value="{{ old('no_wa', $penerima->no_wa) }}">
                @error('no_wa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
                <select id="kecamatan_select" name="kecamatan" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
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
                <label class="block text-sm font-semibold text-gray-700">Desa / Kelurahan *</label>
                <select id="desa_select" name="desa" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">
                    <option value="">Pilih Kecamatan dahulu</option>
                </select>
                @error('desa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700">Alamat Detail (RT/RW, Jalan, Dusun) *</label>
            <textarea name="alamat_detail" rows="3" required class="w-full mt-1 p-3 border rounded-xl bg-gray-50">{{ old('alamat_detail', $penerima->alamat_detail ?? '') }}</textarea>
            @error('alamat_detail') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mt-6">
            <label class="block text-sm font-bold text-blue-900 mb-2">Status Verifikasi *</label>
            <select name="status_verifikasi" class="w-full rounded-xl border-blue-200 bg-white text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                <option value="pending" {{ old('status_verifikasi', $penerima->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ old('status_verifikasi', $penerima->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ old('status_verifikasi', $penerima->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <p class="text-xs text-blue-600 mt-2">Pastikan data sudah diperiksa sebelum mengubah status.</p>
        </div>

        <div class="sticky bottom-4 z-10 mt-6">
            <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Perbarui Data
                </button>
                <a href="{{ route('penerima-manfaat.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                    Batal
                </a>
            </div>
        </div>
    </form>

    <!-- Script AJAX Wilayah -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kecamatanSelect = document.getElementById('kecamatan_select');
            const desaSelect = document.getElementById('desa_select');
            const dbKecamatan = "{{ $penerima->kecamatan ?? '' }}";
            const dbDesa = "{{ $penerima->desa ?? '' }}";

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