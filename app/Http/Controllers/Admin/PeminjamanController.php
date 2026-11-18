<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->paginate(15);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }
}