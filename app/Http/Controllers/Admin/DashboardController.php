<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\ScanLog;
use App\Models\PasswordRequest;
use App\Models\LoginLog; // Tambahkan Model LoginLog
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik
        $totalBuku = Buku::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $menungguDiambil = Peminjaman::where('status', 'menunggu_diambil')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // 2. Data Grafik
        $topBuku = Peminjaman::select('buku_id', DB::raw('count(*) as total'))->with('buku')
            ->groupBy('buku_id')->orderByDesc('total')->limit(5)->get();

        $topSiswa = Peminjaman::select('user_id', DB::raw('count(*) as total'))->with('user')
            ->groupBy('user_id')->orderByDesc('total')->limit(5)->get();

        $tahunSekarang = Carbon::now()->year;
        $tahunAwal = $tahunSekarang - 4;
        $peminjamanTahunan = Peminjaman::select(DB::raw('YEAR(created_at) as tahun'), DB::raw('count(*) as total'))
            ->whereYear('created_at', '>=', $tahunAwal)->groupBy('tahun')->orderBy('tahun')->get();

        $labelsTahun = []; 
        $dataTahun = [];
        for ($i = $tahunAwal; $i <= $tahunSekarang; $i++) {
            $labelsTahun[] = (string)$i;
            $match = $peminjamanTahunan->firstWhere('tahun', $i);
            $dataTahun[] = $match ? $match->total : 0;
        }

        // 3. Data Log Terbaru (Scan)
        $recentLogs = ScanLog::with(['peminjaman.buku', 'admin'])->latest()->take(5)->get();

        // 4. Data Request Password
        $passwordRequests = PasswordRequest::where('status', 'pending')->latest()->get();

        // 5. Data Log Login Terbaru (Fitur Baru)
        // Diletakkan sebelum return view
        $recentLogins = LoginLog::latest('login_at')->take(10)->get();

        // 6. Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalBuku', 'totalSiswa', 'menungguDiambil', 'sedangDipinjam',
            'topBuku', 'topSiswa', 'labelsTahun', 'dataTahun', 'recentLogs', 'passwordRequests', 'recentLogins'
        ));
    }
}