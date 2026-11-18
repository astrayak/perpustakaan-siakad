@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.buku.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Kategori</label>
                    <select name="kategori_id" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Kode Buku</label>
                    <input type="text" name="kode_buku" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" required placeholder="Contoh: BK-001">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-700">Judul Buku</label>
                <input type="text" name="judul" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Penulis</label>
                    <input type="text" name="penulis" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Penerbit</label>
                    <input type="text" name="penerbit" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" placeholder="2024">
                </div>
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Stok Total</label>
                    <input type="number" name="stok_total" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" required min="1" value="1">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm mb-1 text-gray-700">Lokasi Rak</label>
                <input type="text" name="lokasi_rak" class="w-full border rounded p-2 focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Rak A-1">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700">Simpan Buku</button>
            <a href="{{ route('admin.buku.index') }}" class="text-gray-500 hover:underline ml-4 text-sm">Batal</a>
        </form>
    </div>
@endsection