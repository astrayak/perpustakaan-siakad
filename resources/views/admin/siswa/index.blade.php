@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Siswa Terdaftar</h2>
        
        <!-- Form Pencarian -->
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIS, atau Kelas..." class="border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] w-64 bg-white">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-xl"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Nama Siswa</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">NIS</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Kelas</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">No. HP</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $s)
                <tr class="hover:bg-gray-50 border-b border-gray-50 transition-colors">
                    <td class="p-4 font-medium text-gray-800 flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#FFB319] rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($s->name, 0, 1) }}
                        </div>
                        {{ $s->name }}
                    </td>
                    <td class="p-4 text-gray-600">{{ $s->nis ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ $s->kelas ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ $s->no_hp ?? '-' }}</td>
                    <td class="p-4 text-center">
                        <!-- Tombol Aktivitas -->
                        <a href="{{ route('admin.siswa.show', $s->id) }}" class="inline-block bg-indigo-50 text-[#6C5DD3] hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors mr-1">
                            Aktivitas
                        </a>
                        <!-- Tombol Edit -->
                        <a href="{{ route('admin.siswa.edit', $s->id) }}" class="inline-block bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-500">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $siswas->links() }}</div>
@endsection