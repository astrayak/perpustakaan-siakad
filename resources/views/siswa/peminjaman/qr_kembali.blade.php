@extends('layouts.siswa')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-3xl shadow-lg border border-gray-100 p-8 text-center mt-6 relative overflow-hidden">
        
        <!-- Ornamen Background (Warna Oranye untuk Pengembalian) -->
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-orange-500 to-amber-400 z-0"></div>

        <div class="relative z-10 pt-4">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md text-orange-500 text-2xl">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
            <h2 class="text-xl font-bold text-white mb-1">QR Pengembalian Buku</h2>
        </div>

        <p class="text-gray-500 text-sm mt-6 mb-6">Tunjukkan QR Code ini ke petugas perpustakaan untuk mengembalikan buku.</p>

        <!-- Kotak QR -->
        <div class="bg-orange-50 p-4 rounded-2xl inline-block mb-6 border-2 border-dashed border-orange-400">
            {!! QrCode::size(220)->margin(1)->generate($peminjaman->qr_token) !!}
        </div>

        <!-- Detail Info -->
        <div class="text-left bg-gray-50 p-5 rounded-2xl text-sm mb-6 border border-gray-100">
            <div class="flex justify-between mb-2 pb-2 border-b border-gray-200">
                <span class="text-gray-500">Kode Pinjam</span>
                <span class="font-bold text-gray-800">{{ $peminjaman->kode_peminjaman }}</span>
            </div>
            <div class="flex justify-between mb-2 pb-2 border-b border-gray-200">
                <span class="text-gray-500">Judul Buku</span>
                <span class="font-bold text-gray-800 text-right">{{ $peminjaman->buku->judul }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Status</span>
                <span class="font-bold text-orange-500">Sedang Dipinjam</span>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('siswa.peminjaman.index') }}" class="inline-block w-full bg-gray-100 text-gray-700 hover:bg-gray-200 py-3 rounded-xl font-semibold transition-all">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Riwayat
        </a>
    </div>
@endsection