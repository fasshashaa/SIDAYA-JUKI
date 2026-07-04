@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaturan Sistem</h1>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi hak akses aplikasi SIDAYA</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Keamanan & Akses Kontrol (ISO 27001)
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
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Kontrol Keamanan Gateway (Kontrol A.8.5)</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Gunakan fitur ini untuk mematikan intersep OTP secara sementara jika gateway WhatsApp Fonnte sedang mengalami kendala teknis atau pemeliharaan server pihak ketiga.
                </p>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 rounded-2xl border border-green-100 flex items-center gap-3 text-sm text-green-700 font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('settings.toggle-otp') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex p-4 bg-gray-50 border rounded-2xl cursor-pointer select-none transition-all hover:bg-gray-100/70 {{ $otpStatus === 'on' ? 'border-blue-500 ring-2 ring-blue-500/10' : 'border-gray-200' }}">
                            <input type="radio" name="otp_status" value="on" class="sr-only" {{ $otpStatus === 'on' ? 'checked' : '' }} onchange="this.form.submit()">
                            
                            <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center mr-3 mt-0.5 {{ $otpStatus === 'on' ? 'border-blue-600 bg-blue-600' : 'border-gray-300' }}">
                                @if($otpStatus === 'on')
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900">MFA / OTP Aktif</span>
                                <span class="text-xs text-gray-500 mt-0.5">Wajib OTP untuk Admin & Super Admin (Rekomendasi Aman)</span>
                            </div>
                        </label>

                        <label class="relative flex p-4 bg-gray-50 border rounded-2xl cursor-pointer select-none transition-all hover:bg-gray-100/70 {{ $otpStatus === 'off' ? 'border-red-500 ring-2 ring-red-500/10' : 'border-gray-200' }}">
                            <input type="radio" name="otp_status" value="off" class="sr-only" {{ $otpStatus === 'off' ? 'checked' : '' }} onchange="this.form.submit()">
                            
                            <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center mr-3 mt-0.5 {{ $otpStatus === 'off' ? 'border-red-600 bg-red-600' : 'border-gray-300' }}">
                                @if($otpStatus === 'off')
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900 text-red-600">Bypass OTP (Darurat)</span>
                                <span class="text-xs text-gray-500 mt-0.5">Nonaktifkan OTP sementara waktu demi kelancaran akses darurat</span>
                            </div>
                        </label>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection