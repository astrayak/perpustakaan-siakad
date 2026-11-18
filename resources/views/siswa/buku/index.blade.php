@extends('layouts.siswa')

@section('content')
    <!-- Banner Selamat Datang -->
    <div class="bg-gradient-to-r from-[#6C5DD3] to-[#8F82E2] rounded-3xl p-8 text-white mb-8 relative overflow-hidden shadow-lg flex justify-between items-center">
        <div class="relative z-10 md:w-2/3">
            <h2 class="text-3xl font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-white/80">Mau baca buku apa hari ini? Temukan buku favoritmu dan pinjam sekarang.</p>
        </div>
        <i class="fa-solid fa-book-open-reader absolute right-10 -bottom-4 text-8xl text-white/10 z-0"></i>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Katalog Buku</h3>
    </div>

    <!-- Grid Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($bukus as $buku)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow group">
                
                <!-- AREA FOTO COVER (Bisa Diklik) -->
                <a href="{{ route('siswa.buku.show', $buku->id) }}" class="h-56 bg-gray-100 flex items-center justify-center text-gray-300 relative overflow-hidden block">
                    @if($buku->cover_url)
                        <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <i class="fa-solid fa-book text-6xl group-hover:scale-110 transition-transform duration-300"></i>
                    @endif
                    
                    <!-- Badge Kategori -->
                    <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-[#6C5DD3] text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm z-10">
                        {{ $buku->kategori->nama_kategori }}
                    </span>
                </a>
                
                <!-- DETAIL BUKU -->
                <div class="p-5 flex-1 flex flex-col">
                    <!-- Judul Bisa Diklik -->
                    <a href="{{ route('siswa.buku.show', $buku->id) }}" class="hover:text-[#6C5DD3] transition-colors">
                        <h3 class="font-bold text-lg text-gray-800 leading-tight mb-1 line-clamp-2" title="{{ $buku->judul }}">{{ $buku->judul }}</h3>
                    </a>
                    <p class="text-sm text-gray-500 mb-1">{{ $buku->penulis }}</p>
                    <p class="text-xs text-gray-400 mb-4">{{ $buku->penerbit }} {{ $buku->tahun_terbit ? '('.$buku->tahun_terbit.')' : '' }}</p>
                    
                    <div class="mt-auto flex items-center justify-between mb-4">
                        <span class="text-xs text-gray-400">Stok Tersedia</span>
                        <span class="bg-indigo-50 text-[#6C5DD3] font-bold text-sm px-3 py-1 rounded-lg">
                            {{ $buku->stok_tersedia }}
                        </span>
                    </div>
                    
                    <!-- Tombol Pinjam -->
                    <form action="{{ route('siswa.peminjaman.pinjam') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                        <button type="submit" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white py-2.5 rounded-xl font-semibold shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-hand-holding-hand"></i> Pinjam Buku
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-10 rounded-2xl text-center border border-gray-100">
                <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-bold text-gray-700">Belum ada buku</h3>
                <p class="text-gray-500">Katalog buku masih kosong atau stok sedang habis.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $bukus->links() }}
    </div>
@endsection