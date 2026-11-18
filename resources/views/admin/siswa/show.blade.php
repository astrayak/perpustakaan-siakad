@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.siswa.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-gray-600 hover:text-[#6C5DD3]">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Profil & Aktivitas Siswa</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kartu Profil Siswa -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 bg-[#FFB319] rounded-full flex items-center justify-center text-white font-bold text-4xl mx-auto mb-4 shadow-lg">
                    {{ substr($siswa->name, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $siswa->name }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ $siswa->email }}</p>

                <div class="bg-gray-50 p-4 rounded-xl text-left text-sm space-y-3">
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500">NIS</span>
                        <span class="font-semibold text-gray-800">{{ $siswa->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500">Kelas</span>
                        <span class="font-semibold text-gray-800">{{ $siswa->kelas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500">No. HP</span>
                        <span class="font-semibold text-gray-800">{{ $siswa->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Alamat</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $siswa->alamat ?? '-' }}</span>
                    </div>
                </div>

                <!-- Total Denda -->
                <div class="mt-4 bg-red-50 p-4 rounded-xl border border-red-100">
                    <p class="text-sm text-red-500 font-medium mb-1">Total Tunggakan Denda</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Peminjaman -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-full">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Peminjaman</h3>
                
                <div class="overflow-y-auto max-h-[500px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-sm font-semibold text-gray-600">Buku</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Tgl Pinjam</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $p)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="p-3">
                                    <div class="font-medium text-gray-800">{{ $p->buku->judul }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->kode_peminjaman }}</div>
                                </td>
                                <td class="p-3 text-sm text-gray-600">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="p-3">
                                    @if($p->status == 'menunggu_diambil')
                                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold">Tunggu</span>
                                    @elseif($p->status == 'dipinjam')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">Dipinjam</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Selesai</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm font-semibold {{ $p->denda > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                    {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-6 text-center text-gray-500">Siswa ini belum pernah meminjam buku.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection