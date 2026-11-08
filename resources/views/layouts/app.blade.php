<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPRESKA')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- FONT MODERN: PLUS JAKARTA SANS & POPPINS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    {{-- CSS UTAMA --}}
    <link rel="stylesheet" href="{{ asset('css/sipreska.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengajuan.css') }}">

    <style>
        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --purple-mid: #8058B8;
            --gold: #C9A227;
            --text: #342847;
            --muted: #80758F;
            --border: #E7DFF0;
            --lavender: #F5F0FB;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR MODERN KONSISTEN
        |--------------------------------------------------------------------------
        */

        .sipreska-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            display: flex;
            flex-direction: column;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            overflow-y: auto;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
            z-index: 100;
        }

        .sipreska-brand {
            display: block;
            padding: 0 10px;
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
            padding: 11px 14px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: #655B73;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sipreska-menu-link:hover {
            background: #FAF7FD;
            color: var(--purple);
            transform: translateX(3px);
        }

        .sipreska-menu-link.is-active {
            background: linear-gradient(135deg, #F3ECF9 0%, #EDE1F7 100%);
            border-color: #E2D1F3;
            color: var(--purple);
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(91, 58, 142, 0.08);
        }

        .sipreska-menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: inherit;
        }

        .sidebar-counter-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 10.5px;
            font-weight: 800;
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FDE68A;
            line-height: 1.2;
            margin-left: auto;
        }

        /* LOGOUT */
        .sipreska-sidebar-bottom {
            margin-top: auto;
            padding-top: 24px;
        }

        .sipreska-logout-form {
            width: 100%;
            margin: 0;
        }

        .sipreska-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #F5D3D3;
            border-radius: 10px;
            background: #FFF5F5;
            color: #B91C1C;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }

        .sipreska-logout:hover {
            background: #FEE2E2;
            border-color: #F87171;
            transform: translateY(-1px);
            color: #991B1B;
        }

        .sipreska-sidebar-help {
            display: none;
        }

        /*
        |--------------------------------------------------------------------------
        | KONTEN UTAMA
        |--------------------------------------------------------------------------
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
            padding: 32px 36px 48px;
        }

        .sipreska-footer {
            padding: 0 36px 28px;
            color: #9589A7;
            font-size: 11.5px;
            text-align: center;
            line-height: 1.7;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .sipreska-content {
                padding: 28px 24px 40px;
            }

            .sipreska-footer {
                padding-right: 24px;
                padding-left: 24px;
            }
        }

        @media (max-width: 768px) {
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
                padding: 10px 12px;
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
            'admin', 'super_admin' => route('admin.prestasi.index'),
            default => route('prestasi'),
        };

        $routePengajuan = $user?->role === 'dosen'
            ? route('dosen.prestasi.create')
            : route('prestasi.create');

        $routePanduan = in_array($user?->role, ['admin', 'super_admin'], true)
            ? route('admin.panduan')
            : route('panduan');

        $isAdmin = in_array($user?->role, ['admin', 'super_admin'], true);
        $isSuperAdmin = $user?->role === 'super_admin';

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

    {{-- SIDEBAR BERSAMA MODERN (IKON SVG & TIPOGRAFI SERAGAM) --}}
    <aside class="sipreska-sidebar">

        <a href="{{ $routeDashboard }}" class="sipreska-brand">
            <span class="sipreska-brand-symbol">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="28" height="30" style="object-fit: contain;">
            </span>

            <span class="sipreska-brand-text">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
                <strong>SIPRESKA</strong>
                <small>
                    Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas
                </small>
            </span>
        </a>

        <div class="sipreska-gold-line"></div>

        <div class="sipreska-menu-caption">
            @if ($user)
                MENU {{ $user->role === 'super_admin' ? 'SUPER ADMIN' : strtoupper($user->role) }}
            @else
                MENU UTAMA
            @endif
        </div>

        <nav class="sipreska-menu" aria-label="Menu utama">

            {{-- 1. DASHBOARD --}}
            <a
                href="{{ $routeDashboard }}"
                class="sipreska-menu-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
            >
                <span class="sipreska-menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                <span>Dashboard</span>
            </a>

            {{-- 2. DAFTAR PRESTASI --}}
            <a
                href="{{ $routeDaftarPrestasi }}"
                class="sipreska-menu-link {{ $menuAktifPrestasi ? 'is-active' : '' }}"
            >
                <span class="sipreska-menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                <span>Daftar Prestasi</span>
            </a>

            {{-- 3. VERIFIKASI PRESTASI (KHUSUS ADMIN / SUPER ADMIN) --}}
            @if ($isAdmin)
                <a
                    href="{{ route('admin.verifikasi.index') }}"
                    class="sipreska-menu-link {{ request()->routeIs('admin.verifikasi.*') ? 'is-active' : '' }}"
                >
                    <span class="sipreska-menu-icon" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </span>
                    <span>Verifikasi Prestasi</span>
                    @php
                        $badgePendingCount = rescue(fn() => \App\Models\Prestasi::where('status', 'menunggu_verifikasi')->count(), 0, false);
                    @endphp
                    @if ($badgePendingCount > 0)
                        <span class="sidebar-counter-badge">{{ $badgePendingCount }}</span>
                    @endif
                </a>
            @endif

            {{-- 4. MANAJEMEN AKUN (KHUSUS SUPER ADMIN) --}}
            @if ($isSuperAdmin)
                <a
                    href="{{ route('superadmin.users.index') }}"
                    class="sipreska-menu-link {{ request()->routeIs('superadmin.users.*') ? 'is-active' : '' }}"
                >
                    <span class="sipreska-menu-icon" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </span>
                    <span>Manajemen Akun</span>
                </a>
            @endif

            {{-- 5. PENGAJUAN PRESTASI (KHUSUS MAHASISWA & DOSEN) --}}
            @if (!$isAdmin)
                <a
                    href="{{ $routePengajuan }}"
                    class="sipreska-menu-link {{ $menuAktifPengajuan ? 'is-active' : '' }}"
                >
                    <span class="sipreska-menu-icon" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    </span>
                    <span>Pengajuan Prestasi</span>
                </a>
            @endif

            {{-- 6. PANDUAN PENGGUNAAN --}}
            <a
                href="{{ $routePanduan }}"
                class="sipreska-menu-link {{ request()->routeIs('panduan', 'admin.panduan') ? 'is-active' : '' }}"
            >
                <span class="sipreska-menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                <span>Panduan Penggunaan</span>
            </a>

        </nav>

        {{-- KELUAR DARI AKUN / LOGIN --}}
        <div class="sipreska-sidebar-bottom">
            @auth
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="sipreska-logout-form"
                >
                    @csrf
                    <button type="submit" class="sipreska-logout">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Keluar dari Akun</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="sipreska-logout" style="background:#FAF7FD; border-color:#DFD2ED; color:var(--purple);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                    <span>Masuk ke Akun</span>
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
            &copy; {{ date('Y') }} SIPRESKA &mdash; Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas Akademika
        </footer>
    </main>

    <script src="{{ asset('js/sipreska.js') }}"></script>

</body>
</html>
