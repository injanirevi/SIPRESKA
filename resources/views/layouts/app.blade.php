<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPRESKA')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- FONT UNTUK KONTEN HALAMAN --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- CSS UTAMA --}}
    <link rel="stylesheet" href="{{ asset('css/sipreska.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengajuan.css') }}">

    <style>
        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --gold: #C9A227;
            --text: #30283D;
            --muted: #81788F;
            --border: #EAE4F1;
            --lavender: #F5F0FB;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html {
            min-height: 100%;
        }

        body.sipreska-body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(
                    circle at 90% 5%,
                    rgba(197,165,233,.22),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #FFFFFF,
                    #F8F5FC 48%,
                    #EEE5F8
                );
            font-family: 'Poppins', sans-serif;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        | Font sidebar tetap Arial agar tampilannya tidak berubah.
        */

        .sipreska-sidebar,
        .sipreska-sidebar * {
            font-family: Arial, sans-serif;
        }

        .sipreska-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            display: flex;
            flex-direction: column;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            overflow-y: auto;
            background: rgba(255,255,255,.97);
            border-right: 1px solid var(--border);
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
            z-index: 100;
        }

        .sipreska-brand {
            display: block;
            padding: 0 10px;
            color: transparent;
            text-decoration: none;
        }

        .sipreska-brand-symbol {
            display: none;
        }

        .sipreska-brand-text {
            display: block;
        }

        .sipreska-brand-text strong {
            display: block;
            margin: 0;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(
                90deg,
                #8058B8,
                #5B3A8E,
                #432765
            );
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .sipreska-brand-text small {
            display: block;
            max-width: 190px;
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.6;
            letter-spacing: 0;
        }

        .sipreska-menu-caption {
            margin: 0 10px 13px;
            color: #A198AE;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.3px;
        }

        .sipreska-gold-line {
            width: 42px;
            height: 3px;
            flex-shrink: 0;
            margin: 16px 10px 30px;
            border-radius: 5px;
            background: var(--gold);
        }

        .sipreska-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sipreska-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: #655B73;
            text-decoration: none;
            font-size: 13px;
            line-height: 1.5;
            transition:
                background .2s,
                color .2s,
                transform .2s;
        }

        .sipreska-menu-link:hover,
        .sipreska-menu-link.is-active {
            background: linear-gradient(
                110deg,
                #F0EAF8,
                #E3D5F3
            );
            color: var(--purple);
        }

        .sipreska-menu-link:hover {
            transform: translateX(2px);
        }

        .sipreska-menu-link.is-active {
            border-color: #E5D9F3;
            box-shadow: inset 3px 0 0 var(--purple);
            font-weight: 700;
        }

        /* IKON MENU */

        .sipreska-menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            border-radius: 7px;
            background: #F5F0FA;
            color: var(--purple);
            font-size: 15px;
        }

        .sipreska-menu-link.is-active .sipreska-menu-icon {
            background: #FFFFFF;
        }

        /* LOGOUT */

        .sipreska-sidebar-bottom {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .sipreska-logout-form {
            width: 100%;
            margin: 0;
        }

        .sipreska-logout {
            display: block;
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #B64B57;
            text-align: left;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .sipreska-logout:hover {
            background: #FFF1F2;
        }

        .sipreska-sidebar-help {
            display: none;
        }

        /*
        |--------------------------------------------------------------------------
        | KONTEN UTAMA
        |--------------------------------------------------------------------------
        | Konten halaman menggunakan Poppins.
        */

        .sipreska-main {
            width: calc(100% - 250px);
            min-width: 0;
            min-height: 100vh;
            margin-left: 250px;
        }

        .sipreska-content {
            width: 100%;
            min-width: 0;
            padding: 36px 40px;
            font-family: 'Poppins', sans-serif;
        }

        .sipreska-content,
        .sipreska-content * {
            font-family: 'Poppins', sans-serif;
        }

        .sipreska-footer {
            padding: 0 40px 20px;
            color: #9589A7;
            font-size: 11px;
            text-align: center;
            line-height: 1.7;
        }

        /* RESPONSIVE */

        @media (max-width: 1200px) {
            .sipreska-content {
                padding: 28px 24px;
            }

            .sipreska-footer {
                padding-right: 24px;
                padding-left: 24px;
            }
        }

        @media (max-width: 700px) {
            .sipreska-sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 22px 20px;
                overflow: visible;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }

            .sipreska-brand-text strong {
                font-size: 25px;
            }

            .sipreska-gold-line {
                margin-bottom: 24px;
            }

            .sipreska-menu {
                gap: 6px;
            }

            .sipreska-menu-link {
                padding: 11px 12px;
            }

            .sipreska-sidebar-bottom {
                margin-top: 20px;
            }

            .sipreska-main {
                width: 100%;
                margin-left: 0;
            }

            .sipreska-content {
                padding: 24px 16px;
            }

            .sipreska-footer {
                padding: 0 16px 20px;
            }
        }

        @media (max-width: 420px) {
            .sipreska-sidebar {
                padding: 20px 16px;
            }

            .sipreska-content {
                padding: 20px 12px;
            }
        }
    </style>
</head>

<body class="sipreska-body">

    @php
        $user = auth()->user();

        $routeDashboard = $user
            ? route('dashboard')
            : route('home');

        $routeDaftarPrestasi = match ($user?->role) {
            'dosen' => route('dosen.prestasi.index'),
            'admin' => route('admin.prestasi.index'),
            default => route('prestasi'),
        };

        $routePengajuan = $user?->role === 'dosen'
            ? route('dosen.prestasi.create')
            : route('prestasi.create');

        $routePanduan = $user?->role === 'admin'
            ? route('admin.panduan')
            : route('panduan');

        $menuAdmin = $user?->role === 'admin';

        $menuAktifPrestasi = request()->routeIs(
            'prestasi',
            'dosen.prestasi.index',
            'admin.prestasi.index'
        );

        $menuAktifPengajuan = request()->routeIs(
            'prestasi.create',
            'dosen.prestasi.create',
            'pengajuan'
        );
    @endphp

    {{-- SIDEBAR BERSAMA, LINK MENYESUAIKAN ROLE --}}
    <aside class="sipreska-sidebar">

        <a href="{{ $routeDashboard }}" class="sipreska-brand">
            <span class="sipreska-brand-symbol">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="28" height="30" style="object-fit: contain;">
            </span>

            <span class="sipreska-brand-text">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
                <strong>SIPRESKA</strong>
                <small>
                    Sistem Informasi Pendataan dan Pengelolaan
                    Prestasi Sivitas Akademika
                </small>
            </span>
        </a>

        <div class="sipreska-gold-line"></div>

        <div class="sipreska-menu-caption">
            @if ($user)
                MENU {{ strtoupper($user->role) }}
            @else
                MENU UTAMA
            @endif
        </div>

        <nav class="sipreska-menu" aria-label="Menu utama">

            {{-- DASHBOARD --}}
            <a
                href="{{ $routeDashboard }}"
                class="sipreska-menu-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
            >
                <span class="sipreska-menu-icon" aria-hidden="true">⌂</span>
                Dashboard
            </a>

            {{-- DAFTAR PRESTASI --}}
            <a
                href="{{ $routeDaftarPrestasi }}"
                class="sipreska-menu-link {{ $menuAktifPrestasi ? 'is-active' : '' }}"
            >
                <span class="sipreska-menu-icon" aria-hidden="true">▤</span>
                Daftar Prestasi
            </a>

            {{-- PENGAJUAN PRESTASI --}}
            @if (!$menuAdmin)
                <a
                    href="{{ $routePengajuan }}"
                    class="sipreska-menu-link {{ $menuAktifPengajuan ? 'is-active' : '' }}"
                >
                    <span class="sipreska-menu-icon" aria-hidden="true">＋</span>
                    Pengajuan Prestasi
                </a>
            @endif

            {{-- PANDUAN --}}
            <a
                href="{{ $routePanduan }}"
                class="sipreska-menu-link {{ request()->routeIs('panduan', 'admin.panduan') ? 'is-active' : '' }}"
            >
                <span class="sipreska-menu-icon" aria-hidden="true">ⓘ</span>
                Panduan Penggunaan
            </a>

        </nav>

        {{-- KELUAR DARI AKUN --}}
        <div class="sipreska-sidebar-bottom">
            @auth
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="sipreska-logout-form"
                >
                    @csrf
                    <button type="submit" class="sipreska-logout">
                        Keluar dari Akun
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="sipreska-logout">
                    Login
                </a>
            @endauth
        </div>

    </aside>

    {{-- KONTEN HALAMAN --}}
    <main class="sipreska-main">
        <div class="sipreska-content">
            @yield('content')
        </div>

        <footer class="sipreska-footer">
            © {{ date('Y') }} SIPRESKA — Sistem Informasi
            Pendataan dan Pengelolaan Prestasi Sivitas Akademika
        </footer>
    </main>

    <script src="{{ asset('js/sipreska.js') }}"></script>

</body>
</html>