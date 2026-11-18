@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    
    <!-- Banner Selamat Datang -->
    <div class="bg-gradient-to-r from-[#6C5DD3] to-[#8F82E2] rounded-3xl p-8 text-white mb-8 relative overflow-hidden shadow-lg">
        <div class="relative z-10 md:w-2/3">
            <h2 class="text-3xl font-bold mb-2">Halo, Admin!</h2>
            <p class="text-white/80">Selamat datang kembali di Sistem Perpustakaan. Berikut adalah ringkasan data hari ini.</p>
        </div>
        <!-- Ikon Ilustrasi -->
        <i class="fa-solid fa-book-bookmark absolute right-10 -bottom-4 text-9xl text-white/10 z-0"></i>
    </div>

    <!-- Kartu Statistik (Warna-warni) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Kartu Total Buku (Ungu) -->
        <div class="bg-gradient-to-br from-[#6C5DD3] to-[#8F82E2] rounded-2xl p-6 text-white shadow-md relative overflow-hidden group hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <i class="fa-solid fa-book text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $totalBuku }}</h3>
            <p class="text-white/80 font-medium">Buku Terdaftar</p>
        </div>

        <!-- Kartu Total Siswa (Kuning/Orange) -->
        <div class="bg-gradient-to-br from-[#FFB319] to-[#FFCE56] rounded-2xl p-6 text-white shadow-md relative overflow-hidden group hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Siswa</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $totalSiswa }}</h3>
            <p class="text-white/80 font-medium">Siswa Aktif</p>
        </div>

        <!-- Kartu Menunggu Diambil (Merah/Coral) -->
        <div class="bg-gradient-to-br from-[#FF7A59] to-[#FF9D85] rounded-2xl p-6 text-white shadow-md relative overflow-hidden group hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <i class="fa-solid fa-clock text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Antrean</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $menungguDiambil }}</h3>
            <p class="text-white/80 font-medium">Menunggu Diambil</p>
        </div>

        <!-- Kartu Sedang Dipinjam (Cyan/Tosca) -->
        <div class="bg-gradient-to-br from-[#00C6FF] to-[#00E0FF] rounded-2xl p-6 text-white shadow-md relative overflow-hidden group hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <i class="fa-solid fa-hand-holding-hand text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Aktif</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $sedangDipinjam }}</h3>
            <p class="text-white/80 font-medium">Sedang Dipinjam</p>
        </div>

    </div>

    <!-- Area Bawah (Bisa untuk grafik atau info tambahan) -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 h-64 flex flex-col items-center justify-center text-center">
        <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-4">
            <i class="fa-solid fa-chart-line text-2xl"></i>
        </div>
        <h4 class="text-lg font-bold text-gray-800 mb-2">Grafik Peminjaman</h4>
        <p class="text-gray-500 text-sm max-w-md">Area ini siap diisi dengan grafik statistik peminjaman buku (misalnya menggunakan library Chart.js) jika dibutuhkan nanti.</p>
    </div>

@endsection