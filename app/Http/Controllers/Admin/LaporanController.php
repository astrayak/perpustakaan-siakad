<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() { return view('admin.laporan.index'); }

    public function cetak(Request $request)
    {
        $jenis = $request->jenis;
        $data = [];
        if ($jenis == 'buku') $data = Buku::with('kategori')->get();
        elseif ($jenis == 'siswa') $data = User::where('role', 'siswa')->get();
        elseif ($jenis == 'peminjaman') $data = Peminjaman::with(['user', 'buku'])->get();
        elseif ($jenis == 'pendapatan') $data = Peminjaman::where('denda_dibayar', true)->with(['user', 'buku'])->get();
        return view('admin.laporan.cetak', compact('jenis', 'data'));
    }
}