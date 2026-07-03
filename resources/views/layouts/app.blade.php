<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIDAYA') }}</title>

    <!-- Set tema lebih awal supaya tidak ada "flash" warna saat halaman dimuat -->
    <script>
        (function () {
            try {
                var stored = localStorage.getItem('sidaya-theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var isDark = stored ? stored === 'dark' : prefersDark;
                if (isDark) document.documentElement.classList.add('dark');
            } catch (e) {}
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: document.documentElement.classList.contains('dark'),
                toggle() {
                    this.dark = !this.dark;
                    document.documentElement.classList.toggle('dark', this.dark);
                    try { localStorage.setItem('sidaya-theme', this.dark ? 'dark' : 'light'); } catch (e) {}
                }
            });
        });
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --navy-950:#08182C;
            --navy-900:#0A1F38;
            --navy-800:#0B2A4A;
            --navy-700:#123A61;
            --teal-600:#0E7C9E;
            --teal-400:#2FB4D6;
            --cyan-300:#5FD9E8;

            --page-bg-solid:#F4F7FA;
            --page-glow-1: rgba(14,124,158,0.07);
            --page-glow-2: rgba(95,217,232,0.05);
            --surface:#ffffff;
            --surface-alt:#F8FAFC;
            --surface-border: rgba(15,23,42,0.08);
            --surface-hover:#F8FAFC;
            --text-strong:#1E293B;
            --text-body:#475569;
            --text-muted:#94A3B8;
            --header-bg: rgba(255,255,255,0.72);
            --divider: rgba(15,23,42,0.07);
            --ring-bg: #F4F7FA;
        }
        html.dark {
            --page-bg-solid:#081326;
            --page-glow-1: rgba(95,217,232,0.06);
            --page-glow-2: rgba(14,124,158,0.14);
            --surface:#0F2340;
            --surface-alt:#0B1C34;
            --surface-border: rgba(148,197,214,0.14);
            --surface-hover:#15304F;
            --text-strong:#EAF3F8;
            --text-body:#A9BFD6;
            --text-muted:#6E88A6;
            --header-bg: rgba(8,19,38,0.7);
            --divider: rgba(148,197,214,0.14);
            --ring-bg: #081326;
        }
        html, body { background-color: var(--page-bg-solid); }
        html { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        body, .app-header, .dropdown-panel, .main-bg, .sidebar-toggle, .theme-toggle {
            transition: background-color .35s ease, color .35s ease, border-color .35s ease, box-shadow .35s ease;
        }

        .sidebar-navy {
            background:
                radial-gradient(120% 60% at 10% -10%, rgba(95,217,232,0.14), transparent 55%),
                radial-gradient(90% 50% at 100% 110%, rgba(14,124,158,0.28), transparent 60%),
                linear-gradient(160deg, var(--navy-950) 0%, var(--navy-900) 45%, var(--navy-800) 100%);
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .sidebar-navy::before{
            content:'';
            position:absolute; inset:0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 22px 22px;
            opacity:.35;
            pointer-events:none;
            mask-image: linear-gradient(180deg, black, transparent 70%);
        }
        .sidebar-navy > * { position: relative; z-index: 1; }

        .nav-item {
            position: relative; color: rgba(255,255,255,0.55);
            transition: background .2s ease, color .2s ease, transform .15s ease;
            white-space: nowrap; overflow: hidden;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; transform: translateX(1px); }
        .nav-item.active {
            background: linear-gradient(90deg, rgba(14,124,158,0.35), rgba(95,217,232,0.08));
            color: #E9FBFF;
            box-shadow: inset 0 0 0 1px rgba(95,217,232,0.15);
        }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 8px; bottom: 8px; width: 3px;
            border-radius: 0 3px 3px 0;
            background: linear-gradient(180deg, var(--cyan-300), var(--teal-600));
            box-shadow: 0 0 12px rgba(95,217,232,0.7);
        }
        .nav-item.disabled { opacity: .4; cursor: not-allowed; }
        .nav-item.disabled:hover { background: transparent; color: rgba(255,255,255,0.55); transform: none; }
        .nav-icon-wrap {
            width: 30px; height: 30px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.05); flex-shrink: 0;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
            transition: background .2s ease, box-shadow .2s ease;
        }
        .nav-item:hover .nav-icon-wrap { background: rgba(255,255,255,0.08); }
        .nav-item.active .nav-icon-wrap {
            background: linear-gradient(160deg, var(--teal-600), var(--cyan-300));
            box-shadow: 0 4px 14px -2px rgba(95,217,232,0.55);
        }
        .nav-item.active .nav-icon-wrap svg { color: #06212F; stroke: #06212F; }

        .sidebar-divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent); }

        .group-header {
            color: rgba(255,255,255,0.38);
            transition: color .2s ease, background .2s ease;
        }
        .group-header:hover { color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.03); }
        .group-chevron { transition: transform .3s cubic-bezier(0.4,0,0.2,1); }
        .group-panel {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows .32s cubic-bezier(0.4,0,0.2,1);
        }
        .group-panel.is-open { grid-template-rows: 1fr; }
        .group-panel > div { overflow: hidden; }

        .main-content { transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1), left .35s cubic-bezier(0.4, 0, 0.2, 1); }
        .main-bg {
            background:
                radial-gradient(60% 40% at 100% 0%, var(--page-glow-1), transparent 55%),
                radial-gradient(50% 35% at 0% 100%, var(--page-glow-2), transparent 55%),
                var(--page-bg-solid);
        }

        .app-header {
            background: var(--header-bg);
            border-bottom: 1px solid var(--divider);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }
        .avatar-chip {
            width: 32px; height: 32px; border-radius: 10px;
            background: linear-gradient(160deg, var(--navy-800), var(--teal-600) 70%, var(--cyan-300));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 12px; flex-shrink: 0;
            box-shadow: 0 4px 12px -2px rgba(14,124,158,0.45);
        }
        .dropdown-panel {
            background: var(--surface);
            border: 1px solid var(--surface-border);
            box-shadow: 0 20px 45px -12px rgba(15,23,42,0.18);
        }
        html.dark .dropdown-panel { box-shadow: 0 20px 45px -12px rgba(0,0,0,0.55); }
        [x-cloak] { display: none !important; }

        .sidebar-toggle {
            width: 30px; height: 30px; border-radius: 999px;
            background: linear-gradient(160deg, var(--surface), var(--surface-alt));
            border: 1px solid var(--surface-border);
            box-shadow: 0 8px 20px -6px rgba(11,42,74,0.35), 0 0 0 4px var(--ring-bg);
            display: flex; align-items: center; justify-content: center;
            color: var(--navy-800);
            transition: box-shadow .2s ease, transform .2s ease, color .2s ease, background-color .35s ease;
        }
        html.dark .sidebar-toggle { color: var(--cyan-300); }
        .sidebar-toggle:hover { color: var(--teal-600); box-shadow: 0 10px 24px -6px rgba(14,124,158,0.45), 0 0 0 4px var(--ring-bg); }
        html.dark .sidebar-toggle:hover { color: var(--cyan-300); }
        .sidebar-toggle:active { transform: scale(0.92); }
        .sidebar-toggle svg { transition: transform .35s cubic-bezier(0.4,0,0.2,1); }

        .theme-toggle {
            position: relative; width: 52px; height: 28px; border-radius: 999px;
            background: linear-gradient(160deg, #EEF3F7, #E3E9EF);
            border: 1px solid var(--surface-border);
            display: flex; align-items: center; padding: 3px;
            cursor: pointer; flex-shrink: 0;
        }
        html.dark .theme-toggle { background: linear-gradient(160deg, #1B2436, #0F1727); }
        .theme-toggle-thumb {
            width: 22px; height: 22px; border-radius: 999px;
            background: linear-gradient(160deg, #ffffff, #EEF3F7);
            box-shadow: 0 2px 6px rgba(15,23,42,0.28);
            display: flex; align-items: center; justify-content: center;
            color: var(--teal-600);
            transition: transform .35s cubic-bezier(0.4,0,0.2,1), background .35s ease, color .35s ease;
        }
        .theme-toggle-thumb.is-dark {
            transform: translateX(24px);
            background: linear-gradient(160deg, var(--navy-800), var(--teal-600));
            color: var(--cyan-300);
        }
        .theme-toggle-thumb svg { width: 12px; height: 12px; }

        html.dark main { color: var(--text-body); }

        html.dark main .bg-white,
        html.dark main .bg-slate-50,
        html.dark main .bg-gray-50,
        html.dark main .bg-slate-100,
        html.dark main .bg-gray-100 { background-color: var(--surface) !important; }

        html.dark main .text-slate-900,
        html.dark main .text-slate-800,
        html.dark main .text-gray-900,
        html.dark main .text-gray-800,
        html.dark main .text-black { color: var(--text-strong) !important; }

        html.dark main .text-slate-700,
        html.dark main .text-slate-600,
        html.dark main .text-gray-700,
        html.dark main .text-gray-600 { color: var(--text-body) !important; }

        html.dark main .text-slate-500,
        html.dark main .text-slate-400,
        html.dark main .text-gray-500,
        html.dark main .text-gray-400 { color: var(--text-muted) !important; }

        html.dark main .border-slate-100,
        html.dark main .border-slate-200,
        html.dark main .border-slate-300,
        html.dark main .border-gray-100,
        html.dark main .border-gray-200,
        html.dark main .border-gray-300 { border-color: var(--surface-border) !important; }

        html.dark main .divide-slate-100 > :not([hidden]) ~ :not([hidden]),
        html.dark main .divide-slate-200 > :not([hidden]) ~ :not([hidden]),
        html.dark main .divide-gray-100 > :not([hidden]) ~ :not([hidden]),
        html.dark main .divide-gray-200 > :not([hidden]) ~ :not([hidden]) { border-color: var(--surface-border) !important; }

        html.dark main .hover\:bg-slate-50:hover,
        html.dark main .hover\:bg-gray-50:hover,
        html.dark main .hover\:bg-slate-100:hover { background-color: var(--surface-hover) !important; }

        html.dark main table thead,
        html.dark main thead tr { background-color: var(--surface-alt) !important; }

        html.dark main input:not([type=checkbox]):not([type=radio]),
        html.dark main select,
        html.dark main textarea {
            background-color: var(--surface-alt) !important;
            border-color: var(--surface-border) !important;
            color: var(--text-strong) !important;
        }
        html.dark main input::placeholder,
        html.dark main textarea::placeholder { color: var(--text-muted) !important; }

        html.dark main .shadow,
        html.dark main .shadow-sm,
        html.dark main .shadow-md,
        html.dark main .shadow-lg,
        html.dark main .shadow-xl { box-shadow: 0 10px 30px -12px rgba(0,0,0,0.55) !important; }

        .sidebar-scroll { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.15) transparent; }
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.28); }

        .rail-tooltip {
            position: absolute; left: calc(100% + 10px); top: 50%; transform: translateY(-50%) translateX(-4px);
            background: var(--navy-950); color: #fff; font-size: 12px; font-weight: 600;
            padding: 6px 10px; border-radius: 8px; white-space: nowrap;
            box-shadow: 0 10px 25px -6px rgba(0,0,0,0.4);
            opacity: 0; pointer-events: none;
            transition: opacity .18s ease, transform .18s ease;
            z-index: 50;
        }
        .rail-item:hover .rail-tooltip { opacity: 1; transform: translateY(-50%) translateX(0); }

        .badge-live {
            display:inline-flex; align-items:center; gap:5px;
            font-size: 10px; font-weight: 700; letter-spacing:.04em;
            padding: 3px 8px; border-radius: 999px;
            background: rgba(95,217,232,0.12); color: var(--cyan-300);
            box-shadow: inset 0 0 0 1px rgba(95,217,232,0.25);
        }
        .badge-live .dot { width:5px; height:5px; border-radius:999px; background: var(--cyan-300); box-shadow: 0 0 6px var(--cyan-300); }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 dark:text-slate-200" x-data="{ sidebarOpen: true }">

    <!-- Header -->
    <header class="main-content app-header border-b border-slate-100/80 fixed top-0 right-0 h-16 z-20 flex items-center justify-between px-6"
             :class="sidebarOpen ? 'left-64' : 'left-[78px]'">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 dark:text-slate-500">
        </div>

        <div class="flex items-center gap-3">
            <button type="button"
                    @click="$store.theme.toggle()"
                    class="theme-toggle"
                    :aria-pressed="$store.theme.dark.toString()"
                    aria-label="Ganti mode tampilan gelap/terang">
                <span class="theme-toggle-thumb" :class="$store.theme.dark && 'is-dark'">
                    <svg x-show="!$store.theme.dark" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                    <svg x-show="$store.theme.dark" x-cloak width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                </span>
            </button>

            <div class="w-px h-6 bg-slate-100 dark:bg-white/10"></div>

            <div x-data="{ openProfil: false }" class="relative">
                <button @click="openProfil = !openProfil" class="text-sm font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2.5 border border-transparent hover:border-slate-100 dark:hover:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 py-1.5 px-2.5 rounded-xl transition-all cursor-pointer focus:outline-none">
                    <span class="avatar-chip">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                    <span class="hidden sm:flex flex-col items-start leading-tight">
                        <span>{{ Auth::user()->name ?? 'Admin SIDAYA' }}</span>
                        <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 capitalize">{{ str_replace('_',' ', Auth::user()->role ?? 'admin') }}</span>
                    </span>
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 transition-transform duration-200" :class="{'rotate-180': openProfil}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                     class="dropdown-panel absolute right-0 mt-2 w-56 rounded-2xl z-50 py-1.5 overflow-hidden">

                    <div class="px-4 pt-2 pb-3">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-100 truncate">{{ Auth::user()->name ?? 'Admin SIDAYA' }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->email ?? '-' }}</p>
                    </div>
                    <hr class="border-slate-100 dark:border-white/10">

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 mt-1 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Kelola Profil
                    </a>

                    <hr class="border-slate-100 dark:border-white/10 my-1">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-rose-500 dark:text-rose-400 hover:bg-rose-50/60 dark:hover:bg-rose-500/10 transition-colors text-left">
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

            <button @click="sidebarOpen = !sidebarOpen" class="sidebar-toggle absolute top-7 -right-3.5 z-30">
                <svg class="w-3.5 h-3.5" :class="!sidebarOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>

            <div class="p-6 flex flex-col items-center border-b border-white/5 flex-shrink-0">
                <img src="{{ asset('img/Logo_sdy.png') }}" class="object-contain mb-3 transition-all duration-300" :class="sidebarOpen ? 'w-20 h-20' : 'w-10 h-10'">
                <h2 x-show="sidebarOpen" x-cloak class="text-white font-display font-extrabold text-lg tracking-tight whitespace-nowrap">SIDAYA</h2>
                <p x-show="sidebarOpen" x-cloak class="text-white/40 text-xs font-medium uppercase tracking-widest whitespace-nowrap mb-2"></p>
                <span x-show="sidebarOpen" x-cloak class="badge-live"><span class="dot"></span>SISTEM AKTIF</span>
            </div>

            <nav class="sidebar-scroll p-4 space-y-1.5 flex-1 overflow-y-auto overflow-x-hidden">

                <a href="{{ route('dashboard') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('dashboard') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                    <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg></span>
                    <span x-show="sidebarOpen" x-cloak>Dashboard</span>
                    <template x-if="!sidebarOpen"><span class="rail-tooltip">Dashboard</span></template>
                </a>

                {{-- ========== GRUP: MANAJEMEN DATA (admin & super_admin) ========== --}}
                @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                <div class="pt-3">
                    <div x-data="{ open: true }" class="rounded-xl" :class="!sidebarOpen && 'flex flex-col items-center'">

                        <button x-show="sidebarOpen" x-cloak @click="open = !open"
                                class="group-header w-full flex items-center justify-between px-4 py-2 mb-1 rounded-lg">
                            <span class="text-[10px] font-bold uppercase tracking-wider">Manajemen Data</span>
                            <svg class="group-chevron w-3 h-3" :class="open && 'rotate-90'" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                        <div x-show="!sidebarOpen" x-cloak class="sidebar-divider w-8 mx-auto my-2"></div>

                        <div class="group-panel w-full" :class="(open || !sidebarOpen) && 'is-open'">
                            <div class="space-y-1.5">

                                <a href="{{ route('penerima-manfaat.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('penerima-manfaat.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                    <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></span>
                                    <span x-show="sidebarOpen" x-cloak>Penerima Manfaat</span>
                                    <template x-if="!sidebarOpen"><span class="rail-tooltip">Penerima Manfaat</span></template>
                                </a>

                                <a href="{{ route('uep.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('uep.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                    <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></span>
                                    <span x-show="sidebarOpen" x-cloak>Kelolaan UEP</span>
                                    <template x-if="!sidebarOpen"><span class="rail-tooltip">Kelolaan UEP</span></template>
                                </a>

                                <a href="{{ route('kube.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('kube.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                    <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 9h1"/><path d="M9 13h1"/><path d="M14 9h1"/><path d="M14 13h1"/></svg></span>
                                    <span x-show="sidebarOpen" x-cloak>Kelompok KUBE</span>
                                    <template x-if="!sidebarOpen"><span class="rail-tooltip">Kelompok KUBE</span></template>
                                </a>

                                <a href="{{ route('produk.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('produk.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                    <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></span>
                                    <span x-show="sidebarOpen" x-cloak>Produk UMKM</span>
                                    <template x-if="!sidebarOpen"><span class="rail-tooltip">Produk UMKM</span></template>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ========== GRUP: BISNIS SAYA (khusus role user) ========== --}}
                @if(Auth::user()->role === 'user')
                    @php
                        // Status disetujui dicek dari kedua jenis usaha (UEP maupun KUBE) yang dimiliki user ini.
                        // Sesuaikan nama model (Uep/Kube) jika namespace/case model kamu berbeda.
                        $isApprovedUep = \App\Models\Uep::where('user_id', auth()->id())
                                            ->where('status_verifikasi', 'disetujui')
                                            ->exists();
                        $isApprovedKube = \App\Models\Kube::where('user_id', auth()->id())
                                            ->where('status_verifikasi', 'disetujui')
                                            ->exists();
                        $isApproved = $isApprovedUep || $isApprovedKube;
                    @endphp

                    <div class="pt-3">
                        <div x-data="{ open: true }" class="rounded-xl" :class="!sidebarOpen && 'flex flex-col items-center'">

                            <button x-show="sidebarOpen" x-cloak @click="open = !open"
                                    class="group-header w-full flex items-center justify-between px-4 py-2 mb-1 rounded-lg">
                                <span class="text-[10px] font-bold uppercase tracking-wider">Manejemen Bisnis</span>
                                <svg class="group-chevron w-3 h-3" :class="open && 'rotate-90'" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                            <div x-show="!sidebarOpen" x-cloak class="sidebar-divider w-8 mx-auto my-2"></div>

                            <div class="group-panel w-full" :class="(open || !sidebarOpen) && 'is-open'">
                                <div class="space-y-1.5">

                                    <a href="{{ route('uep.status') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('uep.create') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                        <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></span>
                                        <span x-show="sidebarOpen" x-cloak>Ajukan UEP</span>
                                        <template x-if="!sidebarOpen"><span class="rail-tooltip">Ajukan UEP</span></template>
                                    </a>

                                    <a href="{{ route('kube.status') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('kube.create') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                        <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 9h1"/><path d="M9 13h1"/><path d="M14 9h1"/><path d="M14 13h1"/></svg></span>
                                        <span x-show="sidebarOpen" x-cloak>Ajukan KUBE</span>
                                        <template x-if="!sidebarOpen"><span class="rail-tooltip">Ajukan KUBE</span></template>
                                    </a>

                                    @if($isApproved)
                                        <a href="{{ route('produk.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('produk.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                            <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></span>
                                            <span x-show="sidebarOpen" x-cloak>Produk Saya</span>
                                            <template x-if="!sidebarOpen"><span class="rail-tooltip">Produk Saya</span></template>
                                        </a>
                                    @else
                                        <span title="Tunggu verifikasi admin" class="rail-item nav-item disabled flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold" :class="!sidebarOpen && 'justify-center px-0'">
                                            <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></span>
                                            <span x-show="sidebarOpen" x-cloak>Produk Saya (Terkunci)</span>
                                            <template x-if="!sidebarOpen"><span class="rail-tooltip">Produk Saya (Terkunci)</span></template>
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ========== GRUP: SISTEM (khusus super_admin) ========== --}}
                @if(Auth::user()->role === 'super_admin')
                    <div class="pt-3">
                        <div x-data="{ open: true }" class="rounded-xl" :class="!sidebarOpen && 'flex flex-col items-center'">
                            <button x-show="sidebarOpen" x-cloak @click="open = !open"
                                    class="group-header w-full flex items-center justify-between px-4 py-2 mb-1 rounded-lg">
                                <span class="text-[10px] font-bold uppercase tracking-wider">Sistem</span>
                                <svg class="group-chevron w-3 h-3" :class="open && 'rotate-90'" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                            <div x-show="!sidebarOpen" x-cloak class="sidebar-divider w-8 mx-auto my-2"></div>

                            <div class="group-panel w-full" :class="(open || !sidebarOpen) && 'is-open'">
                                <div class="space-y-1.5">
                                    <a href="{{ route('superadmin.users.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold" :class="!sidebarOpen && 'justify-center px-0'">
                                        <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg></span>
                                        <span x-show="sidebarOpen" x-cloak>User Management</span>
                                        <template x-if="!sidebarOpen"><span class="rail-tooltip">User Management</span></template>
                                    </a>

                                    <a href="{{ route('settings.index') }}" class="rail-item nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('settings.*') ? 'active' : '' }}" :class="!sidebarOpen && 'justify-center px-0'">
                                        <span class="nav-icon-wrap"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09A1.65 1.65 0 0015 4.6a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg></span>
                                        <span x-show="sidebarOpen" x-cloak>Pengaturan Sistem</span>
                                        <template x-if="!sidebarOpen"><span class="rail-tooltip">Pengaturan Sistem</span></template>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </nav>

        </aside>

        <!-- Main content: margin menyesuaikan status sidebar -->
        <main class="main-content flex-1 pt-16 p-10 main-bg min-h-screen overflow-y-auto"
              :class="sidebarOpen ? 'ml-64' : 'ml-[78px]'">
        {{-- Konten hanya yield satu kali di sini --}}
            @yield('content')

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('components.alert')
</body>
</html>