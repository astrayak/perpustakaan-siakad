<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fe; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Navbar Modern -->
    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-8">
            <!-- Logo -->
            <a href="{{ route('siswa.buku.index') }}" class="flex items-center gap-3">
                <div class="bg-[#6C5DD3] text-white w-10 h-10 flex items-center justify-center rounded-xl font-bold text-xl shadow-md">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <span class="text-xl font-bold text-gray-800 tracking-wide hidden md:block">Perpus.</span>
            </a>
            
            <!-- Menu -->
            <div class="hidden md:flex gap-6">
                <a href="{{ route('siswa.buku.index') }}" class="font-medium {{ request()->routeIs('siswa.buku.*') ? 'text-[#6C5DD3]' : 'text-gray-500 hover:text-[#6C5DD3]' }} transition-colors">Katalog Buku</a>
                <a href="{{ route('siswa.peminjaman.index') }}" class="font-medium {{ request()->routeIs('siswa.peminjaman.*') ? 'text-[#6C5DD3]' : 'text-gray-500 hover:text-[#6C5DD3]' }} transition-colors">Riwayat Pinjam</a>
            </div>
        </div>

        <!-- User Info & Logout -->
        <div class="flex items-center gap-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:bg-gray-50 px-3 py-2 rounded-xl transition-all border border-transparent hover:border-gray-200">
                <div class="w-8 h-8 bg-[#FFB319] rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="text-sm font-semibold text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                    <i class="fa-solid fa-right-from-bracket"></i> <span class="hidden md:inline ml-1">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-sm text-gray-400">
        &copy; {{ date('Y') }} Sistem Perpustakaan. All rights reserved.
    </footer>

</body>
</html>