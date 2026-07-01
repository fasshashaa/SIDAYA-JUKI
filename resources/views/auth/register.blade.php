<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIDAYA Cilacap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #0A1F38; margin: 0; min-height: 100vh; position: relative; overflow-x: hidden; }

        /* ── BACKGROUND DECOR ── */
        .bg-deco-1 { position: fixed; top: -10%; right: -8%; width: 520px; height: 520px; border-radius: 50%; background: rgba(14,124,158,0.16); filter: blur(130px); pointer-events: none; }
        .bg-deco-2 { position: fixed; bottom: -18%; left: -10%; width: 460px; height: 460px; border-radius: 50%; background: rgba(43,196,217,0.09); filter: blur(130px); pointer-events: none; }
        .bg-deco-3 { position: fixed; top: 40%; left: 38%; width: 280px; height: 280px; border-radius: 50%; background: rgba(95,217,232,0.05); filter: blur(100px); pointer-events: none; }
        .bg-grid {
            position: fixed; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 46px 46px;
            pointer-events: none;
            mask-image: radial-gradient(circle at 30% 40%, rgba(0,0,0,0.55), transparent 70%);
        }
        .bg-noise {
            position: fixed; inset: 0; pointer-events: none; opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        /* ── LEFT PANEL ── */
        .badge-pill {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(95,217,232,0.18);
            border-radius: 50px; padding: 6px 14px;
            font-size: 10.5px; color: #5FD9E8;
            letter-spacing: 0.09em; font-weight: 700;
            text-transform: uppercase;
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #5FD9E8; box-shadow: 0 0 10px #5FD9E8; animation: pulse-dot 2s ease-in-out infinite; }
        @keyframes pulse-dot { 0%,100% { opacity: 1; } 50% { opacity: 0.35; } }

        .logo-glow-wrap { position: relative; }
        .logo-glow-ring { position: absolute; inset: -18px; border-radius: 50%; border: 1px solid rgba(95,217,232,0.15); }
        .logo-glow-ring::before {
            content: ''; position: absolute; inset: -1px; border-radius: 50%;
            border: 1px dashed rgba(95,217,232,0.12);
            animation: spin-slow 30s linear infinite;
        }
        @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .feature-row { display: flex; align-items: center; gap: 11px; }
        .feature-icon-box {
            width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
            background: rgba(14,124,158,0.15);
            border: 1px solid rgba(95,217,232,0.18);
            display: flex; align-items: center; justify-content: center;
        }

        .stat-block { text-align: left; }
        .stat-num-mini { font-size: 19px; font-weight: 800; color: #fff; line-height: 1.1; letter-spacing: -0.01em; }
        .stat-lbl-mini { font-size: 10.5px; color: rgba(255,255,255,0.35); letter-spacing: 0.03em; margin-top: 2px; }
        .stat-vline { width: 1px; height: 28px; background: rgba(255,255,255,0.1); }

        /* ── CARD ── */
        .register-card {
            background: rgba(255,255,255,0.035);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.09);
            box-shadow: 0 25px 60px -15px rgba(0,0,0,0.55);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative; overflow: hidden;
        }
        .register-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(95,217,232,0.55), transparent);
        }
        .register-card:hover { transform: translateY(-6px); border-color: rgba(95,217,232,0.25); box-shadow: 0 35px 80px -15px rgba(0,0,0,0.65); }

        .card-header-tag {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 10.5px; font-weight: 700; color: rgba(255,255,255,0.4);
            letter-spacing: 0.06em; text-transform: uppercase;
        }

        .field-label { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.45); margin-bottom: 8px; display: block; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); pointer-events: none; }
        .input-field { background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.10); color: #fff; transition: 0.2s; }
        .input-field::placeholder { color: rgba(255,255,255,0.25); }
        .input-field:focus { border-color: #0E7C9E; background: rgba(255,255,255,0.06); outline: none; box-shadow: 0 0 0 3px rgba(14,124,158,0.18); }
        .input-field-icon { padding-left: 42px; }

        .btn-submit {
            background: linear-gradient(135deg, #0E7C9E, #0B6580);
            color: #fff;
            box-shadow: 0 12px 28px -8px rgba(14,124,158,0.55);
            transition: 0.2s;
            position: relative; overflow: hidden;
        }
        .btn-submit::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.18), transparent);
            transition: left 0.6s ease;
        }
        .btn-submit:hover::after { left: 130%; }
        .btn-submit:hover { background: linear-gradient(135deg, #129AC2, #0E7C9E); transform: translateY(-1px); box-shadow: 0 16px 32px -8px rgba(14,124,158,0.7); }
        .btn-submit:active { transform: translateY(0); }

        .divider-line { height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent); }

        .strength-bar { height: 4px; border-radius: 2px; background: rgba(255,255,255,0.08); overflow: hidden; flex: 1; }
        .strength-fill { height: 100%; width: 0%; border-radius: 2px; transition: width 0.3s ease, background 0.3s ease; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 py-12">

    <div class="bg-grid"></div>
    <div class="bg-noise"></div>
    <div class="bg-deco-1"></div>
    <div class="bg-deco-2"></div>
    <div class="bg-deco-3"></div>

    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-14 items-center relative z-10">

        <!-- ── PANEL KIRI: BRAND & VALUE PROPS ── -->
        <div class="hidden md:flex flex-col justify-center items-start">

            {{-- <div class="badge-pill mb-7">
                <span class="badge-dot"></span>
                Platform Terintegrasi Pemerintah
            </div> --}}

            <div class="logo-glow-wrap mb-7">
                <div class="logo-glow-ring"></div>
                <img src="{{ asset('img/Logo_sdy.png') }}"
                     class="w-28 h-28 object-contain relative z-10 transition-all duration-500 ease-out hover:scale-105 hover:drop-shadow-[0_0_30px_rgba(95,217,232,0.4)]">
            </div>

            <h1 class="text-[34px] font-extrabold text-white tracking-tight leading-tight">SIDAYA</h1>
            <p class="text-[14.5px] text-white/55 font-medium mt-1.5 max-w-sm">Sistem Informasi Pemberdayaan Masyarakat untuk monitoring, transparansi, dan pasar digital UEP.</p>
            <p class="text-[11.5px] text-white/30 italic mt-1">Dinas Sosial PPPA Kabupaten Cilacap</p>

            <div class="w-full divider-line my-7"></div>

            <!-- Feature highlights -->
            <div class="space-y-4 w-full max-w-sm">
                <div class="feature-row">
                    <div class="feature-icon-box">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5FD9E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <span class="text-[13px] text-white/60">Monitoring UEP secara real-time</span>
                </div>
                <div class="feature-row">
                    <div class="feature-icon-box">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5FD9E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    </div>
                    <span class="text-[13px] text-white/60">Pasar digital produk binaan UMKM</span>
                </div>
                <div class="feature-row">
                    <div class="feature-icon-box">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5FD9E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <span class="text-[13px] text-white/60">Laporan kinerja transparan & terjadwal</span>
                </div>
            </div>

            <div class="w-full divider-line my-7"></div>

            {{-- <!-- Mini stats -->
            <div class="flex items-center gap-5">
                <div class="stat-block">
                    <p class="stat-num-mini">248</p>
                    <p class="stat-lbl-mini">UEP Aktif</p>
                </div>
                <div class="stat-vline"></div>
                <div class="stat-block">
                    <p class="stat-num-mini">32</p>
                    <p class="stat-lbl-mini">Kecamatan</p>
                </div>
                <div class="stat-vline"></div>
                <div class="stat-block">
                    <p class="stat-num-mini">1.2K</p>
                    <p class="stat-lbl-mini">Penerima Manfaat</p>
                </div>
            </div> --}}
        </div>

        <!-- ── PANEL KANAN: FORM CARD ── -->
        <div class="register-card p-8 md:p-10 rounded-[28px] w-full">

            <div class="md:hidden flex flex-col items-center mb-7">
                <img src="{{ asset('img/Logo_sdy.png') }}" class="w-16 h-16 object-contain mb-3">
                <h1 class="text-xl font-extrabold text-white tracking-tight">SIDAYA</h1>
            </div>

            <div class="flex items-center justify-between mb-7">
                <div>
                    <h2 class="text-[22px] font-extrabold text-white tracking-tight">Buat Akun Baru</h2>
                    <p class="text-[12.5px] text-white/40 mt-1">Daftar untuk mulai mengelola UEP Anda</p>
                </div>
                {{-- <span class="card-header-tag hidden sm:inline-flex">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Aman
                </span> --}}
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="field-label">Nama Lengkap</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input type="text" name="name" class="input-field input-field-icon w-full pr-4 py-3.5 rounded-xl text-[14px]" placeholder="Masukkan nama Anda" required>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="field-label">Email</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 6l-10 7L2 6"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                        </span>
                        <input type="email" name="email" class="input-field input-field-icon w-full pr-4 py-3.5 rounded-xl text-[14px]" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="field-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input type="password" id="pass1" name="password" oninput="checkStrength()" class="input-field input-field-icon w-full py-3.5 rounded-xl text-[14px] pr-12" placeholder="••••••••" required>
                        <button type="button" onclick="togglePass('pass1', 'icon1')" class="absolute right-4 top-3.5 text-white/30 hover:text-white transition-colors">
                            <svg id="icon1" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-2 mb-6 mt-2.5">
                    <div class="strength-bar"><div id="strengthFill" class="strength-fill"></div></div>
                    <span id="strengthLabel" class="text-[10.5px] text-white/30 w-16 flex-shrink-0">Kekuatan</span>
                </div>

                <div class="mb-7">
                    <label class="field-label">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input type="password" id="pass2" name="password_confirmation" class="input-field input-field-icon w-full py-3.5 rounded-xl text-[14px] pr-12" placeholder="••••••••" required>
                        <button type="button" onclick="togglePass('pass2', 'icon2')" class="absolute right-4 top-3.5 text-white/30 hover:text-white transition-colors">
                            <svg id="icon2" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit w-full font-bold py-3.5 rounded-xl text-[14.5px] flex items-center justify-center gap-2 mb-5">
                    Daftar Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>

                <div class="text-center text-[13px] text-white/40">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#5FD9E8] font-bold hover:underline ml-1">Masuk di sini</a>
                </div>
            </form>

            <div class="divider-line my-7"></div>

            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-1.5 text-[12.5px] text-white/30 hover:text-[#5FD9E8] transition-colors">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePass(inputId, iconId) {
            const p = document.getElementById(inputId);
            const i = document.getElementById(iconId);
            if (p.type === "password") {
                p.type = "text";
                i.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                p.type = "password";
                i.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        function checkStrength() {
            const val = document.getElementById('pass1').value;
            const fill = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');
            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { width: '0%', color: 'transparent', text: 'Kekuatan' },
                { width: '25%', color: '#E85C5C', text: 'Lemah' },
                { width: '55%', color: '#E8B23C', text: 'Cukup' },
                { width: '80%', color: '#5FD9E8', text: 'Kuat' },
                { width: '100%', color: '#3CE89A', text: 'Sangat Kuat' }
            ];
            const l = levels[score];
            fill.style.width = l.width;
            fill.style.background = l.color;
            label.textContent = l.text;
        }
    </script>
</body>
</html>