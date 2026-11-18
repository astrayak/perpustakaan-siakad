@php
    $layout = auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.siswa';
@endphp

@extends($layout)

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Profil</h2>

        @if (session('status') === 'profile-updated')
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                Profil berhasil diperbarui!
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- KOLOM KIRI: Form Informasi Profil -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#6C5DD3] to-[#8F82E2] rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->role == 'admin' ? 'Administrator' : 'Siswa' }} • {{ $user->email }}</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required>
                                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- TAMPILKAN HANYA JIKA YANG LOGIN ADALAH SISWA -->
                        @if(auth()->user()->isSiswa())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIS (Nomor Induk Siswa)</label>
                                    <input type="text" name="nis" value="{{ old('nis', $user->nis) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Masukkan NIS">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                                    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Contoh: XII IPA 1">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="08123456789">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                                <textarea name="alamat" rows="3" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        @endif

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white px-8 py-3 rounded-xl font-semibold shadow-md transition-all">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- KOLOM KANAN: Ganti Password & Hapus Akun -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Card Ganti Password -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Card Hapus Akun -->
                <div class="bg-red-50 rounded-3xl p-6 shadow-sm border border-red-100">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>
    </div>
@endsection