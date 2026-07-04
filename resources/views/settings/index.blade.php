@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaturan Sistem</h1>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi hak akses dan pantau jejak digital aplikasi SIDAYA</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                🔒 Keamanan & Akses Kontrol (ISO 27001 - Kontrol A.8.5)
            </h3>
        </div>
        <div class="p-8">
            @php
                try {
                    $otpStatus = \Illuminate\Support\Facades\DB::table('settings')->where('key', 'otp_gateway_status')->value('value') ?? 'on';
                } catch (\Exception $e) {
                    $otpStatus = 'on';
                }
            @endphp
            <div class="max-w-2xl">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Kontrol Keamanan Gateway</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Gunakan fitur ini untuk mematikan intersep OTP secara sementara jika gateway WhatsApp Fonnte sedang mengalami kendala teknis.
                </p>
                <form action="{{ route('settings.toggle-otp') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex p-4 bg-gray-50 border rounded-2xl cursor-pointer select-none transition-all hover:bg-gray-100/70 {{ $otpStatus === 'on' ? 'border-blue-500 ring-2 ring-blue-500/10' : 'border-gray-200' }}">
                            <input type="radio" name="otp_status" value="on" class="sr-only" {{ $otpStatus === 'on' ? 'checked' : '' }} onchange="this.form.submit()">
                            <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center mr-3 mt-0.5 {{ $otpStatus === 'on' ? 'border-blue-600 bg-blue-600' : 'border-gray-300' }}">
                                @if($otpStatus === 'on') <div class="w-2 h-2 bg-white rounded-full"></div> @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900">MFA / OTP Aktif</span>
                                <span class="text-xs text-gray-500 mt-0.5">Wajib OTP untuk Admin & Super Admin</span>
                            </div>
                        </label>
                        <label class="relative flex p-4 bg-gray-50 border rounded-2xl cursor-pointer select-none transition-all hover:bg-gray-100/70 {{ $otpStatus === 'off' ? 'border-red-500 ring-2 ring-red-500/10' : 'border-gray-200' }}">
                            <input type="radio" name="otp_status" value="off" class="sr-only" {{ $otpStatus === 'off' ? 'checked' : '' }} onchange="this.form.submit()">
                            <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center mr-3 mt-0.5 {{ $otpStatus === 'off' ? 'border-red-600 bg-red-600' : 'border-gray-300' }}">
                                @if($otpStatus === 'off') <div class="w-2 h-2 bg-white rounded-full"></div> @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-red-600">Bypass OTP (Darurat)</span>
                                <span class="text-xs text-gray-500 mt-0.5">Nonaktifkan OTP sementara waktu</span>
                            </div>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="flex items-center space-x-2 mb-4 relative inline-block text-left">
        <div class="relative inline-block text-left" id="dropdownContainer">
            <button type="button" 
                    onclick="toggleDropdown()"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none cursor-pointer gap-2 transition-all">
                🖨️ Cetak Dokumen Bukti Log ISO 27001 <i class="fas fa-chevron-down text-xs text-gray-400 ml-1"></i>
            </button>
            
            <div id="auditDropdown" class="hidden origin-top-left absolute left-0 mt-2 w-72 rounded-2xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50 animate-in fade-in slide-in-from-top-2 duration-100">
                <div class="py-1">
                    <button type="button" 
                            onclick="openSecurePdf('{{ route('audit-logs.export-pdf') }}')" 
                            class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2 cursor-pointer">
                        📄 Log Utama Sistem (All Events)
                    </button>
                </div>
                <div class="py-1">
                    <button type="button" 
                            onclick="openSecurePdf('{{ route('penerima-manfaat.audit-log.export') }}')" 
                            class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2 cursor-pointer">
                        👥 Evidence Log: Penerima Manfaat
                    </button>
                    <button type="button" 
                            onclick="openSecurePdf('{{ route('uep.audit-log.export') }}')" 
                            class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50/50 hover:text-indigo-700 flex items-center gap-2 cursor-pointer font-medium">
                        💼 Evidence Log: Kelolaan UEP
                    </button>
                    <button type="button" 
                            onclick="openSecurePdf('{{ route('kube.audit-log.export') }}')" 
                            class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50/50 hover:text-emerald-700 flex items-center gap-2 cursor-pointer font-medium">
                        🏢 Evidence Log: Kelompok KUBE
                    </button>
                </div>
            </div>
        </div>
        
        <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
            50 Aktivitas Terakhir
        </span>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                📋 Viewer Audit Trail Logs (ISO 27001 - KONTROL A.8.15)
            </h3>
            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">50 Aktivitas Terakhir</span>
        </div>
        
        <div class="p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="p-4 pl-6">Waktu & IP</th>
                        <th class="p-4">Pengguna</th>
                        <th class="p-4">Aksi / Event</th>
                        <th class="p-4">Modul & ID</th>
                        <th class="p-4 text-right pr-6">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                    @forelse($auditLogs as $log)
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <td class="p-4 pl-6">
                                <div class="font-medium text-gray-900">{{ $log->created_at->format('d M Y H:i:s') }} WIB</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $log->ip_address }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-gray-800">{{ $log->user->name ?? 'Sistem / Anonim' }}</div>
                                <div class="text-xs text-gray-500">{{ $log->user->role ?? '-' }}</div>
                            </td>
                            <td class="p-4">
                                @if(str_contains($log->activity, 'CREATE'))
                                    <span class="inline-flex px-2.5 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-bold border border-green-200">CREATE</span>
                                @elseif(str_contains($log->activity, 'UPDATE'))
                                    <span class="inline-flex px-2.5 py-1 bg-amber-50 text-amber-700 rounded-lg text-xs font-bold border border-amber-200">UPDATE</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-bold border border-red-200">DELETE</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="text-gray-700 font-medium">{{ class_basename($log->model_type) }}</div>
                                <div class="text-xs text-gray-400">ID Data: #{{ $log->model_id }}</div>
                            </td>
                            <td class="p-4 text-right pr-6">
                               <button type="button" 
                                    onclick="showLogDetail(
                                        '{{ $log->id }}', 
                                        {{ $log->before_changes ? json_encode($log->before_changes) : 'null' }}, 
                                        {{ $log->after_changes ? json_encode($log->after_changes) : 'null' }}
                                    )"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                 Inspeksi Data
                            </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 text-sm">Belum ada jejak audit log yang terekam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="logModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[85vh] flex flex-col shadow-xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Detail Perubahan Manifest Data</h3>
            <button onclick="closeLogModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold p-2 cursor-pointer">&times;</button>
        </div>
        <div class="p-6 overflow-y-auto grid grid-cols-1 md:grid-cols-2 gap-6 text-xs font-mono">
            <div>
                <h4 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wider font-sans">⏮ Data Sebelum (Original)</h4>
                <pre id="jsonBefore" class="p-4 bg-gray-900 text-gray-100 rounded-2xl overflow-x-auto max-h-80 shadow-inner"></pre>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wider font-sans">⏭ Data Sesudah (Mutasi)</h4>
                <pre id="jsonAfter" class="p-4 bg-gray-900 text-gray-100 rounded-2xl overflow-x-auto max-h-80 shadow-inner"></pre>
            </div>
        </div>
    </div>
</div>

<div id="pdfModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-5xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div class="flex items-center space-x-2">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <h3 class="text-sm font-bold text-gray-700 font-mono tracking-wide">
                    🔒 SECURE DOCUMENT PREVIEW (ISO 27001 - COMPLIANCE)
                </h3>
            </div>
            <button onclick="closePdfModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold p-2 cursor-pointer">&times;</button>
        </div>
        
        <div class="bg-gray-800 p-2 flex-1">
            <iframe id="pdfFrame" src="" class="w-full h-[70vh] rounded-2xl border-none shadow-inner"></iframe>
        </div>

        <div class="bg-gray-50 px-6 py-3 flex justify-between items-center border-t border-gray-100 text-xs text-gray-400 font-mono">
            <span>Status Sesi: Terenkripsi Temporal</span>
            <button type="button" onclick="closePdfModal()" class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none cursor-pointer">
                Tutup Enklave Dokumen
            </button>
        </div>
    </div>
</div>

<script>
    // --- JAVASCRIPT: DROPDOWN MANAGER ---
    function toggleDropdown() {
        const dropdown = document.getElementById('auditDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Menutup dropdown otomatis jika pengguna mengklik area luar menu
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('auditDropdown');
        const container = document.getElementById('dropdownContainer');
        if (container && !container.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // --- JAVASCRIPT: LOG DETAIL INSPEKSI ---
    function showLogDetail(id, before, after) {
        const sensitiveFields = ['password', 'remember_token', 'token', 'secret', 'password_hash'];

        const filterSensitive = (obj) => {
            if (!obj) return null;
            let cleanObj = { ...obj };
            for (let key in cleanObj) {
                if (sensitiveFields.includes(key.toLowerCase())) {
                    cleanObj[key] = '******** [DIAMANKAN SISTEM]';
                }
            }
            return cleanObj;
        };

        const cleanBefore = filterSensitive(before);
        const cleanAfter = filterSensitive(after);

        const beforePre = document.getElementById('jsonBefore');
        const afterPre = document.getElementById('jsonAfter');

        beforePre.innerHTML = '';
        afterPre.innerHTML = '';

        if (!cleanBefore) {
            beforePre.innerHTML = '<span class="text-gray-500">// Tidak ada data awal\n// (Aksi CREATE / Data Baru Masuk)</span>';
        } else {
            let beforeLines = JSON.stringify(cleanBefore, null, 4).split('\n');
            beforeLines.forEach(line => {
                beforePre.innerHTML += `<div>${line}</div>`;
            });
        }

        if (!cleanAfter) {
            afterPre.innerHTML = '<span class="text-red-400">// Data dihapus total\n// (Aksi DELETE / Manifest Dimusnahkan)</span>';
        } else {
            let afterLines = JSON.stringify(cleanAfter, null, 4).split('\n');
            afterLines.forEach(line => {
                let isChanged = false;
                
                if (cleanBefore) {
                    let match = line.match(/"([^"]+)":/);
                    if (match) {
                        let key = match[1];
                        if (JSON.stringify(cleanBefore[key]) !== JSON.stringify(cleanAfter[key])) {
                            isChanged = true;
                        }
                    }
                }

                if (isChanged) {
                    afterPre.innerHTML += `<div class="bg-emerald-950/70 text-emerald-400 font-bold px-1 border-l-2 border-emerald-500">⚡ ${line}</div>`;
                } else {
                    afterPre.innerHTML += `<div>  ${line}</div>`;
                }
            });
        }

        document.getElementById('logModal').classList.remove('hidden');
    }

    function closeLogModal() {
        document.getElementById('logModal').classList.add('hidden');
    }

    // --- JAVASCRIPT: POPUP SECURE PDF PREVIEW ---
    function openSecurePdf(url) {
        // Otomatis sembunyikan dropdown saat dokumen dibuka
        document.getElementById('auditDropdown').classList.add('hidden');

        const frame = document.getElementById('pdfFrame');
        frame.src = url; // Inject route PDF secara dinamis
        
        document.getElementById('pdfModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Lock main scrollbar
    }

    function closePdfModal() {
        document.getElementById('pdfModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Unlock main scrollbar
        
        // Purge memory: Kosongkan source iframe agar PDF tidak mengendap di cache DOM browser
        document.getElementById('pdfFrame').src = '';
    }
</script>
@endsection