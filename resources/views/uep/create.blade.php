<x-app-layout>
    <div class="mb-8">
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1 mb-2">
            ← Kembali ke Daftar UEP
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Data UEP</h1>
        <p class="text-sm text-gray-500 mt-1">Daftarkan profil usaha ekonomi produktif mandiri atau turunan penerima manfaat.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-4xl"
     x-data="{ 
        kecamatan: '{{ old('kecamatan_usaha', '') }}', 
        desaTerpilih: '{{ old('desa_kelurahan_usaha', '') }}',
        desas: [], 
        loading: false,
        error: false, 
        
        async fetchDesa() {
            if (!this.kecamatan) { this.desas = []; return; }
            this.loading = true;
            this.error = false; 
            
            try {
                const response = await fetch(`/get-desa/${encodeURIComponent(this.kecamatan)}`);
                if (!response.ok) throw new Error();
                this.desas = await response.json();
            } catch (err) {
                this.error = true;
                this.desas = [];
            } finally {
                this.loading = false;
            }
        }
     }" 
     x-init="$watch('kecamatan', () => fetchDesa()); if(kecamatan) fetchDesa()">

        <form action="{{ route('uep.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">I. Identitas Pemilik Usaha</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP">
                        @error('nama_lengkap') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung *</label>
                        <input type="text" name="nama_ibu_kandung" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nama_ibu_kandung') }}">
                        @error('nama_ibu_kandung') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK Pemilik (16 Digit) *</label>
                        <input type="text" name="nik" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('nik') }}">
                        @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kartu Keluarga *</label>
                        <input type="text" name="no_kk" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('no_kk') }}">
                        @error('no_kk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. WhatsApp Operasional Usaha *</label>
                        <input type="text" name="no_operasional_wa" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-all" value="{{ old('no_operasional_wa') }}" placeholder="Contoh: 08XXXXXXXXX">
                        @error('no_operasional_wa') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
    <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan Lokasi Usaha *</label>
    <select name="kecamatan_usaha" x-model="kecamatan" @change="fetchDesa()" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500">
        <option value="">-- Pilih Kecamatan --</option>
        <option value="Cilacap Tengah">Cilacap Tengah</option>
        <option value="Cilacap Utara">Cilacap Utara</option>
        <option value="Cilacap Selatan">Cilacap Selatan</option>
        <option value="Adipala">Adipala</option>
        <option value="Majenang">Majenang</option>
        <option value="Cimanggu">Cimanggu</option>
        <option value="Bantarsari">Bantarsari</option>
        <option value="Kedungreja">Kedungreja</option>
        <option value="Kesugihan">Kesugihan</option>
        <option value="Binangun">Binangun</option>
        <option value="Nusawungu">Nusawungu</option>
        <option value="Kroya">Kroya</option>
        <option value="Maos">Maos</option>
        <option value="Jeruklegi">Jeruklegi</option>
        <option value="Kawunganten">Kawunganten</option>
        <option value="Gandrungmangu">Gandrungmangu</option>
        <option value="Sidareja">Sidareja</option>
        <option value="Karangpucung">Karangpucung</option>
        <option value="Wanareja">Wanareja</option>
        <option value="Dayeuhluhur">Dayeuhluhur</option>
        <option value="Sampang">Sampang</option>
        <option value="Cipari">Cipari</option>
        <option value="Patimuan">Patimuan</option>
        <option value="Kampung Laut">Kampung Laut</option>
    </select>
</div>
                    <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan Usaha *</label>
    <select name="desa_kelurahan_usaha" 
            x-model="desaTerpilih" 
            required 
            :disabled="loading || desas.length === 0" 
            class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-60">
        
        <option value="">-- Pilih Desa --</option>
        
        <template x-if="loading">
            <option value="">⏳ Memuat data...</option>
        </template>
        <template x-if="error">
            <option value="">❌ Gagal memuat data</option>
        </template>
        
        <template x-for="namaDesa in desas" :key="namaDesa">
            <option :value="namaDesa" 
                    :selected="namaDesa == desaTerpilih" 
                    x-text="namaDesa">
            </option>
        </template>
    </select>
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
</x-app-layout>