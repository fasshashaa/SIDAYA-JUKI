<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{ 'dark': $store.darkMode?.on }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasar Berdaya - SIDAYA')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- SweetAlert2 (untuk konfirmasi & alert) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: light;

            /* Surfaces */
            --surface: #F5F7FA;
            --surface-elevated: #FFFFFF;
            --surface-card: #FFFFFF;
            --surface-card-hover: #FFFFFF;
            --surface-muted: #F1F5F9;
            --surface-input: #FFFFFF;

            /* Text */
            --text-strong: #0B2A4A;
            --text-body: #3B4B5E;
            --text-muted: #64748B;
            --text-faint: #94A3B8;
            --text-on-accent: #FFFFFF;

            /* Brand */
            --navy-deep: #08182C;
            --navy: #0B2A4A;
            --teal: #0E7C9E;
            --cyan: #5FD9E8;
            --price: #08182C;

            /* Borders / shadow */
            --border-soft: rgba(11,42,74,0.08);
            --border-strong: rgba(11,42,74,0.16);
            --shadow-soft: rgba(8,24,44,0.06);
            --shadow-strong: rgba(8,24,44,0.14);
        }
        html.dark {
            color-scheme: dark;

            --surface: #0A121D;
            --surface-elevated: #111D2C;
            --surface-card: #121F30;
            --surface-card-hover: #16263A;
            --surface-muted: #16263A;
            --surface-input: #16263A;

            --text-strong: #EEF5FB;
            --text-body: #C4D2E0;
            --text-muted: #92A5B8;
            --text-faint: #64798D;
            --text-on-accent: #FFFFFF;

            --price: #5FD9E8;

            --border-soft: rgba(255,255,255,0.08);
            --border-strong: rgba(255,255,255,0.16);
            --shadow-soft: rgba(0,0,0,0.35);
            --shadow-strong: rgba(0,0,0,0.55);
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--text-strong);
        }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Sembunyikan native spinner number input (Chrome/Safari) agar angka tidak tertutup/terpotong */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="min-h-screen transition-colors duration-300" x-data="{ mobileOpen: false }">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 backdrop-blur-md border-b transition-colors"
         style="background: color-mix(in srgb, var(--surface-elevated) 85%, transparent); border-color: var(--border-soft);">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">


                {{-- Logo --}}
           <a href="/" class="flex items-center gap-3 shrink-0">
    <!-- Gambar Logo -->
    <img src="{{ asset('img/Logo_sdy.png') }}" alt="Logo SIDAYA" class="w-10 h-10 rounded-xl object-cover">
    
    <!-- Teks -->
    <span class="flex flex-col justify-center">
        <span class="font-display font-extrabold text-lg tracking-tight leading-none" style="color: var(--text-strong);">
            Pasar <span style="color: var(--teal);">Berdaya</span>
        </span>
        <span class="text-[10px] font-medium tracking-widest uppercase mt-0.5" style="color: var(--text-faint);">
            by SIDAYA
        </span>
    </span>
</a>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('marketplace.index') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition"
                       style="color: var(--text-muted);" onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='transparent'">
                        Beranda
                    </a>
                    <a href="{{ route('riwayat.index') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition"
                       style="color: var(--text-muted);" onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='transparent'">
                        Riwayat
                    </a>
                </div>

                {{-- Right actions --}}
                <div class="flex items-center gap-2">

                    {{-- Dark mode toggle --}}
                    <button @click="$store.darkMode.toggle()"
                            class="w-9 h-9 rounded-lg flex items-center justify-center transition"
                            style="color: var(--text-muted);" title="Ganti tema"
                            onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-moon text-sm" x-show="!$store.darkMode?.on"></i>
                        <i class="fa-solid fa-sun text-sm" x-show="$store.darkMode?.on" x-cloak></i>
                    </button>

                    {{-- Cart --}}
                    <a href="{{ route('keranjang') }}"
                       class="relative w-9 h-9 rounded-lg flex items-center justify-center transition"
                       style="color: var(--text-muted);" title="Keranjang"
                       onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-cart-shopping text-[15px]"></i>
                        @if(!empty($cartCount) && $cartCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-bold
                                         flex items-center justify-center text-white"
                                  style="background: linear-gradient(135deg, var(--teal), var(--cyan));">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        {{-- User dropdown --}}
                        <div class="relative hidden md:block" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                    class="flex items-center gap-2 pl-2 pr-1 py-1 rounded-lg transition"
                                    onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='transparent'">
                                <span class="w-7 h-7 rounded-full flex items-center justify-center text-white text-[11px] font-bold"
                                      style="background: linear-gradient(135deg, var(--navy), var(--teal));">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px]" style="color: var(--text-muted);"></i>
                            </button>
                            <div x-show="open" x-transition x-cloak
                                 class="absolute right-0 mt-2 w-44 rounded-xl shadow-lg border py-1.5 overflow-hidden"
                                 style="background: var(--surface-elevated); border-color: var(--border-soft); box-shadow: 0 12px 32px var(--shadow-strong);">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm flex items-center gap-2 transition"
                                            style="color: var(--text-muted);"
                                            onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='transparent'">
                                        <i class="fa-solid fa-right-from-bracket text-[12px]"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    {{-- Mobile menu toggle --}}
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center"
                            style="color: var(--text-muted);">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div x-show="mobileOpen" x-transition x-cloak class="md:hidden border-t px-4 py-3 space-y-1" style="border-color: var(--border-soft);">
            <a href="/" class="block px-3 py-2 rounded-lg text-sm font-medium" style="color: var(--text-muted);">Beranda</a>
            <a href="{{ route('riwayat.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium" style="color: var(--text-muted);">Riwayat</a>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium" style="color: var(--text-muted);">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- ================= GLOBAL TOAST ALERT ================= --}}
    @if(session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end', // Muncul di pojok kanan atas
                showConfirmButton: false, // Menghilangkan tombol OK
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                customClass: {
                    popup: 'rounded-2xl shadow-lg border border-gray-100'
                }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            const ToastError = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });

            ToastError.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                customClass: {
                    popup: 'rounded-2xl shadow-lg border border-gray-100'
                }
            });
        </script>
    @endif

    @if(session('info'))
        <script>
            const ToastInfo = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            ToastInfo.fire({
                icon: 'info',
                title: '{{ session('info') }}',
                customClass: {
                    popup: 'rounded-2xl shadow-lg border border-gray-100'
                }
            });
        </script>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                on: localStorage.getItem('darkMode') === 'true',
                toggle() {
                    this.on = !this.on;
                    localStorage.setItem('darkMode', this.on);
                }
            });
        });
    </script>
</body>
</html>