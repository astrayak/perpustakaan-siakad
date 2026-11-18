<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
        ]);
        $data['slug'] = Str::slug($data['nama_kategori']);
        Kategori::create($data);

        return back()->with('success', 'Kategori ditambahkan');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori dihapus');
    }
}