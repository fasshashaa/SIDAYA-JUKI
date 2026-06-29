<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Sistem SIDAYA mendeteksi login baru. Silakan masukkan 6 digit kode OTP yang telah dikirimkan demi keamanan akun Anda.') }}
    </div>

    <!-- Menampilkan status kirim ulang -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <!-- Tampilkan Kode OTP Sementara (Untuk mempermudah testing saat develop) -->
    <div class="p-2 mb-4 bg-yellow-100 text-yellow-800 rounded text-center font-mono">
        Development Hint OTP: <strong>{{ $user->otp_code }}</strong>
    </div>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- Input Kode OTP -->
        <div>
            <x-input-label for="otp_code" :value="__('Kode OTP')" />
            <x-text-input id="otp_code" class="block mt-1 w-full text-center font-mono tracking-widest text-xl" type="text" name="otp_code" required autofocus maxlength="6" />
            <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
        </div>

        <div class="mt-4 text-center text-sm text-gray-500">
            Sisa waktu verifikasi: <span id="countdown" class="font-bold text-red-500">--:--</span>
        </div>

        <div class="flex items-center justify-between mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('Verifikasi') }}
            </button>
        </div>
    </form>

    <!-- Tombol Kirim Ulang Terpisah -->
    <form method="POST" action="{{ route('otp.resend') }}" class="mt-4 text-center">
        @csrf
        <button id="btn-resend" type="submit" class="text-sm text-blue-600 hover:underline hidden">
            {{ __('Kirim Ulang Kode OTP') }}
        </button>
    </form>

    <!-- Script Countdown Sisa Waktu -->
    <script>
        // Hitung mundur berdasarkan sisa waktu kedaluwarsa dari database PHP
        let expiryTime = new Date("{{ $user->otp_expires_at }}").getTime();

        let interval = setInterval(function() {
            let now = new Date().getTime();
            let distance = expiryTime - now;

            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasil ke elemen id="countdown"
            document.getElementById("countdown").innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

            // Jika waktu habis
            if (distance < 0) {
                clearInterval(interval);
                document.getElementById("countdown").innerHTML = "KADALUWARSA";
                document.getElementById("btn-resend").classList.remove("hidden"); // Munculkan tombol kirim ulang
            }
        }, 1000);
    </script>
</x-guest-layout>