<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input form pendaftaran (termasuk nomor_wa yang wajib & unik)
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nomor_wa' => ['required', 'string', 'min:10', 'max:15', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Simpan data user baru ke database beserta atribut tambahannya
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nomor_wa' => $request->nomor_wa,
            'password' => Hash::make($request->password),
            'role'     => 'pelanggan', // Default role: pelanggan
            'status'   => 'aktif',     // Akun otomatis aktif setelah mendaftar
        ]);

        // 3. Pemicu event registrasi bawaan Laravel
        event(new Registered($user));

        // 4. Tidak auto-login: arahkan ke halaman login supaya user memasukkan
        //    kredensialnya sendiri (konsisten dengan alur OTP di AuthenticatedSessionController,
        //    yang butuh proses login manual untuk role tertentu).
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
}