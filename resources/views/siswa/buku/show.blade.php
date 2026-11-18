@extends('layouts.siswa')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('siswa.buku.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-gray-600 hover:text-[#6C5DD3] transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Detail Buku</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Kolom Kiri: Foto -->
            <div class="w-full md:w-1/3 shrink-0">
                <div class="w-full aspect-[3/4] bg-gray-100 rounded-2xl overflow-hidden shadow-md flex items-center justify-center text-gray-300">
                    @if($buku->cover_url)
                        <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-book text-8xl"></i>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan: Info & Sinopsis -->
            <div class="w-full md:w-2/3 flex flex-col">
                <span class="bg-indigo-50 text-[#6C5DD3] text-sm font-bold px-3 py-1 rounded-lg w-fit mb-3">
                    {{ $buku->kategori->nama_kategori }}
                </span>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $buku->judul }}</h1>
                <p class="text-lg text-gray-600 mb-6">{{ $buku->penulis }}</p>

                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-gray-500 mb-1">Penerbit</p>
                        <p class="font-semibold text-gray-800">{{ $buku->penerbit ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-gray-500 mb-1">Tahun Terbit</p>
                        <p class="font-semibold text-gray-800">{{ $buku->tahun_terbit ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-gray-500 mb-1">Lokasi Rak</p>
                        <p class="font-semibold text-gray-800">{{ $buku->lokasi_rak ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-gray-500 mb-1">Stok Tersedia</p>
                        <p class="font-bold text-[#6C5DD3] text-lg">{{ $buku->stok_tersedia }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-b pb-2">Sinopsis Buku</h3>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        {{ $buku->deskripsi ?? 'Belum ada sinopsis untuk buku ini.' }}
                    </p>
                </div>

                <!-- Tombol Pinjam -->
                <div class="mt-auto">
                    @if($buku->stok_tersedia > 0)
                        <form action="{{ route('siswa.peminjaman.pinjam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                            <button type="submit" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white py-4 rounded-xl font-bold text-lg shadow-lg transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-hand-holding-hand"></i> Pinjam Buku Sekarang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 py-4 rounded-xl font-bold text-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection