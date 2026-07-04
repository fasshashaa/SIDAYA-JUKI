<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SIDAYA Cilacap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #0A1F38; margin: 0; min-height: 100vh; position: relative; overflow-x: hidden; }

        /* ── BACKGROUND DECOR (sama dengan halaman login) ── */
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

        /* ── CARD (identik dengan login-card) ── */
        .login-card {
            background: rgba(255,255,255,0.035);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.09);
            box-shadow: 0 25px 60px -15px rgba(0,0,0,0.55);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative; overflow: hidden;
        }
        .login-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(95,217,232,0.55), transparent);
        }
        .login-card:hover { transform: translateY(-6px); border-color: rgba(95,217,232,0.25); box-shadow: 0 35px 80px -15px rgba(0,0,0,0.65); }

        .logo-glow-wrap { position: relative; }
        .logo-glow-ring {
            position: absolute; inset: -18px; border-radius: 50%;
            border: 1px solid rgba(95,217,232,0.15);
        }
        .logo-glow-ring::before {
            content: ''; position: absolute; inset: -1px; border-radius: 50%;
            border: 1px dashed rgba(95,217,232,0.12);
            animation: spin-slow 30s linear infinite;
        }
        @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .icon-badge {
            width: 3.5rem; height: 3.5rem; border-radius: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #0E7C9E, #0B6580);
            box-shadow: 0 12px 28px -8px rgba(14,124,158,0.55);
        }

        /* ── OTP INPUT BOXES ── */
        .otp-box {
            width: 2.9rem; height: 3.4rem;
            text-align: center; font-size: 1.35rem; font-weight: 700;
            font-family: 'Plus Jakarta Sans', monospace;
            border-radius: 0.85rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            outline: none;
            transition: 0.2s;
        }
        .otp-box::placeholder { color: rgba(255,255,255,0.2); }
        .otp-box:focus {
            border-color: #0E7C9E;
            background: rgba(255,255,255,0.07);
            box-shadow: 0 0 0 3px rgba(14,124,158,0.25);
        }

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

        /* ── COUNTDOWN: progress bar + label ── */
        .countdown-wrap { width: 100%; }
        .countdown-toprow {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 8px;
        }
        .countdown-label {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11.5px; font-weight: 600;
            color: rgba(255,255,255,0.4);
        }
        .countdown-time {
            font-size: 13px; font-weight: 800;
            font-family: 'Plus Jakarta Sans', monospace;
            color: #5FE8B0;
            transition: color 0.4s ease;
            letter-spacing: 0.02em;
        }
        .countdown-track {
            position: relative;
            width: 100%; height: 7px;
            border-radius: 50px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.06);
            overflow: hidden;
        }
        .countdown-bar {
            position: absolute; top: 0; left: 0; height: 100%;
            border-radius: 50px;
            width: 100%;
            background: linear-gradient(90deg, #2BC482, #5FE8B0);
            box-shadow: 0 0 10px rgba(95,232,176,0.5);
            transition: width 1s linear, background 0.6s ease, box-shadow 0.6s ease;
        }
        .countdown-bar.warning {
            background: linear-gradient(90deg, #D9A32B, #E8B85F);
            box-shadow: 0 0 10px rgba(232,184,95,0.5);
        }
        .countdown-bar.danger {
            background: linear-gradient(90deg, #D92B2B, #F26B6B);
            box-shadow: 0 0 10px rgba(242,107,107,0.5);
        }
        .countdown-time.warning { color: #E8B85F; }
        .countdown-time.danger { color: #F26B6B; }

        .alert-success {
            background: rgba(43, 196, 130, 0.08);
            border: 1px solid rgba(43, 196, 130, 0.2);
            color: #5FE8B0;
        }
        .alert-error { color: #F26B6B; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 py-12">

    <div class="bg-grid"></div>
    <div class="bg-noise"></div>
    <div class="bg-deco-1"></div>
    <div class="bg-deco-2"></div>
    <div class="bg-deco-3"></div>

    <div class="w-full max-w-sm relative z-10">
        <div class="login-card p-8 md:p-10 rounded-[28px] w-full">

            {{-- Header ikon --}}
            <div class="flex flex-col items-center text-center mb-7">
                <div class="logo-glow-wrap mb-5">
                    <div class="logo-glow-ring"></div>
                    <div class="icon-badge relative z-10">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-xl font-extrabold text-white tracking-tight">Verifikasi Keamanan</h2>
                <p class="mt-1.5 text-[13px] text-white/45 leading-relaxed">
                    {{ __('Sistem SIDAYA mendeteksi login baru. Masukkan 6 digit kode OTP yang telah dikirimkan demi keamanan akun Anda.') }}
                </p>
            </div>

            @if (session('status') || session('info'))
                <div class="mb-5 flex items-start gap-2.5 p-3.5 rounded-xl alert-success text-sm font-medium">
                    <svg style="width:18px;height:18px;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="leading-relaxed break-words">{{ session('status') ?? session('info') }}</span>
                </div>
            @endif

            <!-- @if($user->otp_code)
                <div class="p-2 mb-4 bg-yellow-100 text-yellow-800 rounded text-center font-mono text-sm">
                    Development Hint OTP: <strong>{{ $user->otp_code }}</strong>
                </div>
            @endif -->

            <form method="POST" action="{{ route('login.otp-verify.submit', $user->id) }}"
                  x-data="{
                    digits: ['', '', '', '', '', ''],
                    get combined() { return this.digits.join(''); },
                    handleInput(index, event) {
                        const val = event.target.value.replace(/[^0-9]/g, '');
                        this.digits[index] = val.slice(-1);
                        event.target.value = this.digits[index];
                        if (val && index < 5) {
                            this.$refs['otpBox' + (index + 1)].focus();
                        }
                    },
                    handleKeydown(index, event) {
                        if (event.key === 'Backspace' && !this.digits[index] && index > 0) {
                            this.$refs['otpBox' + (index - 1)].focus();
                        }
                    },
                    handlePaste(event) {
                        const pasted = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                        pasted.split('').forEach((char, i) => { this.digits[i] = char; });
                        this.$nextTick(() => {
                            const lastIndex = Math.min(pasted.length, 6) - 1;
                            if (lastIndex >= 0) this.$refs['otpBox' + lastIndex].focus();
                        });
                        event.preventDefault();
                    }
                  }"
                  class="space-y-6">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="otp_input" x-bind:value="combined">

                {{-- 6 kotak digit OTP --}}
                <div>
                    <div class="flex items-center justify-center gap-2" @paste="handlePaste">
                        <template x-for="(digit, index) in digits" :key="index">
                            <input type="text"
                                   inputmode="numeric"
                                   autocomplete="one-time-code"
                                   maxlength="1"
                                   x-bind:x-ref="'otpBox' + index"
                                   x-model="digits[index]"
                                   x-on:input="handleInput(index, $event)"
                                   x-on:keydown="handleKeydown(index, $event)"
                                   x-bind:autofocus="index === 0"
                                   class="otp-box">
                        </template>
                    </div>
                    @if ($errors->get('otp_input') || $errors->get('otp_error'))
                        <p class="mt-3 text-center text-sm alert-error font-medium">
                            {{ $errors->first('otp_input') ?? $errors->first('otp_error') }}
                        </p>
                    @endif
                </div>

                {{-- Countdown: progress bar --}}
                <div class="countdown-wrap">
                    <div class="countdown-toprow">
                        <span class="countdown-label">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Sisa waktu
                        </span>
                        <span id="countdown" class="countdown-time">--:--</span>
                    </div>
                    <div class="countdown-track">
                        <div id="countdown-bar" class="countdown-bar"></div>
                    </div>
                </div>

                <button type="submit" class="btn-submit w-full font-bold py-3.5 rounded-xl text-[14.5px] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Verifikasi') }}
                </button>
            </form>

            {{-- <form method="POST" action="{{ route('login.otp-resend.submit', $user->id) }}" class="mt-4 text-center">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button id="btn-resend" type="submit"
                        class="hidden inline-flex items-center gap-1.5 text-sm font-semibold text-[#5FD9E8] hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                    {{ __('Kirim Ulang Kode OTP') }}
                </button>
            </form> --}}

            <div class="divider-line my-7"></div>

            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-[12.5px] text-white/30 hover:text-[#5FD9E8] transition-colors">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <script>
        let expiryTime = new Date("{{ \Carbon\Carbon::parse($user->otp_expires_at)->toIso8601String() }}").getTime();
        let startTime = new Date().getTime();
        let totalDuration = expiryTime - startTime; // dipakai sebagai basis 100% bar

        // Ambang batas warna (bisa disesuaikan)
        const WARNING_MS = 60000; // < 1 menit = oren
        const DANGER_MS  = 20000; // < 20 detik = merah

        let interval = setInterval(function() {
            let now = new Date().getTime();
            let distance = expiryTime - now;

            let countdownEl = document.getElementById("countdown");
            let barEl = document.getElementById("countdown-bar");

            if (distance >= 0) {
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                countdownEl.innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                // Lebar bar mengikuti sisa waktu terhadap durasi total
                let percentage = Math.max(0, Math.min(100, (distance / totalDuration) * 100));
                barEl.style.width = percentage + "%";

                // Reset warna
                barEl.classList.remove("warning", "danger");
                countdownEl.classList.remove("warning", "danger");

                if (distance < DANGER_MS) {
                    barEl.classList.add("danger");
                    countdownEl.classList.add("danger");
                } else if (distance < WARNING_MS) {
                    barEl.classList.add("warning");
                    countdownEl.classList.add("warning");
                }
            } else {
                clearInterval(interval);
                countdownEl.innerHTML = "KADALUWARSA";
                countdownEl.classList.remove("warning");
                countdownEl.classList.add("danger");
                barEl.style.width = "0%";
                barEl.classList.remove("warning");
                barEl.classList.add("danger");
                const resendBtn = document.getElementById("btn-resend");
                if (resendBtn) resendBtn.classList.remove("hidden");
            }
        }, 1000);
    </script>
</body>
</html>