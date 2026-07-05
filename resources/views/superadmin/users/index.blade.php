@extends('layouts.app')
@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
        <br>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Manajemen Pengguna</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola akun, peran, dan status pengguna sistem.</p>
    </div>

    <div class="flex items-center gap-2">
        {{-- Tombol Tambah --}}
        <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-md shadow-indigo-600/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah User
        </a>
    </div>
</div>

{{-- ============ STAT SUMMARY STRIP ============ --}}
@php
    $roleCounts = [
        'user'        => $users->where('role', 'user')->count(),
        'admin'       => $users->where('role', 'admin')->count(),
        'super_admin' => $users->where('role', 'super_admin')->count(),
    ];
    $statusCounts = [
        'aktif'    => $users->where('status', 'aktif')->count(),
        'nonaktif' => $users->where('status', '!=', 'aktif')->count(),
    ];
@endphp
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Pengguna</p>
            <p class="text-xl font-bold text-slate-900">{{ $users->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Admin</p>
            <p class="text-xl font-bold text-slate-900">{{ $roleCounts['admin'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Superadmin</p>
            <p class="text-xl font-bold text-slate-900">{{ $roleCounts['super_admin'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Aktif</p>
            <p class="text-xl font-bold text-slate-900">{{ $statusCounts['aktif'] }}</p>
        </div>
    </div>

</div>

{{-- ================= TABLE CARD ================= --}}
<div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden">

    {{-- Toolbar --}}
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative w-full sm:max-w-xs">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            <input type="text" id="user-search" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl whitespace-nowrap">{{ $users->count() }} pengguna</span>
        </div>
    </div>

    <div class="overflow-x-auto min-h-[400px]">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wide">
                    <th class="p-4 pl-6 font-semibold">Nama</th>
                    <th class="p-4 font-semibold">Email</th>
                    <th class="p-4 font-semibold">Role</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700" id="user-table-body">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/70 transition-colors" data-search="{{ Str::lower($user->name.' '.$user->email) }}">
                        <td class="p-4 pl-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ Str::of($user->name)->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                                </div>
                                <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-slate-500 text-xs">{{ $user->email }}</td>

      <td class="p-4 text-slate-500 text-xs">
    @switch($user->role)
        @case('super_admin')
            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full font-bold text-[10px]">Super Admin</span>
            @break
        @case('admin')
            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full font-bold text-[10px]">Admin</span>
            @break
        @case('user')
            <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full font-bold text-[10px]">Pengguna</span>
            @break
            @default 
             <span class="px-2 py-1 bg-cyan-100 text-cyan-700 rounded-full font-bold text-[10px]">Pelanggan</span>

    @endswitch
</td>

                        <td class="p-4">
                            @if($user->status == 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="p-4 relative">
                            <div x-data="{ open: false, dropUp: false }"
                                 x-on:click.away="open = false"
                                 class="relative inline-block text-left">

                                <button @click="open = !open; dropUp = (window.innerHeight - $el.getBoundingClientRect().top) < 200"
                                        class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 13a1 1 0 100-2 1 1 0 000 2zM12 6a1 1 0 100-2 1 1 0 000 2zM12 20a1 1 0 100-2 1 1 0 000 2z"/></svg>
                                </button>

                                <div x-show="open"
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'"
                                     class="absolute right-0 z-[100] w-40 bg-white rounded-xl shadow-xl shadow-slate-900/10 border border-slate-100 py-1.5">

                                    <a href="{{ route('superadmin.users.show', $user->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat 
                                    </a>

                                    <a href="{{ route('superadmin.users.edit', $user->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-amber-600 hover:bg-slate-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <div class="my-1 border-t border-slate-50"></div>

                                        <form id="delete-form-{{ $user->id }}" action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteUser({{ $user->id }})" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-slate-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-14 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-600">Belum ada data pengguna</p>
                                    <p class="text-xs text-slate-400 mt-1">Tambahkan pengguna baru untuk mulai mengelola akses.</p>
                                </div>
                                <a href="{{ route('superadmin.users.create') }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah User
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($users, 'links'))
        <div class="p-4 border-t border-slate-100 bg-slate-50/40">
            {{ $users->links() }}
        </div>
    @endif
</div>

<script>
function confirmDeleteUser(id) {
    Swal.fire({
        title: 'Hapus Data Pengguna ?',
        text: "Data akan dihapus permanen.",
        icon: 'warning',
        width: '300px',
        padding: '1.5rem',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#f1f5f9',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-3xl shadow-xl border border-gray-100',
            icon: 'mb-4',
            title: 'text-lg font-bold text-gray-800',
            htmlContainer: 'text-xs text-gray-500 m-0',
            actions: 'mt-6 w-full',
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

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('user-search');
    const rows = document.querySelectorAll('#user-table-body tr[data-search]');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            rows.forEach(row => {
                row.style.display = row.dataset.search.includes(keyword) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection