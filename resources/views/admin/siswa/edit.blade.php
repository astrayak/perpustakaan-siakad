@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.siswa.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-gray-600 hover:text-[#6C5DD3]">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Edit Data Siswa</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $siswa->name) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $siswa->email) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NIS (Nomor Induk Siswa)</label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                        @error('nis') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                        @error('kelas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">
                    @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">{{ old('alamat', $siswa->alamat) }}</textarea>
                    @error('alamat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                                <!-- Input Tahun Lulus -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Lulus (Auto Nonaktif)</label>
                    <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $siswa->tahun_lulus) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Contoh: 2027">
                    <p class="text-xs text-gray-500 mt-1">Akun akan otomatis dinonaktifkan pada Juli di tahun ini.</p>
                </div>

                <!-- Status Akun -->
                <div class="mb-6 bg-red-50 p-4 rounded-xl border border-red-100 flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-semibold text-red-700">Nonaktifkan Akun</label>
                        <p class="text-xs text-red-500">Siswa tidak akan bisa login.</p>
                    </div>
                    <select name="is_active" class="border rounded-xl p-2 bg-white font-semibold focus:outline-none">
                        <option value="1" {{ $siswa->is_active ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$siswa->is_active ? 'selected' : '' }}>Nonaktif (Banned)</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-3">
                    <button type="submit" class="bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white px-8 py-3 rounded-xl shadow-md font-semibold transition-all">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-800 font-medium px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection