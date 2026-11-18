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

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#6C5DD3] shadow-sm focus:ring-[#6C5DD3]" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#6C5DD3] hover:text-[#5a4cb1] font-semibold hover:underline" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

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

</body>
</html>