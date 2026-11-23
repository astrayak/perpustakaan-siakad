@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
    <!-- TAB FILTER STATUS -->
    <div class="mb-4 flex space-x-2 border-b border-gray-200 overflow-x-auto pb-2">
        @php
            $tabs = [
                'semua' => 'Semua',
                'menunggu_diambil' => 'Tunggu Diambil',
                'dipinjam' => 'Dipinjam',
                'dikembalikan' => 'Dikembalikan',
                'terlambat' => 'Terlambat',
                'dibatalkan' => 'Dibatalkan',
                'denda' => 'Denda' 
            ];
        @endphp
        
        @foreach($tabs as $key => $label)
            <a href="{{ route('admin.peminjaman.index', ['status' => $key]) }}" 
               class="px-5 py-2.5 rounded-t-xl font-semibold text-sm transition-all whitespace-nowrap
               {{ $status == $key 
                    ? 'bg-[#6C5DD3] text-white shadow-md' 
                    : 'bg-white text-gray-600 hover:bg-gray-100 border border-transparent' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- FORM FILTER TANGGAL & URUTAN -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <!-- Simpan status tab saat ini agar tidak hilang -->
            <input type="hidden" name="status" value="{{ $status }}">
            
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Urutkan Tanggal</label>
                <select name="sort" class="w-full border rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
                    <option value="terbaru" {{ $sort == 'terbaru' ? 'selected' : '' }}>Terbaru (Hari Ini)</option>
                    <option value="terlama" {{ $sort == 'terlama' ? 'selected' : '' }}>Terlama (Awal)</option>
                </select>
            </div>

            <div class="w-full md:w-1/4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
            </div>

            <div class="w-full md:w-1/4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
            </div>

            <div class="w-full md:w-1/4 flex gap-2">
                <button type="submit" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white font-semibold px-4 py-2.5 rounded-xl shadow-md transition-all">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.peminjaman.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2.5 rounded-xl transition-all" title="Reset Filter">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- TABEL DATA -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Kode</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Peminjam</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Buku</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tgl Pinjam</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jatuh Tempo</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Denda</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                    <tr class="hover:bg-gray-50 border-b border-gray-50 transition-colors">
                        <td class="p-4 text-sm font-medium text-gray-800">{{ $p->kode_peminjaman }}</td>
                        <td class="p-4 text-gray-600">{{ $p->user->name }}</td>
                        <td class="p-4 text-gray-600">{{ $p->buku->judul }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="p-4 text-sm font-semibold {{ \Carbon\Carbon::now()->greaterThan($p->tanggal_jatuh_tempo) && $p->status != 'dikembalikan' ? 'text-red-500' : 'text-gray-600' }}">
                            {{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold 
                                @if($p->status == 'menunggu_diambil') bg-yellow-100 text-yellow-800
                                @elseif($p->status == 'dipinjam') bg-blue-100 text-blue-800
                                @elseif($p->status == 'dikembalikan') bg-green-100 text-green-800
                                @elseif($p->status == 'terlambat') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ str_replace('_', ' ', strtoupper($p->status)) }}
                            </span>
                        </td>
                        <td class="p-4 text-sm font-bold {{ $p->denda > 0 ? 'text-red-600' : 'text-gray-400' }}">
                            {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}
                        </td>
                        <td class="p-4 text-center">
                            @if($p->denda > 0)
                                @if($p->denda_dibayar)
                                    <span class="text-green-600 text-sm font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-check-circle"></i> Lunas
                                    </span>
                                @else
                                    <form action="{{ route('admin.peminjaman.bayar', $p->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran denda?');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition-all">
                                            Bayar Denda
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-10 text-center text-gray-500">
                            <i class="fa-solid fa-folder-open text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada data peminjaman untuk filter ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination dengan mempertahankan filter -->
    <div class="mt-4">{{ $peminjamans->links() }}</div>
@endsection