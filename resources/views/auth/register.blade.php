<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fe; }
    </style>
        <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden py-10">
    
    <!-- Ornamen Background (Efek Blur) -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[#6C5DD3] rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-[#FFB319] rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

    <div class="max-w-lg w-full relative z-10">
        <!-- Logo & Judul -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-[#6C5DD3] to-[#8F82E2] rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg mx-auto mb-4 transform -rotate-3">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Buat Akun Siswa</h1>
            <p class="text-gray-500 mt-1 text-sm">Lengkapi data diri Anda untuk meminjam buku</p>
        </div>

        <!-- Card Form Register -->
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Input Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fa-regular fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="w-full border rounded-xl py-2.5 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all text-sm" 
                            placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Grid NIS dan Kelas -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nis" class="block text-sm font-semibold text-gray-700 mb-1">NIS</label>
                        <div class="relative">
                            <i class="fa-solid fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="nis" type="text" name="nis" value="{{ old('nis') }}" required
                                class="w-full border rounded-xl py-2.5 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all text-sm" 
                                placeholder="Nomor Induk Siswa">
                        </div>
                        @error('nis') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                        <div class="relative">
                            <i class="fa-solid fa-door-open absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" required
                                class="w-full border rounded-xl py-2.5 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all text-sm" 
                                placeholder="Contoh: XII IPA 1">
                        </div>
                        @error('kelas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full border rounded-xl py-2.5 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all text-sm" 
                            placeholder="email@sekolah.com">
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full border rounded-xl py-2.5 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all text-sm" 
                            placeholder="Minimal 8 karakter">
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full border rounded-xl py-2.5 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all text-sm" 
                            placeholder="Ulangi password">
                    </div>
                </div>

                <!-- Tombol Daftar -->
                <button type="submit" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white font-bold py-3 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Link Login -->
            <div class="text-center mt-6 pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-[#6C5DD3] font-bold hover:underline">Log In di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>