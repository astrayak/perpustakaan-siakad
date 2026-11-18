<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $menungguDiambil = Peminjaman::where('status', 'menunggu_diambil')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        return view('admin.dashboard', compact(
            'totalBuku', 'totalSiswa', 'menungguDiambil', 'sedangDipinjam'
        ));
    }
}