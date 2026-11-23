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

    <!-- DAFTAR REQUEST PASSWORD -->
    @php $reqs = \App\Models\PasswordRequest::where('status', 'pending')->get(); @endphp
    @if($reqs->count() > 0)
        <div class="bg-orange-50 rounded-xl p-4 mb-6 border border-orange-200">
            <h4 class="font-bold text-orange-800 mb-3"><i class="fa-solid fa-key"></i> Permintaan Reset Password</h4>
            <div class="flex flex-wrap gap-3">
                @foreach($reqs as $req)
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-orange-100 flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">NIS: {{ $req->nis }}</span>
                        <!-- Tombol memicu form input password baru -->
                        <form action="{{ route('admin.password.request.process', $req->id) }}" method="POST" onsubmit="return promptPassword(this);">
                            @csrf @method('PATCH')
                            <input type="hidden" name="new_password" class="new-password-input">
                            <button type="submit" class="bg-orange-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-orange-600 font-bold">Reset Sekarang</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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
                        <a href="{{ route('admin.siswa.show', $s->id) }}" class="inline-block bg-indigo-50 text-[#6C5DD3] hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors mr-1">Aktivitas</a>
                        <a href="{{ route('admin.siswa.edit', $s->id) }}" class="inline-block bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors mr-1">Edit</a>
                        
                        <!-- Tombol reset memicu form input password baru -->
                        <form action="{{ route('admin.siswa.reset', $s->id) }}" method="POST" class="inline" onsubmit="return promptPassword(this);">
                            @csrf @method('PATCH')
                            <input type="hidden" name="new_password" class="new-password-input">
                            <button type="submit" class="bg-orange-50 text-orange-600 hover:bg-orange-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors">Reset Pass</button>
                        </form>
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

@push('scripts')
<script>
    function promptPassword(form) {
        Swal.fire({
            title: 'Masukkan Password Baru',
            input: 'text',
            inputLabel: 'Password baru untuk siswa ini',
            inputPlaceholder: 'Ketik minimal 6 karakter',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#6C5DD3',
            inputValidator: (value) => {
                if (!value || value.length < 6) {
                    return 'Password minimal 6 karakter!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Masukkan password yang diketik ke dalam form tersembunyi
                form.querySelector('.new-password-input').value = result.value;
                form.submit(); // Kirim form ke controller
            }
        });
        return false; // Mencegah form submit bawaan
    }
</script>
@endpush