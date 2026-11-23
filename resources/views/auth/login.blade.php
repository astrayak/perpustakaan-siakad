<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fe; }
    </style>
        <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Ornamen Background (Efek Blur) -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[#6C5DD3] rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-[#FFB319] rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

    <div class="max-w-md w-full relative z-10">
        <!-- Logo & Judul -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-[#6C5DD3] to-[#8F82E2] rounded-3xl flex items-center justify-center text-white text-3xl font-bold shadow-lg mx-auto mb-4 transform rotate-3">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>
            <p class="text-gray-500 mt-2">Silakan login ke Sistem Perpustakaan</p>
        </div>

        <!-- Card Form Login -->
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            
            <!-- Pesan Sukses (Jika baru reset password) -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

                        <!-- Pesan Sukses -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-700 bg-green-50 p-4 rounded-xl border border-green-200 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-lg"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full border rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all" 
                            placeholder="admin@gmail.com">
                    </div>
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full border rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50 transition-all" 
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Forgot Password -->
                    <button type="button" onclick="document.getElementById('modalLupaPassword').classList.remove('hidden')" class="text-sm text-[#6C5DD3] hover:text-[#5a4cb1] font-semibold hover:underline">
                        Lupa Password?
                    </button>

                <!-- Tombol Login -->
                <button type="submit" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white font-bold py-3 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 mt-6">
                    Log In
                </button>
            </form>

            <!-- Link Register -->
            <div class="text-center mt-6 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-[#6C5DD3] font-bold hover:underline">Daftar sebagai Siswa</a>
                </p>
            </div>
        </div>
        
        <!-- Footer Text -->
        <p class="text-center text-xs text-gray-400 mt-8">&copy; {{ date('Y') }} Sistem Perpustakaan. All rights reserved.</p>
    </div>

        <!-- MODAL LUPA PASSWORD -->
    <div id="modalLupaPassword" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative m-4">
            <button type="button" onclick="document.getElementById('modalLupaPassword').classList.add('hidden')" class="absolute top-5 right-6 text-gray-400 hover:text-gray-800 text-2xl font-bold">&times;</button>
            
            <h3 class="text-xl font-bold mb-2 text-gray-800">Lupa Password?</h3>
            <p class="text-sm text-gray-500 mb-6">Kirim permintaan ke Admin. Admin akan mereset password Anda menjadi <b>siswa123</b>.</p>

            <form action="{{ route('password.request.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIS / Email Anda</label>
                    <input type="text" name="nis" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" required placeholder="Masukkan NIS atau Email">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan (Opsional)</label>
                    <input type="text" name="alasan" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" placeholder="Contoh: Saya lupa password">
                </div>
                <button type="submit" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white font-bold py-3 rounded-xl shadow-lg transition-all">
                    Kirim Permintaan
                </button>
            </form>
        </div>
    </div>

</body>
</html>