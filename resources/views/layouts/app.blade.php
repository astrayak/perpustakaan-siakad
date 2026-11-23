<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Perpustakaan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-wrapper">
        <div class="app-shell">

            <!-- SIDEBAR MENU -->
            <aside class="sidebar" aria-label="Sidebar Navigation">
                <a href="{{ url('/') }}" class="brand-logo" title="Perpustakaan">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                    </svg>
                </a>

                <nav class="sidebar-menu" id="sidebar-menu">
                    <div class="sidebar-indicator" id="sidebar-indicator" aria-hidden="true"></div>

                    <a href="{{ url('/') }}" class="menu-item {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="7" x="3" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="3" rx="1.5"/>
                            <rect width="7" height="7" x="14" y="14" rx="1.5"/><rect width="7" height="7" x="3" y="14" rx="1.5"/>
                        </svg>
                        <span class="menu-tooltip">Dashboard</span>
                    </a>

                    <a href="{{ url('/buku') }}" class="menu-item {{ request()->is('buku*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                        </svg>
                        <span class="menu-tooltip">Data Buku</span>
                    </a>

                    <a href="{{ url('/peminjaman') }}" class="menu-item {{ request()->is('peminjaman*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span class="menu-tooltip">Peminjaman</span>
                    </a>
                </nav>

                <a href="{{ url('/logout') }}" class="sidebar-logout" title="Keluar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                </a>
            </aside>

            <!-- AREA KONTEN UTAMA -->
            <div class="workspace-grid">
                <main class="center-column">
                    @yield('content')
                </main>

                <aside class="right-panel">
                    @yield('right-panel')
                </aside>
            </div>

        </div>
    </div>
</body>
</html>