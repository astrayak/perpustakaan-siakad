<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CekStatusSiswa
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isSiswa()) {
            $user = auth()->user();

            // 1. Cek jika akun dinonaktifkan manual oleh admin
            if (!$user->is_active) {
                auth()->logout();
                return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan oleh Admin.']);
            }

            // 2. Cek Auto-Expired berdasarkan tahun lulus
            // Jika tahun lulus sudah lewat dari bulan Juni tahun ini
            if ($user->tahun_lulus && Carbon::now()->greaterThan(Carbon::create($user->tahun_lulus, 6, 30))) {
                $user->update(['is_active' => false]); // Matikan akun
                auth()->logout();
                return redirect()->route('login')->withErrors(['email' => 'Masa aktif sekolah Anda telah berakhir. Akun dinonaktifkan otomatis.']);
            }
        }

        return $next($request);
    }
}