<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIDAYA') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F8FAFC] text-gray-900">
        
        <header class="bg-white border-b border-gray-100 fixed top-0 left-0 right-0 h-16 z-30 flex items-center justify-between px-8 shadow-sm shadow-gray-500/5">
            <div class="flex items-center gap-3">
                <div class="bg-slate-900 p-2 rounded-xl text-white shadow-md shadow-slate-900/20">
                    <svg class="h-5 w-5" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M61.8548 14.6253L31.3548 0.135254L0.854797 14.6253L31.3548 29.1153L61.8548 14.6253Z" fill="currentColor"/>
                        <path opacity="0.8" d="M31.3548 29.1152V64.3953L61.8548 49.9053V14.6252L31.3548 29.1152Z" fill="currentColor"/>
                        <path opacity="0.9" d="M0.854797 14.6252V49.9053L31.3548 64.3953V29.1152L0.854797 14.6252Z" fill="currentColor"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-400 tracking-wide ml-3">Dashboard</span>
            </div>
            
            <div x-data="{ openProfil: false }" class="relative">
                <button @click="openProfil = !openProfil" class="text-sm font-semibold text-gray-700 flex items-center gap-2 bg-gray-50 hover:bg-gray-100 py-1.5 px-4 rounded-xl transition-all cursor-pointer focus:outline-none">
                    <span>{{ Auth::user()->name ?? 'Admin SIDAYA' }}</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': openProfil}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="openProfil" 
                     @click.away="openProfil = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-gray-500/10 z-50 py-1.5 overflow-hidden"
                     style="display: none;">
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                        👤 Kelola Profil
                    </a>

                    <hr class="border-gray-100 my-1">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50/50 transition-colors text-left">
                            🚪 Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="flex pt-16 min-h-screen">
            
            <aside class="w-64 bg-white border-r border-gray-100 fixed top-16 bottom-0 left-0 pt-8 px-4 z-20 shadow-sm shadow-gray-500/5">
                <div class="px-4 mb-8">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">MENU SIDAYA</h2>
                </div>
                
                <nav class="space-y-1.5">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-base">📊</span> Dashboard Utama
                    </a>

                    <a href="{{ route('penerima-manfaat.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('penerima-manfaat.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-base">👥</span> Penerima Manfaat
                    </a>

                    <a href="{{ route('uep.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('uep.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-base">🛍️</span> Kelolaan UEP
                    </a>

                    <a href="{{ route('kube.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('kube.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-base">🏢</span> Kelompok KUBE
                    </a>

                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('settings.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-400 hover:bg-gray-50' }}">
                            <span class="text-base">⚙️</span> Pengaturan Sistem
                        </a>
                    </div>
                </nav>
            </aside>

            <main class="flex-1 ml-64 p-10 bg-[#F4F6F9] min-h-[calc(100vh-64px)] overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

    </body>
</html>