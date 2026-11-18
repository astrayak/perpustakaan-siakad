@extends('layouts.admin')

@section('title', 'Data Buku')

@section('content')
    <div class="mb-4 flex justify-end">
        <!-- Tombol Pemicu Modal -->
        <button onclick="document.getElementById('modalBuku').classList.remove('hidden')" class="bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white px-5 py-2.5 rounded-xl shadow-md font-semibold transition-all">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Buku
        </button>
    </div>

    <!-- Tabel Data Buku -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Cover</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Judul Buku</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Penulis</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Stok</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Tersedia</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $b)
                    <tr class="hover:bg-gray-50 border-b border-gray-50 transition-colors">
                        <td class="p-4">
                            @if($b->cover_url)
                                <img src="{{ $b->cover_url }}" alt="Cover" class="w-12 h-16 object-cover rounded-md shadow-sm">
                            @else
                                <div class="w-12 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-book"></i>
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-medium text-gray-800">{{ $b->judul }}</td>
                        <td class="p-4 text-sm text-gray-500">
                            <span class="bg-indigo-50 text-[#6C5DD3] px-2 py-1 rounded-md">{{ $b->kategori->nama_kategori }}</span>
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $b->penulis }}</td>
                        <td class="p-4 text-center text-sm">{{ $b->stok_total }}</td>
                        <td class="p-4 text-center font-bold text-[#6C5DD3]">{{ $b->stok_tersedia }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.buku.edit', $b->id) }}" class="inline-block text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors mr-1">Edit</a>
                            <form action="{{ route('admin.buku.destroy', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus buku ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-8 text-center text-gray-500">Belum ada data buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $bukus->links() }}</div>

    <!-- ================= MODAL TAMBAH BUKU ================= -->
    <div id="modalBuku" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl p-8 relative max-h-[90vh] overflow-y-auto m-4">
            <button onclick="document.getElementById('modalBuku').classList.add('hidden')" class="absolute top-5 right-6 text-gray-400 hover:text-gray-800 text-2xl font-bold transition-colors">&times;</button>
            
            <h3 class="text-2xl font-bold mb-6 text-gray-800">Tambah Buku Baru</h3>
            
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Kategori</label>
                        <select name="kategori_id" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Kode Buku</label>
                        <input type="text" name="kode_buku" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required placeholder="Contoh: BK-001">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Judul Buku</label>
                    <input type="text" name="judul" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Penulis</label>
                        <input type="text" name="penulis" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="2024">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Stok Total</label>
                        <input type="number" name="stok_total" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required min="1" value="1">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Lokasi Rak</label>
                    <input type="text" name="lokasi_rak" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Contoh: Rak A-1">
                </div>

                <!-- INPUT SINOPSIS -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Sinopsis / Deskripsi Buku</label>
                    <textarea name="deskripsi" rows="4" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Tuliskan ringkasan cerita atau deskripsi buku di sini..."></textarea>
                </div>

                <!-- INPUT FOTO COVER -->
                <div class="mb-6 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Foto Cover (Opsional)</label>
                    <input type="file" name="cover" accept="image/*" class="w-full border rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#6C5DD3] file:text-white hover:file:bg-[#5a4cb1]">
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalBuku').classList.add('hidden')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-xl font-semibold transition-all">Batal</button>
                    <button type="submit" class="bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white px-8 py-2.5 rounded-xl shadow-md font-semibold transition-all">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
@endsection