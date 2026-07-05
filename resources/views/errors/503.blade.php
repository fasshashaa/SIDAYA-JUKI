@extends('errors::minimal')

@section('title', 'Layanan Tidak Tersedia')
@section('code', '503')

@section('message')
    @php
        $maintenanceFile = storage_path('framework/custom_maintenance.json');
        $message = 'Sistem sedang dalam pemeliharaan. Mohon coba beberapa saat lagi.';
        
        if (file_exists($maintenanceFile)) {
            $data = json_decode(file_get_contents($maintenanceFile), true);
            $message = $data['message'] ?? $message;
        }
    @endphp
    {{ $message }}
@endsection