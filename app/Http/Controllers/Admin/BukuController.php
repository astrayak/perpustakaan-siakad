<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->paginate(10);
        $kategoris = Kategori::all();
        return view('admin.buku.index', compact('bukus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_buku' => 'required|unique:bukus,kode_buku',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'nullable',
            'tahun_terbit' => 'nullable|integer',
            'isbn' => 'nullable',
            'deskripsi' => 'nullable',
            'stok_total' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Gambar
        ]);

        // Logika Upload Foto
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $data['stok_tersedia'] = $data['stok_total'];
        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku ditambahkan');
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_buku' => 'required|unique:bukus,kode_buku,' . $buku->id,
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'nullable',
            'tahun_terbit' => 'nullable|integer',
            'isbn' => 'nullable',
            'deskripsi' => 'nullable',
            'stok_total' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Logika Update Foto
        if ($request->hasFile('cover')) {
            // Hapus foto lama jika ada
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $data['stok_tersedia'] = $data['stok_total'];
        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku diperbarui');
    }

    public function destroy(Buku $buku)
    {
        // Hapus foto saat data buku dihapus
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();
        return back()->with('success', 'Buku dihapus');
    }
}