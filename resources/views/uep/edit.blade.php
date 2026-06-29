<x-app-layout>
    <div class="mb-8">
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1 mb-2">
            ← Kembali ke Daftar UEP
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Data UEP</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-4xl"
         x-data="{ 
            kecamatan: '{{ old('kecamatan_usaha', $uep->kecamatan_usaha) }}', 
            desaTerpilih: '{{ old('desa_kelurahan_usaha', $uep->desa_kelurahan_usaha) }}',
            desas: [], 
            loading: false,
            async fetchDesa() {
                if (!this.kecamatan) { this.desas = []; return; }
                this.loading = true;
                try {
                    const response = await fetch(`/get-desa/${encodeURIComponent(this.kecamatan)}`);
                    this.desas = await response.json();
                } catch (err) { this.desas = []; }
                finally { this.loading = false; }
            }
         }" 
         x-init="$watch('kecamatan', () => fetchDesa()); fetchDesa()">

        <form action="{{ route('uep.update', $uep->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-gray-50 pb-2">I. Identitas Pemilik Usaha</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3" value="{{ old('nama_lengkap', $uep->nama_lengkap) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung *</label>
                        <input type="text" name="nama_ibu_kandung" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3" value="{{ old('nama_ibu_kandung', $uep->nama_ibu_kandung) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK *</label>
                        <input type="text" name="nik" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3" value="{{ old('nik', $uep->nik) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. Kartu Keluarga *</label>
                        <input type="text" name="no_kk" maxlength="16" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3" value="{{ old('no_kk', $uep->no_kk) }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. WhatsApp *</label>
                        <input type="text" name="no_operasional_wa" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3" value="{{ old('no_operasional_wa', $uep->no_operasional_wa) }}">
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
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan *</label>
                        <select name="kecamatan_usaha" x-model="kecamatan" @change="fetchDesa()" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach(['Cilacap Tengah', 'Cilacap Utara', 'Cilacap Selatan', 'Adipala', 'Majenang'] as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Desa / Kelurahan *</label>
                        <select name="desa_kelurahan_usaha" x-model="desaTerpilih" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 p-3">
                            <option value="">-- Pilih Desa --</option>
                            <template x-for="item in desas" :key="item">
                                <option :value="item" :selected="item == desaTerpilih" x-text="item"></option>
                            </template>
                        </select>
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
</x-app-layout>