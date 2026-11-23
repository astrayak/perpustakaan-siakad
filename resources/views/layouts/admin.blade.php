<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Perpustakaan')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome & SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Cegah kilatan indikator di posisi 0px sebelum posisi menu asal dikunci JS */
        .sidebar-indicator {
            opacity: 0;
        }
    </style>
</head>
<body>

    <div class="app-wrapper">
        <div class="app-shell">

            <!-- SIDEBAR MENU (FULL KIRI + KETERANGAN MENU) -->
            <aside class="sidebar" aria-label="Sidebar Admin">
                <a href="{{ route('admin.dashboard') }}" class="brand-logo">
                    <div class="brand-icon-box">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <span class="brand-text">Perpus.</span>
                </a>

                <nav class="sidebar-menu" id="sidebar-menu">
                    <!-- Indikator Meluncur Otomatis -->
                    <div class="sidebar-indicator" id="sidebar-indicator" aria-hidden="true"></div>

                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.buku.index') }}" class="menu-item {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book"></i>
                        <span class="menu-text">Data Buku</span>
                    </a>

                    <a href="{{ route('admin.kategori.index') }}" class="menu-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i>
                        <span class="menu-text">Kategori</span>
                    </a>

                    <a href="{{ route('admin.peminjaman.index') }}" class="menu-item {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span class="menu-text">Peminjaman</span>
                    </a>

                    <a href="{{ route('admin.siswa.index') }}" class="menu-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span class="menu-text">Data Siswa</span>
                    </a>

                    <a href="{{ route('admin.laporan.index') }}" class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span class="menu-text">Laporan</span>
                    </a>

                    <a href="{{ route('admin.log.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/20 transition-all {{ request()->routeIs('admin.log.*') ? 'bg-white text-[#6C5DD3] shadow-md font-semibold' : '' }}">
                        <i class="fa-solid fa-list-ul text-lg"></i> <span class="hidden lg:block">Log History</span>
                    </a>

                    <a href="{{ route('admin.scan.index') }}" class="menu-item menu-scan {{ request()->routeIs('admin.scan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-qrcode"></i>
                        <span class="menu-text">Scan QR</span>
                    </a>

                    <a href="{{ route('admin.update.index') }}" class="menu-item {{ request()->routeIs('admin.update.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span class="menu-text">Update Sistem</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i>
                        <span class="menu-text">Profil Saya</span>
                    </a>
                </nav>

                <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
                    @csrf
                    <button type="submit" class="sidebar-logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="menu-text">Logout</span>
                    </button>
                </form>
            </aside>

            <!-- SCRIPT SLIDING SIDEBAR MULUS TANPA GLITCH -->
            <script>
                (function () {
                    const menuItems = Array.from(document.querySelectorAll('#sidebar-menu .menu-item'));
                    const indicator = document.getElementById('sidebar-indicator');
                    if (!indicator || menuItems.length === 0) return;

                    const activeIndex = menuItems.findIndex((el) => el.classList.contains('active'));
                    if (activeIndex === -1) return;

                    const activeItem = menuItems[activeIndex];
                    const savedRaw = sessionStorage.getItem('sidebar_active_index');
                    const parsedSaved = savedRaw !== null ? parseInt(savedRaw, 10) : activeIndex;
                    const fromIndex = (parsedSaved >= 0 && parsedSaved < menuItems.length) ? parsedSaved : activeIndex;
                    const fromItem = menuItems[fromIndex];

                    // 1. Kunci indikator di posisi menu halaman sebelumnya tanpa animasi
                    indicator.style.transition = 'none';
                    indicator.style.height = fromItem.offsetHeight + 'px';
                    indicator.style.transform = `translateY(${fromItem.offsetTop}px)`;
                    indicator.style.opacity = '1';

                    // 2. Tunggu 2 frame agar posisi awal tergambar penuh, lalu luncurkan ke menu baru
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            indicator.style.transition = 'transform 380ms cubic-bezier(0.22, 1, 0.36, 1), height 220ms ease';
                            indicator.style.height = activeItem.offsetHeight + 'px';
                            indicator.style.transform = `translateY(${activeItem.offsetTop}px)`;
                        });
                    });

                    sessionStorage.setItem('sidebar_active_index', String(activeIndex));

                    // 3. Saat link diklik, cukup simpan indeks asal tanpa menggerakkan indikator di halaman lama
                    menuItems.forEach((item) => {
                        item.addEventListener('click', () => {
                            sessionStorage.setItem('sidebar_active_index', String(activeIndex));
                        });
                    });

                    // 4. Sesuaikan posisi jika ukuran jendela diubah
                    window.addEventListener('resize', () => {
                        const current = document.querySelector('#sidebar-menu .menu-item.active');
                        if (!current) return;
                        indicator.style.transition = 'none';
                        indicator.style.height = current.offsetHeight + 'px';
                        indicator.style.transform = `translateY(${current.offsetTop}px)`;
                    });
                })();
            </script>

            <!-- MAIN CONTENT AREA -->
            <main class="main-workspace">

                <!-- Topbar (Search Kondisional, Jam WITA & Profil) -->
                <header class="flex flex-wrap justify-between items-center gap-4 shrink-0">
                    @if(request()->routeIs('admin.buku.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.peminjaman.*'))
                        <form action="{{
                            request()->routeIs('admin.buku.*') ? route('admin.buku.index') :
                            (request()->routeIs('admin.siswa.*') ? route('admin.siswa.index') :
                            route('admin.peminjaman.index'))
                        }}" method="GET" class="search-input-box w-full md:w-96">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data...">
                        </form>
                    @else
                        <div class="hidden md:block"></div>
                    @endif

                    <div class="flex items-center gap-3 ml-auto">
                        <!-- Jam WITA -->
                        <div class="px-4 py-2.5 rounded-xl flex items-center gap-2.5 text-xs md:text-sm font-medium"
                             style="background: var(--color-base); border: 1.5px solid var(--color-border); color: var(--color-body);">
                            <i class="fa-regular fa-clock text-base" style="color: var(--color-primary);"></i>
                            <span id="wita-clock">Memuat waktu...</span>
                        </div>

                        <!-- Profil Singkat -->
                        <div class="profile-pill">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-bold leading-tight" style="color: var(--color-heading);">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-xs" style="color: var(--color-muted);">Administrator</p>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Content Body -->
                <div class="flex-1 min-w-0">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    @stack('scripts')

    <!-- Script Jam WITA & SweetAlert2 Global -->
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
            const witaTime = now.toLocaleString('id-ID', options);
            const clockElement = document.getElementById('wita-clock');
            if (clockElement) {
                clockElement.innerText = witaTime + " WITA";
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        document.addEventListener('DOMContentLoaded', function() {
            const primaryColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-primary').trim() || '#5c7057';

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: { popup: 'rounded-3xl' }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: primaryColor,
                    customClass: { popup: 'rounded-3xl' }
                });
            @endif

            const formsWithConfirm = document.querySelectorAll('form[onsubmit*="confirm"]');
            formsWithConfirm.forEach(form => {
                form.removeAttribute('onsubmit');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: "Data yang dihapus/dibatalkan tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                        customClass: { popup: 'rounded-3xl' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>