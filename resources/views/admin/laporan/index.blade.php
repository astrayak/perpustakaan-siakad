@extends('layouts.admin')
@section('title', 'Menu Laporan')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold mb-4">Laporan Data Buku</h3>
            <a href="{{ route('admin.laporan.cetak', ['jenis' => 'buku']) }}" target="_blank" class="bg-[#6C5DD3] text-white px-4 py-2 rounded-lg">Cetak PDF</a>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold mb-4">Laporan Data Siswa</h3>
            <a href="{{ route('admin.laporan.cetak', ['jenis' => 'siswa']) }}" target="_blank" class="bg-[#6C5DD3] text-white px-4 py-2 rounded-lg">Cetak PDF</a>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold mb-4">Laporan Peminjaman</h3>
            <a href="{{ route('admin.laporan.cetak', ['jenis' => 'peminjaman']) }}" target="_blank" class="bg-[#6C5DD3] text-white px-4 py-2 rounded-lg">Cetak PDF</a>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold mb-4">Laporan Pendapatan Denda</h3>
            <a href="{{ route('admin.laporan.cetak', ['jenis' => 'pendapatan']) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg">Cetak PDF</a>
        </div>
    </div>
@endsection