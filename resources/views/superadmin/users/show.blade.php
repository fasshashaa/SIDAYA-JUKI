@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pengguna</h2>
        
        <div class="space-y-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</label>
                <p class="text-lg text-gray-900">{{ $user->name }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase">Email</label>
                <p class="text-lg text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase">Role / Peran</label>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </span>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase">Akun Dibuat</label>
                <p class="text-gray-600">{{ $user->created_at->format('d F Y') }}</p>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <a href="{{ route('superadmin.users.index') }}" class="text-indigo-600 font-medium hover:underline">← Kembali ke daftar</a>
        </div>
    </div>
</div>
@endsection