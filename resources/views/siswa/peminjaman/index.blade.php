@extends('layouts.siswa')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman</h2>
        <p class="text-gray-500 text-sm mt-1">Daftar buku yang pernah dan sedang Anda pinjam.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Buku</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tgl Pinjam</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jatuh Tempo</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                    <tr class="hover:bg-gray-50 border-b border-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $p->buku->judul }}</div>
                            <div class="text-xs text-gray-500">{{ $p->kode_peminjaman }}</div>
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="p-4 text-sm font-medium {{ \Carbon\Carbon::now()->greaterThan($p->tanggal_jatuh_tempo) && $p->status != 'dikembalikan' ? 'text-red-500' : 'text-gray-600' }}">
                            {{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}
                        </td>
                        <td class="p-4">
                            @if($p->status == 'menunggu_diambil')
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Tunggu Diambil</span>
                            @elseif($p->status == 'dipinjam')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Sedang Dipinjam</span>
                            @elseif($p->status == 'dikembalikan')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">{{ $p->status }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            @if($p->status == 'menunggu_diambil')
                                {{-- Tombol QR Pengambilan Buku (Ungu) --}}
                                <a href="{{ route('siswa.peminjaman.qr', $p->id) }}" class="inline-block bg-[#6C5DD3] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#5a4cb1] shadow-sm transition-all">
                                    <i class="fa-solid fa-qrcode mr-1"></i> QR Ambil
                                </a>
                            @elseif($p->status == 'dipinjam' || $p->status == 'terlambat')
                                {{-- Tombol QR Pengembalian Buku (Oranye) --}}
                                <a href="{{ route('siswa.peminjaman.qr_kembali', $p->id) }}" class="inline-block bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 shadow-sm transition-all">
                                    <i class="fa-solid fa-rotate-left mr-1"></i> Kembalikan
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500">
                            <i class="fa-solid fa-clock-rotate-left text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada riwayat peminjaman.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6">{{ $peminjamans->links() }}</div>
@endsection