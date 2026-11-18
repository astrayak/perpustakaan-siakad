<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<body class="flex h-screen overflow-hidden text-gray-700">

    <!-- Sidebar Modern (Ungu) -->
    <aside class="w-20 lg:w-64 bg-[#6C5DD3] text-white flex flex-col items-center py-6 shadow-2xl rounded-r-3xl z-20 transition-all duration-300">
        <!-- Logo -->
        <div class="mb-10 flex items-center gap-3">
            <div class="bg-white text-[#6C5DD3] w-10 h-10 flex items-center justify-center rounded-xl font-bold text-xl shadow-lg">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <span class="text-xl font-bold hidden lg:block tracking-wide">Perpus.</span>
        </div>

                <!-- Menu -->
        <nav class="flex-1 w-full space-y-2 px-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                <i class="fa-solid fa-house text-lg"></i> <span class="hidden lg:block">Dashboard</span>
            </a>
            <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('admin.buku.*') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                <i class="fa-solid fa-book text-lg"></i> <span class="hidden lg:block">Data Buku</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('admin.kategori.*') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                <i class="fa-solid fa-layer-group text-lg"></i> <span class="hidden lg:block">Kategori</span>
            </a>
            <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('admin.peminjaman.*') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                <i class="fa-solid fa-clock-rotate-left text-lg"></i> <span class="hidden lg:block">Peminjaman</span>
            </a>
            
            <!-- Menu Data Siswa (Tambahan Baru) -->
            <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('admin.siswa.*') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                <i class="fa-solid fa-users text-lg"></i> <span class="hidden lg:block">Data Siswa</span>
            </a>

            <!-- Garis Pemisah & Tombol Scan -->
            <div class="pt-4 mt-4 border-t border-white/20">
                <a href="{{ route('admin.scan.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-orange-400 hover:bg-orange-500 transition-all shadow-lg font-semibold mb-2">
                    <i class="fa-solid fa-qrcode text-lg"></i> <span class="hidden lg:block">Scan QR</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('profile.*') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                    <i class="fa-solid fa-user text-lg"></i> <span class="hidden lg:block">Profil Saya</span>
                </a>
            </div>
        </nav>

        <!-- Logout -->
        <div class="w-full px-3 mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-red-500 transition-all">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i> <span class="hidden lg:block">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#f4f7fe]">
        
        <!-- Topbar (Search & Jam WITA) -->
        <header class="h-24 px-8 flex justify-between items-center">
            <!-- Search Box -->
            <div class="relative w-96 hidden md:block">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Cari sesuatu..." class="w-full bg-white pl-12 pr-4 py-3 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#6C5DD3]">
            </div>

            <!-- Right Info -->
            <div class="flex items-center gap-6">
                <!-- Jam WITA -->
                <div class="bg-white px-5 py-2 rounded-xl shadow-sm flex items-center gap-3 text-sm font-medium text-gray-600 border border-gray-100">
                    <i class="fa-regular fa-clock text-[#6C5DD3] text-lg"></i>
                    <div id="wita-clock">Memuat waktu...</div>
                </div>

                <!-- Profil Singkat -->
                <div class="flex items-center gap-3 bg-white py-2 px-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-10 h-10 bg-[#6C5DD3] rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <div class="px-8 pb-8 flex-1">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 shadow-sm">{{ session('error') }}</div>
            @endif
            
            @yield('content')
        </div>
    </main>

    @stack('scripts')

    <!-- Script Jam WITA -->
    <script>
        function updateClock() {
            const now = new Date();
            const options = { 
                timeZone: 'Asia/Makassar', 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            };
            // Format ke bahasa Indonesia
            const witaTime = now.toLocaleString('id-ID', options);
            document.getElementById('wita-clock').innerText = witaTime + " WITA";
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>