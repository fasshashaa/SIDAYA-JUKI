@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Backup Panel & Maintenance Mode</h1>
        <p class="text-sm text-gray-500 mt-1">ISO 27001 - Kontrol A.5.9 & A.8.14</p>
        <a href="{{ route('settings.index') }}" class="text-sm text-indigo-600 hover:underline mt-2 inline-flex items-center gap-1">
            &larr; Kembali ke Pengaturan Sistem
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm">
            {{ session('success') }}
            @if (session('bypass_url'))
                <br>Link bypass (simpan untuk akses saat maintenance): <code class="font-mono">{{ session('bypass_url') }}</code>
            @endif
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= MAINTENANCE MODE ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                🛠️ Maintenance Mode
            </h3>
        </div>
        <div class="p-8">
            <div class="max-w-2xl">
                <p class="text-sm text-gray-600 mb-6">
                    Status saat ini:
                    @if ($isDownForMaintenance)
                        <span class="inline-flex px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold border border-red-200 ml-1">
                            AKTIF (Sistem sedang down)
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200 ml-1">
                            NONAKTIF (Sistem online)
                        </span>
                    @endif
                </p>

                @if ($isDownForMaintenance)
                    <form action="{{ route('superadmin.system.maintenance.off') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-5 py-3 bg-green-600 text-white text-sm font-semibold rounded-2xl hover:bg-green-700 transition-all shadow-sm">
                            Nonaktifkan Maintenance Mode
                        </button>
                    </form>
                @else
                    <form action="{{ route('superadmin.system.maintenance.on') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pesan untuk pengguna (opsional)</label>
                            <input type="text" name="message"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                                placeholder="Sistem sedang dalam pemeliharaan.">
                        </div>
                        <button type="submit"
                            onclick="return confirm('Yakin ingin mengaktifkan Maintenance Mode? Semua pengguna tidak akan bisa mengakses sistem.')"
                            class="px-5 py-3 bg-red-600 text-white text-sm font-semibold rounded-2xl hover:bg-red-700 transition-all shadow-sm">
                            Aktifkan Maintenance Mode
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- ================= BACKUP PANEL ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                🗄️ Backup Panel
            </h3>
            <form action="{{ route('superadmin.system.backup.store') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-gray-900 text-white text-xs font-semibold rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    + Buat Backup Baru
                </button>
            </form>
        </div>

        <div class="p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="p-4 pl-6">Nama File</th>
                        <th class="p-4">Ukuran</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                    @forelse ($backups as $backup)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 pl-6 font-medium text-gray-800">{{ $backup['name'] }}</td>
                            <td class="p-4">{{ $backup['size'] }}</td>
                            <td class="p-4">{{ $backup['date'] }}</td>
                            <td class="p-4 pr-6 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('superadmin.system.backup.download', $backup['name']) }}"
                                    class="inline-flex px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium hover:bg-indigo-200 transition-all">
                                    Unduh
                                </a>
                                <form action="{{ route('superadmin.system.backup.delete', $backup['name']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Hapus backup ini?')"
                                        class="inline-flex px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-xs font-medium hover:bg-red-200 transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-400 text-sm">Belum ada backup.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection