@extends('layouts.admin')

@section('title', 'Edit Buku')

@section('content')
    <div class="max-w-2xl bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Kategori</label>
                    <select name="kategori_id" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ $buku->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ $buku->kode_buku }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Judul Buku</label>
                <input type="text" name="judul" value="{{ $buku->judul }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Penulis</label>
                    <input type="text" name="penulis" value="{{ $buku->penulis }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ $buku->penerbit }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Stok Total</label>
                    <input type="number" name="stok_total" value="{{ $buku->stok_total }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required min="1">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Lokasi Rak</label>
                <input type="text" name="lokasi_rak" value="{{ $buku->lokasi_rak }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
            </div>

            <!-- INPUT SINOPSIS -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Sinopsis / Deskripsi Buku</label>
                <textarea name="deskripsi" rows="4" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Tuliskan ringkasan cerita...">{{ $buku->deskripsi }}</textarea>
            </div>

            <!-- INPUT FOTO COVER (Untuk Edit) -->
            <div class="mb-6 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Ganti Foto Cover (Opsional)</label>
                @if($buku->cover_url)
                    <img src="{{ $buku->cover_url }}" class="w-20 h-28 object-cover rounded-lg mb-3 shadow-sm border border-gray-200">
                @endif
                <input type="file" name="cover" accept="image/*" class="w-full border rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#6C5DD3] file:text-white hover:file:bg-[#5a4cb1]">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white px-8 py-3 rounded-xl shadow-md font-semibold transition-all">Update Buku</button>
                <a href="{{ route('admin.buku.index') }}" class="text-gray-500 hover:text-gray-800 font-medium px-4">Batal</a>
            </div>
        </form>
    </div>
@endsection