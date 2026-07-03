@extends('layouts.app')
@section('content')

    {{-- ================= HEADER ================= --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-5">
        <div>
            <br>
            {{-- <p class="text-xs font-semibold text-indigo-600 tracking-wide uppercase mb-1.5">Dinsos PPPA &middot; Kabupaten Cilacap</p> --}}
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Kelompok KUBE</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar Kelompok Usaha Bersama binaan Dinsos PPPA Cilacap.</p>
        </div>
       <div class="flex items-center gap-2 mb-4">
   <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Ekspor
            </button>
            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-50 animate-in fade-in zoom-in duration-200">
                <a href="{{ route('kube.export.excel') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Excel</a>
                <a href="{{ route('kube.export.pdf') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">PDF</a>
            </div>
        </div>

        {{-- Tombol Import (File Input) --}}
        <form action="{{ route('kube.import') }}" method="POST" enctype="multipart/form-data" class="relative">
            @csrf
            <input type="file" name="file" onchange="this.form.submit()" class="hidden" id="file-upload">
            <label for="file-upload" class="cursor-pointer inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </label>
        </form>
     @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('kube.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm shadow-indigo-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kelompok Baru
            </a>
             @endif
        </div>
    </div>

    {{-- ================= SUCCESS ALERT ================= --}}
    {{-- @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium rounded-2xl flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif --}}

    {{-- ================= QUICK STATS ROW ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Anggota</p>
                <p class="text-xl font-bold text-slate-900">{{ $kubeStats['total_anggota'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Disetujui</p>
                <p class="text-xl font-bold text-slate-900">{{ $kubeStats['disetujui'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Pending</p>
                <p class="text-xl font-bold text-slate-900">{{ $kubeStats['pending'] }}</p>
            </div>
        </div>
    </div>

    {{-- ================= TABLE CARD ================= --}}
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden"
         x-data="kubeSearch()" x-init="load()">

        {{-- Toolbar --}}
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="relative w-full sm:max-w-xs">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                <input type="text" x-model="search" @input.debounce.400ms="load(1)"
                       placeholder="Cari nama kelompok atau ketua..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <select x-model="status" @change="load(1)"
                        class="text-xs font-semibold text-slate-500 bg-slate-50 hover:bg-slate-100 px-3.5 py-2.5 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-colors cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <span x-show="loading" x-cloak class="text-xs text-slate-400">Memuat...</span>
                <span x-show="!loading" x-cloak class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl whitespace-nowrap" x-text="total + ' kelompok'"></span>
            </div>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wide">
                        <th class="p-4 pl-6 font-semibold">Nama KUBE</th>
                        <th class="p-4 font-semibold">Ketua KUBE</th>
                        <th class="p-4 font-semibold text-center">Anggota</th>
                        <th class="p-4 font-semibold">Wilayah Usaha</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700" x-ref="tbody">
                    {{-- Baris tabel diisi otomatis oleh JavaScript (kubeSearch) --}}
                    <tr>
                        <td colspan="6" class="p-14 text-center text-slate-400 text-sm">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination sederhana (prev/next) --}}
        <div class="p-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between" x-show="lastPage > 1" x-cloak>
            <button type="button" @click="load(currentPage - 1)" :disabled="currentPage <= 1"
                    class="text-xs font-semibold px-3 py-2 rounded-lg bg-white border border-slate-200 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition-colors">
                &larr; Sebelumnya
            </button>
            <span class="text-xs text-slate-400">Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span></span>
            <button type="button" @click="load(currentPage + 1)" :disabled="currentPage >= lastPage"
                    class="text-xs font-semibold px-3 py-2 rounded-lg bg-white border border-slate-200 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition-colors">
                Berikutnya &rarr;
            </button>
        </div>
    </div>

    <script>
    function kubeSearch() {
        return {
            search: '{{ request('search') }}',
            status: '{{ request('status') }}',
            loading: false,
            total: {{ $kubes->total() }},
            currentPage: 1,
            lastPage: 1,
            isSuperAdmin: @json(auth()->user()->role === 'super_admin'),
            baseUrl: '{{ route('kube.index') }}',
            csrfToken: '{{ csrf_token() }}',

            routeShow(id)    { return '{{ route('kube.show', ':id') }}'.replace(':id', id); },
            routeEdit(id)    { return '{{ route('kube.edit', ':id') }}'.replace(':id', id); },
            routeDestroy(id) { return '{{ route('kube.destroy', ':id') }}'.replace(':id', id); },

            load(page = 1) {
                this.loading = true;
                const url = new URL(this.baseUrl);
                if (this.search) url.searchParams.set('search', this.search); else url.searchParams.delete('search');
                if (this.status) url.searchParams.set('status', this.status); else url.searchParams.delete('status');
                url.searchParams.set('page', page);

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(json => {
                        this.total = json.total;
                        this.currentPage = json.current_page;
                        this.lastPage = json.last_page;
                        this.renderRows(json.data);
                        window.history.replaceState({}, '', url.toString());
                    })
                    .catch(() => {
                        this.$refs.tbody.innerHTML = `
                            <tr><td colspan="6" class="p-14 text-center text-rose-400 text-sm">Gagal memuat data. Silakan coba lagi.</td></tr>`;
                    })
                    .finally(() => { this.loading = false; });
            },

            initials(nama) {
                return String(nama || '').slice(0, 2).toUpperCase();
            },
            escapeHtml(str) {
                if (str === null || str === undefined) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            },
            statusBadge(s) {
                if (s === 'disetujui') {
                    return `<span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                            </span>`;
                } else if (s === 'ditolak') {
                    return `<span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                            </span>`;
                }
                return `<span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                        </span>`;
            },

            renderRows(items) {
                if (!items.length) {
                    this.$refs.tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="p-14 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-600">Data tidak ditemukan</p>
                                        <p class="text-xs text-slate-400 mt-1">Coba kata kunci atau filter lain.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                    return;
                }

                this.$refs.tbody.innerHTML = items.map(kube => {
                    const namaKubeEsc = this.escapeHtml(kube.nama_kelompok_kube);
                    const desaEsc = this.escapeHtml(kube.desa_kube);
                    const kecEsc = this.escapeHtml(kube.kecamatan_kube);

                    const ketuaHtml = (kube.ketua && kube.ketua.nama_lengkap)
                        ? `<span class="text-slate-700">${this.escapeHtml(kube.ketua.nama_lengkap)}</span>`
                        : `<span class="text-rose-400 text-xs inline-flex items-center gap-1">
                             <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 19h14.14a1 1 0 00.86-1.5L12.86 5a1 1 0 00-1.72 0L4.07 17.5a1 1 0 00.86 1.5z"/></svg>
                             Belum ada ketua
                           </span>`;

                    const deleteHtml = this.isSuperAdmin ? `
                        <form id="delete-form-${kube.id}" action="${this.routeDestroy(kube.id)}" method="POST">
                            <input type="hidden" name="_token" value="${this.csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" onclick="confirmDelete(${kube.id})" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </form>` : '';

                    return `
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold shrink-0">${this.initials(kube.nama_kelompok_kube)}</div>
                                <span class="font-semibold text-slate-900">${namaKubeEsc}</span>
                            </div>
                        </td>
                        <td class="p-4">${ketuaHtml}</td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">${kube.jumlah_anggota}</span>
                        </td>
                        <td class="p-4">
                            <div class="text-slate-800 text-xs font-medium">${desaEsc}</div>
                            <div class="text-slate-400 text-[11px] mt-0.5">Kec. ${kecEsc}</div>
                        </td>
                        <td class="p-4">${this.statusBadge(kube.status_verifikasi)}</td>
                        <td class="p-4 pr-6 text-right relative">
                            <div x-data="{ open: false, isTop: false }" @click.away="open = false" class="relative inline-block text-left">
                                <button @click="open = !open; isTop = (window.innerHeight - $el.getBoundingClientRect().top) < 200" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 13a1 1 0 100-2 1 1 0 000 2zM12 6a1 1 0 100-2 1 1 0 000 2zM12 20a1 1 0 100-2 1 1 0 000 2z"/></svg>
                                </button>
                                <div x-show="open" x-cloak :class="isTop ? 'bottom-full mb-2' : 'top-full mt-2'" class="absolute right-0 z-[100] w-36 bg-white rounded-xl shadow-2xl border border-slate-100 py-1 transition-all">
                                    <a href="${this.routeShow(kube.id)}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </a>
                                    <a href="${this.routeEdit(kube.id)}" class="flex items-center gap-3 px-4 py-2 text-sm text-amber-600 hover:bg-amber-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Ubah
                                    </a>
                                    ${deleteHtml}
                                </div>
                            </div>
                        </td>
                    </tr>`;
                }).join('');
            }
        }
    }
    </script>

        <script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data Kelompok Usaha Bersama?',
        text: "Data akan dihapus permanen.",
        icon: 'warning',
        width: '300px', // Sedikit lebih ramping
        padding: '1.5rem', // Padding dikurangi agar tidak mepet
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#f1f5f9',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-3xl shadow-xl border border-gray-100',
            icon: 'mb-4', // Memberi jarak bawah pada ikon
            title: 'text-lg font-bold text-gray-800', // Ukuran title disesuaikan
            htmlContainer: 'text-xs text-gray-500 m-0', // Margin 0 agar tidak mepet
            actions: 'mt-6 w-full', // Memastikan area tombol punya ruang
            confirmButton: 'bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1',
            cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection