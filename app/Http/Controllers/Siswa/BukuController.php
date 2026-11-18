<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')
            ->where('stok_tersedia', '>', 0)
            ->latest()
            ->paginate(12);
            
        return view('siswa.buku.index', compact('bukus'));
    }

    public function show(Buku $buku)
    {
        return view('siswa.buku.show', compact('buku'));
    }
}