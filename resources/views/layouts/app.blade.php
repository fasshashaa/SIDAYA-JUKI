<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIDAYA') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .sidebar-navy {
            background: linear-gradient(180deg, #0A1F38 0%, #0B2A4A 100%);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item { position: relative; color: rgba(255,255,255,0.55); transition: 0.2s; white-space: nowrap; overflow: hidden; }
        .nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-item.active { background: rgba(14,124,158,0.22); color: #5FD9E8; }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 8px; bottom: 8px; width: 3px;
            border-radius: 0 3px 3px 0;
            background: #5FD9E8;
            box-shadow: 0 0 10px rgba(95,217,232,0.6);
        }
        .nav-icon-wrap {
            width: 30px; height: 30px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.04); flex-shrink: 0;
        }
        .nav-item.active .nav-icon-wrap { background: rgba(95,217,232,0.15); }
        .sidebar-divider { height: 1px; background: rgba(255,255,255,0.08); }
        .main-content { transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .main-bg {
            background: radial-gradient(circle at 100% 0%, rgba(14,124,158,0.05), transparent 40%), #F4F7FA;
        }
        .avatar-chip {
            width: 30px; height: 30px; border-radius: 9px;
            background: linear-gradient(160deg, #0B2A4A, #0E7C9E);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 12px; flex-shrink: 0;
        }
        .dropdown-panel { box-shadow: 0 20px 45px -12px rgba(15,23,42,0.15); }
        [x-cloak] { display: none !important; }

        /* Scrollbar tipis untuk area menu sidebar */
        .sidebar-scroll { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.15) transparent; }
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.28); }
    </style>
</head>
<body class="font-sans antialiased bg-[#F4F7FA] text-slate-800" x-data="{ sidebarOpen: true }">

    <!-- Header -->
    <header class="main-content bg-white border-b border-slate-100 fixed top-0 right-0 h-16 z-20 flex items-center justify-between px-6"
             :class="sidebarOpen ? 'left-64' : 'left-[78px]'">
        <div></div>

        <div class="flex items-center gap-3">
            {{-- <button class="relative w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#0E7C9E] ring-2 ring-white"></span>
            </button> --}}

            <div class="w-px h-6 bg-slate-100"></div>

            <div x-data="{ openProfil: false }" class="relative">
                <button @click="openProfil = !openProfil" class="text-sm font-semibold text-slate-700 flex items-center gap-2.5 border border-transparent hover:border-slate-100 hover:bg-slate-50 py-1.5 px-2.5 rounded-xl transition-all cursor-pointer focus:outline-none">
                    <span class="avatar-chip">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                    <span class="hidden sm:inline">{{ Auth::user()->name ?? 'Admin SIDAYA' }}</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': openProfil}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="openProfil"
                     x-cloak
                     @click.away="openProfil = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="dropdown-panel absolute right-0 mt-2 w-52 bg-white border border-slate-100 rounded-2xl z-50 py-1.5 overflow-hidden">

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Kelola Profil
                    </a>

                    <hr class="border-slate-100 my-1">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-rose-500 hover:bg-rose-50/60 transition-colors text-left">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-[78px]'" class="sidebar-navy fixed top-0 bottom-0 left-0 z-30 shadow-xl flex flex-col">

            <!-- Tombol toggle buka/tutup, menempel di tepi kanan sidebar -->
            <button @click="sidebarOpen = !sidebarOpen"
                    class="absolute top-7 -right-3.5 w-7 h-7 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-500 hover:text-[#0E7C9E] hover:border-[#0E7C9E]/40 transition-colors z-30">
                <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="!sidebarOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>

            <div class="p-6 flex flex-col items-center border-b border-white/5 flex-shrink-0">
                <img src="{{ asset('img/Logo_sdy.png') }}" class="object-contain mb-3 transition-all duration-300" :class="sidebarOpen ? 'w-20 h-20' : 'w-10 h-10'">
                <h2 x-show="sidebarOpen" x-cloak class="text-white font-bold text-lg whitespace-nowrap">SIDAYA</h2>
                <p x-show="sidebarOpen" x-cloak class="text-white/40 text-xs font-medium uppercase tracking-widest whitespace-nowrap">Dashboard Admin</p>
            </div>
<nav class="sidebar-scroll p-4 space-y-1.5 flex-1 overflow-y-auto overflow-x-hidden">
    <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('dashboard') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
        <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg></span>
        <span x-show="sidebarOpen" x-cloak>Dashboard</span>
    </a>

    @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
        <div x-show="sidebarOpen" x-cloak class="mt-4 mb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Manajemen Data</div>
        
        <a href="{{ route('penerima-manfaat.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('penerima-manfaat.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
            <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></span>
            <span x-show="sidebarOpen" x-cloak>Penerima Manfaat</span>
        </a>

        <a href="{{ route('uep.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('uep.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
            <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></span>
            <span x-show="sidebarOpen" x-cloak>Kelolaan UEP</span>
        </a>

        <a href="{{ route('kube.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('kube.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
            <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 9h1"/><path d="M9 13h1"/><path d="M14 9h1"/><path d="M14 13h1"/></svg></span>
            <span x-show="sidebarOpen" x-cloak>Kelompok KUBE</span>
        </a>
       <a href="{{ route('produk.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('produk.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
    
    <span class="nav-icon-wrap">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 01-8 0"/>
        </svg>
    </span>
    
    <span x-show="sidebarOpen" x-cloak>Produk UMKM</span>
</a>
    @endif

    @if(Auth::user()->role === 'user')
        <div x-show="sidebarOpen" x-cloak class="mt-4 mb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Bisnis Saya</div>
        @endif

    @if(Auth::user()->role === 'super_admin')
        <div x-show="sidebarOpen" x-cloak class="mt-4 mb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sistem</div>
        <a href="#" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold" :class="!sidebarOpen && 'justify-center px-0'">
            <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg></span>
            <span x-show="sidebarOpen" x-cloak>User Management</span>
        </a>
    @endif

    <div class="sidebar-divider my-4"></div>

    <a href="{{ route('settings.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('settings.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
        <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09A1.65 1.65 0 0015 4.6a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg></span>
        <span x-show="sidebarOpen" x-cloak>Pengaturan Sistem</span>
    </a>
</nav>

            <!-- Mini brand footer in sidebar -->
            {{-- <div x-show="sidebarOpen" x-cloak class="px-4 pb-5 pt-2 flex-shrink-0">
                <div class="rounded-xl bg-white/5 border border-white/10 p-3.5">
                    <p class="text-[10.5px] text-white/40 leading-relaxed">Dinas Sosial PPPA<br>Kabupaten Cilacap</p>
                </div>
            </div> --}}
        </aside>

        <!-- Main content: margin menyesuaikan status sidebar -->
        <main class="main-content flex-1 pt-16 p-10 main-bg min-h-screen overflow-y-auto"
              :class="sidebarOpen ? 'ml-64' : 'ml-[78px]'">
           @yield('content')
        </main>
    </div>

</body>
</html>