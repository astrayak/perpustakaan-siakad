<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->latest();
        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_buku', 'like', '%' . $request->search . '%');
        }
        $bukus = $query->paginate(10);
        $kategoris = Kategori::all();
        return view('admin.buku.index', compact('bukus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id', 'kode_buku' => 'required|unique:bukus,kode_buku',
            'judul' => 'required', 'penulis' => 'required', 'stok_total' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_digital' => 'nullable|mimes:pdf|max:10240',
        ]);
        if ($request->hasFile('cover')) $data['cover'] = $request->file('cover')->store('covers', 'public');
        if ($request->hasFile('file_digital')) {
            $data['file_digital'] = $request->file('file_digital')->store('books', 'public');
            $data['is_digital'] = true;
        }
        $data['stok_tersedia'] = $data['stok_total'];
        Buku::create($data);
        return redirect()->route('admin.buku.index')->with('success', 'Buku ditambahkan');
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id', 'kode_buku' => 'required|unique:bukus,kode_buku,' . $buku->id,
            'judul' => 'required', 'penulis' => 'required', 'stok_total' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_digital' => 'nullable|mimes:pdf|max:10240',
        ]);
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) Storage::disk('public')->delete($buku->cover);
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }
        if ($request->hasFile('file_digital')) {
            if ($buku->file_digital && Storage::disk('public')->exists($buku->file_digital)) Storage::disk('public')->delete($buku->file_digital);
            $data['file_digital'] = $request->file('file_digital')->store('books', 'public');
            $data['is_digital'] = true;
        }
        $data['stok_tersedia'] = $data['stok_total'];
        $buku->update($data);
        return redirect()->route('admin.buku.index')->with('success', 'Buku diperbarui');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete(); // Soft delete
        return back()->with('success', 'Buku dihapus');
    }
}