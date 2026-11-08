<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Penggunaan Administrator | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .sidebar, .sidebar * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --lavender: #EEE6F8;
            --gold: #C9A227;
            --text: #342847;
            --muted: #80758F;
            --border: #E7DFF0;
        }

        body {
            margin: 0;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF, #F8F5FC 48%, #EEE5F8);
            min-height: 100vh;
        }

        .layout { min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
            z-index: 100;
            overflow-y: auto;
        }

        .logo {
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(90deg,#8058B8,#5B3A8E,#432765);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .logo small {
            display: block;
            max-width: 190px;
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.6;
        }

        .gold-line {
            width: 42px;
            height: 3px;
            flex-shrink: 0;
            margin: 16px 10px 30px;
            border-radius: 5px;
            background: var(--gold);
        }

        .menu-title {
            margin: 0 10px 13px;
            color: #A198AE;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.3px;
        }

        .menu { display: flex; flex-direction: column; gap: 8px; }

        .menu a {
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

        .menu a:hover {
            background: #FAF7FD;
            color: var(--purple);
            transform: translateX(3px);
        }

        .menu a.active {
            background: linear-gradient(135deg, #F3ECF9 0%, #EDE1F7 100%);
            border-color: #E2D1F3;
            color: var(--purple);
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(91, 58, 142, 0.08);
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: inherit;
        }

        .menu a.active .menu-icon {
            color: var(--purple);
        }

        .sidebar-counter-badge {
            margin-left: auto;
            padding: 2px 7px;
            border-radius: 999px;
            background: var(--gold, #C9A227);
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.2;
            box-shadow: 0 2px 6px rgba(201, 162, 39, 0.35);
        }

        .logout {
            margin-top: auto;
            padding-top: 24px;
        }

        .logout button {
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
            transition: all .2s ease;
        }

        .logout button:hover {
            background: #FEE2E2;
            border-color: #F87171;
            transform: translateY(-1px);
        }

        /* MAIN CONTENT */
        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 36px 40px;
            min-width: 0;
        }

        /* TOP-BAR HEADER */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .top-header-left h1 {
            margin: 4px 0 0;
            font-size: 26px;
            font-weight: 800;
            color: var(--purple-dark);
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.4px;
        }

        .eyebrow {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #8C6FA8;
            text-transform: uppercase;
        }

        .user-profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid var(--border);
            background: #FFFFFF;
            box-shadow: 0 2px 10px rgba(67,39,101,.04);
            font-size: 12.5px;
            font-weight: 700;
            color: var(--purple-dark);
        }

        /* WELCOME BANNER */
        .welcome {
            margin-bottom: 28px;
            padding: 26px 30px;
            border: 1px solid #E3D5F2;
            border-left: 5px solid var(--gold);
            border-radius: 16px;
            background: linear-gradient(115deg, #FFFFFF, #F6F0FC 52%, #E7D9F5);
            box-shadow: 0 8px 25px rgba(91,58,142,.05);
        }

        .welcome h2 {
            margin: 0 0 8px;
            color: var(--purple-dark);
            font-size: 21px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .welcome p {
            margin: 0;
            color: #746886;
            font-size: 13px;
            line-height: 1.8;
            max-width: 780px;
        }

        /* GUIDE CARDS GRID */
        .guide-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        @media (max-width: 900px) {
            .guide-grid { grid-template-columns: 1fr; }
        }

        .guide-card {
            background: #FFFFFF;
            border: 1px solid #ECE4F4;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .guide-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(67, 39, 101, 0.08);
            border-color: #DCCFE8;
        }

        .guide-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .guide-icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #F3EDFA;
            border: 1px solid #E4D7F3;
            color: var(--purple);
        }

        .guide-step-tag {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.8px;
            padding: 3px 9px;
            border-radius: 6px;
            background: #F5EFE0;
            color: #8C6A13;
            border: 1px solid #EEDFBC;
            text-transform: uppercase;
        }

        .guide-card h3 {
            margin: 0 0 10px;
            color: #2D1A47;
            font-size: 17px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        .guide-card p {
            margin: 0 0 14px;
            color: #6C5D7F;
            font-size: 13px;
            line-height: 1.75;
        }

        .guide-card ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .guide-card li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12.5px;
            line-height: 1.6;
            color: #554868;
        }

        .guide-card li svg {
            color: #10B981;
            flex-shrink: 0;
            margin-top: 3px;
        }

        /* STATUS MATRIX CARD */
        .status-matrix-card {
            background: #FFFFFF;
            border: 1px solid #ECE4F4;
            border-radius: 16px;
            padding: 26px 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
        }

        .status-matrix-header {
            margin-bottom: 18px;
        }

        .status-matrix-header h3 {
            margin: 0 0 6px;
            font-size: 17px;
            font-weight: 700;
            color: var(--purple-dark);
            font-family: 'Poppins', sans-serif;
        }

        .status-matrix-header p {
            margin: 0;
            font-size: 12.5px;
            color: var(--muted);
        }

        .status-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        @media (max-width: 800px) {
            .status-grid-3 { grid-template-columns: 1fr; }
        }

        .status-box {
            padding: 16px;
            border-radius: 12px;
            border: 1px solid;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .status-box.disetujui {
            background: #F2FAF5;
            border-color: #C6ECDA;
        }

        .status-box.disetujui strong { color: #157A3C; }

        .status-box.menunggu {
            background: #FEFAF0;
            border-color: #F8E5B8;
        }

        .status-box.menunggu strong { color: #9A6C05; }

        .status-box.ditolak {
            background: #FDF4F4;
            border-color: #F8D1D1;
        }

        .status-box.ditolak strong { color: #B91C1C; }

        .status-box strong {
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-box p {
            margin: 0;
            font-size: 12px;
            line-height: 1.6;
            color: #554868;
        }

        /* TIP FOOTNOTE */
        .sop-note {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 20px 24px;
            border: 1px solid #E3D5F2;
            border-left: 4px solid var(--purple);
            border-radius: 14px;
            background: linear-gradient(120deg, #FAF7FE, #FFFDF8);
            font-size: 12.5px;
            line-height: 1.7;
            color: #5B4D70;
        }

        .sop-note strong {
            color: var(--purple-dark);
        }

        /* RESPONSIVE */
        @media (max-width: 950px) {
            .content {
                width: calc(100% - 210px);
                margin-left: 210px;
                padding: 24px 20px;
            }
            .sidebar { width: 210px; }
        }

        @media (max-width: 720px) {
            .layout { display: block; }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 20px;
            }
            .content {
                width: 100%;
                margin: 0;
                padding: 20px 16px;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR KONSISTEN --}}
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas</small>
        </div>

        <div class="gold-line"></div>
        <div class="menu-title">{{ auth()->user()?->role === 'super_admin' ? 'MENU SUPER ADMIN' : 'MENU ADMIN' }}</div>

        <nav class="menu">
            {{-- 1. DASHBOARD --}}
            <a href="{{ route('dashboard') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>

            {{-- 2. DAFTAR PRESTASI --}}
            <a href="{{ route('admin.prestasi.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Daftar Prestasi
            </a>

            {{-- 3. VERIFIKASI PRESTASI --}}
            <a href="{{ route('admin.verifikasi.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </span>
                <span style="flex: 1;">Verifikasi Prestasi</span>
                @php
                    $badgePendingCount = rescue(fn() => \App\Models\Prestasi::where('status', 'menunggu_verifikasi')->count(), 0, false);
                @endphp
                @if ($badgePendingCount > 0)
                    <span class="sidebar-counter-badge">{{ $badgePendingCount }}</span>
                @endif
            </a>

            {{-- 4. MANAJEMEN AKUN (JIKA SUPER ADMIN) --}}
            @if(auth()->user()?->role === 'super_admin')
            <a href="{{ route('superadmin.users.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Manajemen Akun
            </a>
            @endif

            {{-- 5. PANDUAN PENGGUNAAN --}}
            <a href="{{ route('admin.panduan') }}" class="active">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                Panduan Penggunaan
            </a>
        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="content">

        {{-- TOP HEADER BAR --}}
        <header class="top-header">
            <div class="top-header-left">
                <div class="eyebrow">PUSAT DOKUMENTASI & PANDUAN SISTEM</div>
                <h1>Panduan Operasional SIPRESKA</h1>
            </div>
            <div class="user-profile-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>{{ auth()->user()->admin?->nama ?? (auth()->user()?->role === 'super_admin' ? 'Super Administrator' : 'Admin SIPRESKA') }}</span>
            </div>
        </header>

        {{-- WELCOME HERO --}}
        <section class="welcome">
            <h2>Pedoman Tata Kelola Prestasi Sivitas Akademika</h2>
            <p>
                Panduan standar bagi Administrator dan Super Administrator untuk memantau ringkasan statistik, menelaah keabsahan berkas bukti pengajuan, mengambil keputusan verifikasi yang tepat, serta mengelola data arsip sistem.
            </p>
        </section>

        {{-- 4 KARTU PANDUAN UTAMA --}}
        <section class="guide-grid">
            {{-- KARTU 1: DAFTAR PRESTASI --}}
            <article class="guide-card">
                <div class="guide-card-header">
                    <div class="guide-icon-badge">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    </div>
                    <span class="guide-step-tag">Tahap 01</span>
                </div>
                <h3>Eksplorasi Daftar Prestasi</h3>
                <p>Akses seluruh basis data prestasi sivitas yang tercatat di sistem dengan opsi filter dan pencarian komprehensif.</p>
                <ul>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Cari data seketika berdasarkan nama peserta, NIM/NIP, judul lomba, atau fakultas.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Gunakan filter Status, Tingkat (Internasional - Lokal), dan Kategori lomba.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Klik <strong>Lihat Rincian</strong> untuk membuka modal data lengkap prestasi dan dokumen bukti.</span>
                    </li>
                </ul>
            </article>

            {{-- KARTU 2: VERIFIKASI PRESTASI --}}
            <article class="guide-card">
                <div class="guide-card-header">
                    <div class="guide-icon-badge">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <span class="guide-step-tag">Tahap 02</span>
                </div>
                <h3>Alur Telaah & Verifikasi</h3>
                <p>Pemeriksaan ketat terhadap kesesuaian dokumen bukti (sertifikat, dokumentasi, SK) yang diajukan peserta.</p>
                <ul>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Buka menu <strong>Verifikasi Prestasi</strong> untuk meninjau antrean pengajuan baru.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Klik <strong>Telaah Berkas</strong> untuk membuka jendela modal pemeriksaan dokumen lengkap.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Ambil keputusan: <strong>Setujui Prestasi</strong> atau <strong>Tolak Pengajuan</strong> (disertai alasan jelas).</span>
                    </li>
                </ul>
            </article>

            {{-- KARTU 3: EKSPOR & REKAP DATA --}}
            <article class="guide-card">
                <div class="guide-card-header">
                    <div class="guide-icon-badge">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    </div>
                    <span class="guide-step-tag">Tahap 03</span>
                </div>
                <h3>Ekspor Laporan & Arsip</h3>
                <p>Unduh data sistem ke format CSV yang kompatibel penuh dengan Microsoft Excel dan spreadsheet eksternal.</p>
                <ul>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Tersedia tombol <strong>Ekspor Data Sistem</strong> di Dashboard dan Daftar Prestasi.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Pilihan ekspor: Seluruh Arsip, Prestasi Disetujui, Antrean Menunggu, dan Riwayat Ditolak.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Dapat mengekspor rekap Sivitas Mahasiswa, Dosen, serta Tren Perkembangan Tahunan.</span>
                    </li>
                </ul>
            </article>

            {{-- KARTU 4: MANAJEMEN AKUN & KEAMANAN --}}
            <article class="guide-card">
                <div class="guide-card-header">
                    <div class="guide-icon-badge">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <span class="guide-step-tag">Tahap 04</span>
                </div>
                <h3>Kewenangan & Tata Kelola Akun</h3>
                <p>Pengelolaan akun pengguna berhak akses khusus dengan pemisahan otoritas yang aman dan terstruktur.</p>
                <ul>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>Super Administrator:</strong> otoritas tertinggi untuk menambah akun, mengedit data, dan mereset kata sandi.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>Administrator:</strong> bertindak sebagai verifikator berkas dan pengelola arsip prestasi kampus.</span>
                    </li>
                    <li>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>Sivitas (Dosen & Mahasiswa):</strong> pengaju data capaian prestasi beserta berkas bukti otentik.</span>
                    </li>
                </ul>
            </article>
        </section>

        {{-- MATRIKS STATUS VERIFIKASI --}}
        <section class="status-matrix-card">
            <div class="status-matrix-header">
                <h3>Matriks Status Keputusan Verifikasi</h3>
                <p>Kenali arti setiap status pada siklus hidup data pengajuan prestasi sivitas:</p>
            </div>

            <div class="status-grid-3">
                <div class="status-box disetujui">
                    <strong>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Prestasi Disetujui
                    </strong>
                    <p>Berkas telah divalidasi keabsahannya oleh admin dan langsung terpublikasi secara otomatis di halaman publik serta portofolio sivitas.</p>
                </div>

                <div class="status-box menunggu">
                    <strong>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Menunggu Verifikasi
                    </strong>
                    <p>Pengajuan baru yang masuk ke dalam antrean sistem dan membutuhkan telaah berkas oleh administrator sebelum disetujui.</p>
                </div>

                <div class="status-box ditolak">
                    <strong>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Prestasi Ditolak
                    </strong>
                    <p>Pengajuan yang tidak memenuhi ketentuan standar validasi kampus. Catatan penolakan tersimpan di riwayat sistem.</p>
                </div>
            </div>
        </section>

        {{-- SOP CATATAN PENTING --}}
        <div class="sop-note">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple); flex-shrink:0; margin-top:1px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
                <strong>Standar Operasional Pemeriksaan:</strong>
                <span style="display:block; margin-top:4px;">
                    Pastikan selalu memeriksa kejelasan resolusi foto/scan sertifikat, mencocokkan nama peserta dengan NIM/NIP sivitas yang terdaftar, serta memverifikasi kesesuaian kategori kompetisi sebelum memberikan status persetujuan akhir.
                </span>
            </div>
        </div>

    </main>
</div>
</body>
</html>
