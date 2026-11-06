
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPRESKA')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">
</head>
<body>

@php
    $urutanTingkat = [
        'internasional' => 0,
        'nasional' => 1,
        'universitas' => 2,
        'regional/lokal' => 3,
        'regional' => 3,
    ];

    $menuTingkats = \App\Models\TingkatPrestasi::get()
        ->sortBy(fn ($tingkat) => $urutanTingkat[mb_strtolower(trim($tingkat->nama_tingkat))] ?? 4)
        ->values();

    $menuKategoris = \App\Models\KategoriPrestasi::whereIn(
        'nama_kategori',
        ['Akademik', 'Non Akademik']
    )->orderBy('nama_kategori')->get();
@endphp

<header class="site-header">
    <div class="nav-wrap">

        <a href="{{ route('home') }}" class="brand" aria-label="SIPRESKA Beranda">
            <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo SIPRESKA" class="brand-logo">
            <div class="brand-content">
                <span class="brand-title">SIPRESKA<span class="brand-dot">.</span></span>
                <span class="brand-subtitle">Portal Prestasi Sivitas</span>
            </div>
        </a>

        <nav class="main-nav" id="mainNav">

            {{-- BERANDA --}}
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m3 10 9-7 9 7"></path>
                    <path d="M5 9v11h14V9"></path>
                    <path d="M9 20v-7h6v7"></path>
                </svg>
                <span>Beranda</span>
            </a>

            {{-- DROPDOWN TINGKAT KOMPETISI --}}
            <div class="nav-dropdown">

                <button
                    type="button"
                    class="nav-dropdown-toggle {{ request()->routeIs('tingkat-kompetisi*') ? 'active' : '' }}"
                    aria-expanded="false"
                    onclick="toggleDropdown(this)"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"></path>
                    </svg>

                    <span>Tingkat Kompetisi</span>
                    <span class="dropdown-chevron"></span>
                </button>

                <div class="nav-dropdown-menu">
@forelse ($menuTingkats as $tingkat)
                        <a href="{{ route('tingkat-kompetisi.detail', $tingkat->id) }}">
                            {{ $tingkat->nama_tingkat }}
                        </a>
                    @empty
                        <span class="dropdown-empty">
                            Belum ada tingkat kompetisi
                        </span>
                    @endforelse

                </div>
            </div>

            {{-- DROPDOWN KELOMPOK KOMPETISI --}}
            <div class="nav-dropdown">

                <button
                    type="button"
                    class="nav-dropdown-toggle {{ request()->routeIs('kelompok-kompetisi*') ? 'active' : '' }}"
                    aria-expanded="false"
                    onclick="toggleDropdown(this)"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 21h18M5 21V9h14v12M3 9l9-6 9 6"></path>
                        <path d="M8 12v5M12 12v5M16 12v5"></path>
                    </svg>

                    <span>Kelompok Kompetisi</span>
                    <span class="dropdown-chevron"></span>
                </button>

                <div class="nav-dropdown-menu">
@forelse ($menuKategoris as $kategori)
                        <a href="{{ route('kelompok-kompetisi.detail', $kategori->id) }}">
                            {{ $kategori->nama_kategori }}
                        </a>
                    @empty
                        <span class="dropdown-empty">
                            Kategori belum tersedia
                        </span>
                    @endforelse

                </div>
            </div>

            {{-- DOSEN BERPRESTASI --}}
            <a
                href="{{ route('dosen-berprestasi') }}"
                class="{{ request()->routeIs('dosen-berprestasi') ? 'active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M4 21v-2a8 8 0 0 1 16 0v2"></path>
                </svg>
                <span>Dosen Berprestasi</span>
            </a>

            {{-- MAHASISWA BERPRESTASI --}}
            <a
                href="{{ route('mahasiswa-berprestasi') }}"
                class="{{ request()->routeIs('mahasiswa-berprestasi') ? 'active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m2 9 10-5 10 5-10 5L2 9Z"></path>
                    <path d="M6 11v5c4 3 8 3 12 0v-5M22 9v6"></path>
                </svg>
                <span>Mahasiswa Berprestasi</span>
            </a>

            <a
                href="{{ route('ranking') }}"
                class="{{ request()->routeIs('ranking') ? 'active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 20h16M6 17h12M8 14h8M10 11h4"></path>
                    <path d="M12 3v6M9 6l3-3 3 3"></path>
                </svg>
                <span>Ranking</span>
            </a>

        </nav>

                <button
            type="button"
            class="nav-toggle"
            aria-label="Buka menu"
            aria-controls="mainNav"
            aria-expanded="false"
            onclick="toggleNav()"
        >
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand-block">
            <a href="{{ route('home') }}" class="footer-brand" style="display: inline-flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo SIPRESKA" width="34" height="34" style="object-fit: contain; flex-shrink: 0; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.25));">
                <span>SIPRESKA<span>.</span></span>
            </a>
            <p>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas Akademika.</p>
            <span class="footer-campus">UIN Siber Syekh Nurjati Cirebon</span>
                        <div class="footer-helpdesk" style="margin-top: 18px; padding-top: 14px; border-top: 1px solid rgba(255,255,255,.1); font-size: 12px; color: rgba(255,255,255,.75); display: flex; flex-direction: column; gap: 8px;">
                <span style="color: #e9d7a7; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Bantuan &amp; Layanan Prestasi</span>
                <span style="display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #c9a45e; flex-shrink: 0;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <a href="mailto:prestasi@uinssc.ac.id" style="color: #fff; text-decoration: none;">prestasi@uinssc.ac.id</a>
                </span>
                <span style="display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #c9a45e; flex-shrink: 0;"><path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-4"></path><path d="M9 9h1"></path><path d="M9 13h1"></path><path d="M9 17h1"></path></svg>
                    <span>Gedung Rektorat Lt. 2, Kampus UIN Siber Cirebon</span>
                </span>
            </div>
        </div>
        <div class="footer-links-group">
            <h2>Navigasi</h2>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('prestasi.publik') }}">Semua Prestasi</a>
            <a href="{{ route('mahasiswa-berprestasi') }}">Mahasiswa Berprestasi</a>
            <a href="{{ route('dosen-berprestasi') }}">Dosen Berprestasi</a>
        </div>
        <div class="footer-links-group">
            <h2>Jelajahi</h2>
            <a href="{{ route('tingkat-kompetisi') }}">Tingkat Kompetisi</a>
            <a href="{{ route('kelompok-kompetisi') }}">Kelompok Kompetisi</a>
            <a href="{{ route('ranking') }}">Ranking Fakultas &amp; Prodi</a>
            <a href="{{ route('home') }}#statistik">Statistik SIPRESKA</a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} SIPRESKA · UIN Siber Syekh Nurjati Cirebon</span>
        <span class="footer-bottom-note">Informasi prestasi sivitas akademika</span>
    </div>
</footer>

<script src="{{ asset('js/sipreska.js') }}"></script>

</body>
</html>
