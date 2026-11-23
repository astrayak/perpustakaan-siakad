@extends('layouts.admin')

@section('title', 'Log History Login')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Riwayat Login Pengguna</h3>
            <p class="text-sm text-gray-500">Mencatat semua aktivitas login dari Admin dan Siswa.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Waktu Login</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama Pengguna</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Role</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">IP Address</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Device / Browser</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 border-b border-gray-50 transition-colors">
                        <td class="p-4 text-sm text-gray-700">
                            {{ $log->login_at->format('d M Y, H:i:s') }}
                            <div class="text-xs text-gray-400">{{ $log->login_at->diffForHumans() }}</div>
                        </td>
                        <td class="p-4 font-medium text-gray-800 flex items-center gap-3">
                            <div class="w-8 h-8 {{ $log->role == 'admin' ? 'bg-[#6C5DD3]' : 'bg-[#FFB319]' }} rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ substr($log->name, 0, 1) }}
                            </div>
                            {{ $log->name }}
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $log->role == 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ strtoupper($log->role) }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-600 font-mono">{{ $log->ip_address ?? '-' }}</td>
                        <td class="p-4 text-xs text-gray-500 max-w-xs truncate" title="{{ $log->user_agent }}">
                            {{ $log->user_agent ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            <i class="fa-solid fa-ghost text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada riwayat login.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
@endsection