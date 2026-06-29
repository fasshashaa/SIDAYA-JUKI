<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        <aside class="w-64 bg-white shadow-md hidden md:block">
            <!-- (Gunakan struktur sidebar yang sama) -->
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelolaan UEP</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar Usaha Ekonomi Produktif (UEP) binaan</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm text-sm text-gray-600 font-medium">
                    📅 {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Usaha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($daftarUep as $uep)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $uep->nama_usaha }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $uep->pemilik }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $uep->kategori }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Berjalan</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data UEP.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>