@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Kode</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Peminjam</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Buku</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Tgl Pinjam</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 border-b text-sm font-semibold text-gray-600">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 border-b text-sm font-medium">{{ $p->kode_peminjaman }}</td>
                    <td class="p-4 border-b">{{ $p->user->name }}</td>
                    <td class="p-4 border-b">{{ $p->buku->judul }}</td>
                    <td class="p-4 border-b">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="p-4 border-b">
                        @if($p->status == 'menunggu_diambil')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">Tunggu Diambil</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">Dipinjam</span>
                        @else
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">Selesai</span>
                        @endif
                    </td>
                    <td class="p-4 border-b text-red-600 font-semibold">
                        {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-4 text-center text-gray-500">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $peminjamans->links() }}</div>
@endsection