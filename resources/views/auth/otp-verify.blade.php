<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Sistem SIDAYA mendeteksi login baru. Silakan masukkan 6 digit kode OTP yang telah dikirimkan demi keamanan akun Anda.') }}
    </div>

    @if (session('status') || session('info'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') ?? session('info') }}
        </div>
    @endif

    <!-- @if($user->otp_code)
        <div class="p-2 mb-4 bg-yellow-100 text-yellow-800 rounded text-center font-mono text-sm">
            Development Hint OTP: <strong>{{ $user->otp_code }}</strong>
        </div>
    @endif -->

   <form method="POST" action="{{ route('login.otp-verify.submit', $user->id) }}" class="space-y-4">
    @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div>
            <x-input-label for="otp_input" :value="__('Kode OTP')" />
            <x-text-input id="otp_input" class="block mt-1 w-full text-center font-mono tracking-widest text-xl" type="text" name="otp_input" required autofocus maxlength="6" />
            
            <x-input-error :messages="$errors->get('otp_input') ?? $errors->get('otp_error')" class="mt-2" />
        </div>

        <div class="mt-4 text-center text-sm text-gray-500">
            Sisa waktu verifikasi: <span id="countdown" class="font-bold text-red-500">--:--</span>
        </div>

        <div class="flex items-center justify-between mt-4">
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                {{ __('Verifikasi') }}
            </button>
        </div>
    </form>

    <form method="POST" action="#" class="mt-4 text-center">
        @csrf
        <button id="btn-resend" type="submit" class="text-sm text-blue-600 hover:underline hidden">
            {{ __('Kirim Ulang Kode OTP') }}
        </button>
    </form>

    <script>
        let expiryTime = new Date("{{ \Carbon\Carbon::parse($user->otp_expires_at)->toIso8601String() }}").getTime();

        let interval = setInterval(function() {
            let now = new Date().getTime();
            let distance = expiryTime - now;

            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

            if (distance < 0) {
                clearInterval(interval);
                document.getElementById("countdown").innerHTML = "KADALUWARSA";
                document.getElementById("btn-resend").classList.remove("hidden");
            }
        }, 1000);
    </script>
</x-guest-layout>