<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $query = Buku::with('kategori')->where('stok_tersedia', '>', 0);

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bukus = $query->latest()->paginate(12);
        return view('siswa.buku.index', compact('bukus', 'kategoris'));
    }

    public function show(Buku $buku)
    {
        return view('siswa.buku.show', compact('buku'));
    }
}