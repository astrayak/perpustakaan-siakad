@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="mb-4 flex justify-end">
        <!-- Tombol Pemicu Modal -->
        <button onclick="document.getElementById('modalKategori').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
            + Tambah Kategori
        </button>
    </div>

    <!-- Tabel Data Kategori (Full Width) -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Nama Kategori</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Slug</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $k)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 border-b font-medium">{{ $k->nama_kategori }}</td>
                    <td class="p-4 border-b text-gray-500 text-sm">{{ $k->slug }}</td>
                    <td class="p-4 border-b text-center">
                        <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 hover:underline text-sm font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="p-4 text-center text-gray-500">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ================= MODAL KATEGORI ================= -->
    <div id="modalKategori" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
            <!-- Tombol Close (X) -->
            <button onclick="document.getElementById('modalKategori').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
            
            <h3 class="text-xl font-bold mb-4 text-gray-800">Tambah Kategori Baru</h3>
            
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm mb-1 text-gray-700">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm mb-1 text-gray-700">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalKategori').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
@endsection