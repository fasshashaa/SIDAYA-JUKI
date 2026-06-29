<x-app-layout>
    <div class="min-h-screen bg-[#FFF5EC] p-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-xs text-gray-400 font-medium mb-1">
                Produk UMKM &gt; <span class="text-gray-600">Create</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Create Produk Umkm</h1>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- LAYOUT UTAMA GRID 2 KOLOM -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <!-- KOLOM KIRI: INFORMASI PRODUK UMKM (LEBAR 2/3) -->
                    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-6 border border-orange-50/60 space-y-4">
                        <div>
                            <h2 class="text-md font-bold text-gray-800 mb-4">Informasi Produk UMKM</h2>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Nama Usaha (UEP) <span class="text-red-500">*</span></label>
                            <select name="uep_id" class="mt-1 block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                                <option value="">Select an option</option>
                                {{-- Loop data UEP dari controller --}}
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_produk" class="mt-1 block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Kategori <span class="text-red-500">*</span></label>
                            <div class="flex mt-1 space-x-2">
                                <select name="kategori_id" class="block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                                    <option value="">Select an option</option>
                                </select>
                                <button type="button" class="bg-gray-50 border border-gray-200 hover:bg-gray-100 px-3 rounded-xl text-gray-500 font-bold">+</button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Deskripsi Produk <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi_produk" rows="4" class="mt-1 block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required></textarea>
                        </div>

                        <!-- DROPZONE FOTO PRODUK -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Foto Produk <span class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-6 text-center cursor-pointer hover:bg-gray-100/50 transition relative">
                                <input type="file" name="foto" class="absolute inset-0 opacity-0 cursor-pointer" required>
                                <p class="text-sm text-gray-500">
                                    Drag & Drop your files or <span class="text-orange-500 font-semibold underline">Browse</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: INFORMASI PENJUALAN (LEBAR 1/3) -->
                    <div class="bg-white rounded-3xl shadow-sm p-6 border border-orange-50/60 space-y-4">
                        <div>
                            <h2 class="text-md font-bold text-gray-800 mb-4">Informasi Penjualan</h2>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Harga Jual <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga_jual" class="block w-full pl-9 rounded-xl bg-gray-50 border-gray-200 text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stok" value="0" class="mt-1 block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="whatsapp" class="mt-1 block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Status Publikasi <span class="text-red-500">*</span></label>
                            <select name="status_publikasi" class="mt-1 block w-full rounded-xl bg-gray-50 border-gray-200 shadow-sm text-sm p-2.5 focus:ring-orange-400 focus:border-orange-400" required>
                                <option value="Ditampilkan">Ditampilkan</option>
                                <option value="Arsip">Disembunyikan</option>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- TOMBOL ACTION SESUAI DESIGN -->
                <div class="mt-6 flex space-x-2">
                    <button type="submit" class="bg-[#C25121] hover:bg-orange-800 text-white px-6 py-2 rounded-xl text-sm font-semibold shadow-sm transition">
                        Create
                    </button>
                    <a href="{{ route('produk-umkm.index') }}" class="bg-white border border-gray-200 text-gray-700 px-6 py-2 rounded-xl text-sm font-semibold shadow-sm hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>