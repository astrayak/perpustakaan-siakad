
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Siswa - Perpustakaan')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome & SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =====================================
           GLOBAL RESPONSIVE
        ===================================== */

        * {
            box-sizing: border-box;
        }

        html {
            width: 100%;
            min-height: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
            background-color: var(--color-canvas);
            color: var(--color-heading);
            font-family: 'Inter', sans-serif;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button,
        input,
        select,
        textarea {
            max-width: 100%;
            font: inherit;
        }

        /* =====================================
           PENYESUAIAN WARNA TEMA
        ===================================== */

        .bg-\[\#6C5DD3\],
        .bg-indigo-600,
        .bg-purple-600,
        [class*="from-\[\#6C5DD3\]"],
        [class*="from-indigo-"],
        [class*="from-purple-"] {
            background: var(--color-primary) !important;
            background-image: none !important;
            color: var(--color-on-primary) !important;
        }

        .hover\:bg-\[\#5a4cb8\]:hover,
        .hover\:bg-indigo-700:hover,
        .hover\:bg-purple-700:hover {
            background-color: color-mix(
                in srgb,
                var(--color-primary) 86%,
                #000000
            ) !important;
        }

        .text-\[\#6C5DD3\],
        .text-indigo-600,
        .text-purple-600 {
            color: var(--color-primary) !important;
        }

        .bg-\[\#6C5DD3\]\/10,
        .bg-indigo-50,
        .bg-indigo-100,
        .bg-purple-50,
        .bg-purple-100 {
            background-color: var(--color-accent-tint) !important;
            color: var(--color-primary) !important;
        }

        /* =====================================
           NAVBAR RESPONSIVE
        ===================================== */

        .siswa-navbar {
            position: sticky;
            top: 0;
            z-index: 30;
            width: 100%;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            background: color-mix(
                in srgb,
                var(--color-base) 92%,
                transparent
            );
            border-bottom: 1.5px solid var(--color-border);
        }

        .siswa-navbar-container {
            width: 100%;
            max-width: 1280px;
            min-height: 64px;
            margin: 0 auto;
            padding: 10px 16px;

            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: center;
            gap: 12px;
        }

        .siswa-navbar-left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            min-width: 0;
        }

        .siswa-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--color-heading);
            font-size: 18px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .siswa-brand-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: var(--color-primary);
            color: var(--color-on-primary);
        }

        .siswa-nav {
            width: 100%;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .siswa-nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 9px 12px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .siswa-nav a:hover {
            background: var(--color-accent-tint);
            color: var(--color-primary) !important;
        }

        /* =====================================
           PROFIL & LOGOUT
        ===================================== */

        .siswa-navbar-right {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            min-width: 0;
        }

        .siswa-profile {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
            padding: 6px 11px;
            border-radius: 30px;
            background: var(--color-canvas);
            border: 1.5px solid var(--color-border);
        }

        .siswa-avatar {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 700;
            background: var(--color-accent);
            color: var(--color-on-accent);
        }

        .siswa-profile-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 600;
            color: var(--color-heading);
        }

        .siswa-logout-form {
            margin: 0;
            flex-shrink: 0;
        }

        .siswa-logout-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 38px;
            padding: 9px 13px;
            border-radius: 11px;
            background: var(--color-canvas);
            border: 1.5px solid var(--color-border);
            color: var(--color-body);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .siswa-logout-button:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: white;
        }

        /* =====================================
           MAIN CONTENT
        ===================================== */

        .siswa-main {
            width: 100%;
            max-width: 1280px;
            min-width: 0;
            flex: 1;
            margin: 0 auto;
            padding: 20px 16px 28px;
        }

        .siswa-main > * {
            max-width: 100%;
        }

        /* =====================================
           FOOTER
        ===================================== */

        .siswa-footer {
            width: 100%;
            padding: 18px 16px;
            text-align: center;
            font-size: 12px;
            color: var(--color-muted);
            border-top: 1px solid var(--color-border);
        }

        /* =====================================
           TABLET
        ===================================== */

        @media (min-width: 640px) {
            .siswa-navbar-container {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 10px 24px;
            }

            .siswa-navbar-left {
                flex-direction: row;
                align-items: center;
                gap: 18px;
            }

            .siswa-nav {
                width: auto;
            }

            .siswa-navbar-right {
                width: auto;
                justify-content: flex-end;
            }

            .siswa-main {
                padding: 26px 24px 32px;
            }
        }

        /* =====================================
           LAPTOP & DESKTOP
        ===================================== */

        @media (min-width: 1024px) {
            .siswa-navbar-container {
                padding-left: 32px;
                padding-right: 32px;
            }

            .siswa-navbar-left {
                gap: 24px;
            }

            .siswa-main {
                padding: 28px 32px 36px;
            }
        }

        /* =====================================
           HP KECIL
        ===================================== */

        @media (max-width: 380px) {
            .siswa-navbar-container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .siswa-brand {
                font-size: 16px;
            }

            .siswa-nav a {
                padding: 8px 10px;
                font-size: 12px;
            }

            .siswa-profile {
                padding: 5px 8px;
            }

            .siswa-profile-name {
                max-width: 125px;
                font-size: 12px;
            }

            .siswa-logout-button {
                padding: 8px 10px;
                font-size: 12px;
            }

            .siswa-main {
                padding: 16px 12px 24px;
            }
        }

        /* =====================================
           AKSESIBILITAS
        ===================================== */

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 3px solid var(--color-primary);
            outline-offset: 3px;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col overflow-x-hidden">

    <!-- =====================================
         TOP NAVBAR SISWA
    ====================================== -->

    <header class="siswa-navbar">

        <div class="siswa-navbar-container">

            <!-- BRAND & MENU NAVIGASI -->

            <div class="siswa-navbar-left">

                <!-- Logo -->

                <a href="{{ url('/siswa/buku') }}" class="siswa-brand">

                    <span class="siswa-brand-icon">
                        <i class="fa-solid fa-book-open text-sm"></i>
                    </span>

                    <span>Perpus.</span>

                </a>

                <!-- Navigasi -->

                <nav class="siswa-nav" aria-label="Navigasi Siswa">

                    <a href="{{ url('/siswa/buku') }}"
                       style="{{ request()->is('siswa/buku*')
                            ? 'background: var(--color-primary); color: var(--color-on-primary);'
                            : 'color: var(--color-body);' }}">

                        <i class="fa-solid fa-book-open mr-2"></i>
                        Katalog Buku

                    </a>

                    <a href="{{ url('/siswa/peminjaman') }}"
                       style="{{ request()->is('siswa/peminjaman*')
                            ? 'background: var(--color-primary); color: var(--color-on-primary);'
                            : 'color: var(--color-body);' }}">

                        <i class="fa-solid fa-clock-rotate-left mr-2"></i>
                        Riwayat Pinjam

                    </a>

                </nav>

            </div>

            <!-- PROFIL & LOGOUT -->

            <div class="siswa-navbar-right">

                <!-- Profil -->

                <div class="siswa-profile">

                    <span class="siswa-avatar">

                        {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}

                    </span>

                    <span class="siswa-profile-name">

                        {{ auth()->user()->name ?? 'Siswa' }}

                    </span>

                </div>

                <!-- Logout -->

                <form method="POST"
                      action="{{ route('logout') }}"
                      class="siswa-logout-form">

                    @csrf

                    <button type="submit" class="siswa-logout-button">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </div>

    </header>


    <!-- =====================================
         KONTEN UTAMA SISWA
    ====================================== -->

    <main class="siswa-main">

        @yield('content')

    </main>


    <!-- =====================================
         FOOTER
    ====================================== -->

    <footer class="siswa-footer">

        &copy; {{ date('Y') }} Sistem Perpustakaan.
        All rights reserved.

    </footer>


    <!-- =====================================
         CUSTOM SCRIPTS
    ====================================== -->

    @stack('scripts')


    <!-- =====================================
         SWEETALERT2 GLOBAL
    ====================================== -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const primaryColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-primary')
                .trim() || '#5c7057';


            // Notifikasi Berhasil

            @if(session('success'))

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });

            @endif


            // Notifikasi Gagal

            @if(session('error'))

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonColor: primaryColor,
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });

            @endif

        });
    </script>

</body>
</html>
