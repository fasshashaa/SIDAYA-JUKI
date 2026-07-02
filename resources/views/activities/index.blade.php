@extends('layouts.app')

@section('content')
  <div class="mb-8">
        <br>
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Aktivitas Terbaru</h1>
        <p class="text-sm text-gray-500 mt-1">SIDAYA - Dinas Sosial PPPA Kabupaten Cilacap.</p>
    </div>
    <div class="bg-white rounded-2xl border p-6">
        @foreach($activities as $activity)
            <div class="border-b py-4">
                <p class="font-medium text-slate-800">{{ $activity->description }}</p>
                <p class="text-xs text-slate-500">{{ $activity->created_at->format('d M Y, H:i') }} | Oleh: {{ $activity->causer_name }}</p>
            </div>
        @endforeach
        
        <div class="mt-4">
            {{ $activities->links() }} {{-- Untuk tombol pagination --}}
        </div>
    </div>
</div>
@endsection