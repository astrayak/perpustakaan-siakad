<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validasi NIS dan Kelas
            'nis' => ['required', 'string', 'max:50', 'unique:'.User::class],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'role' => 'siswa', // Otomatis menjadi siswa
        ]);

        event(new Registered($user));

        // --- PERUBAHAN DI SINI ---
        // Tidak menggunakan Auth::login($user) agar tidak otomatis masuk.
        // Dialihkan ke halaman login dengan pesan sukses.
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Silakan login dengan akun baru Anda.');
    }
}