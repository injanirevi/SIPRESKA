<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        .sidebar, .sidebar * { font-family: Arial, sans-serif; }

        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --purple-mid: #8058B8;
            --gold: #C9A227;
            --text: #30283D;
            --muted: #81788F;
            --border: #EAE4F1;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF 0%, #F8F5FC 48%, #EEE5F8 100%);
        }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
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
            z-index: 10;
        }

        .logo {
            display: block;
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(90deg,#8058B8,#5B3A8E,#432765);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-decoration: none;
        }

        .logo span {
            display: block;
            max-width: 190px;
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.6;
            letter-spacing: 0;
        }

        .gold-line {
            width: 42px;
            height: 3px;
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

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: #655B73;
            line-height: 1.5;
            font-size: 13px;
            text-decoration: none;
            transition: background .2s, color .2s, transform .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(110deg,#F0EAF8,#E3D5F3);
            color: var(--purple);
        }

        .menu a.active {
            border-color: #E5D9F3;
            box-shadow: inset 3px 0 0 var(--purple);
            font-weight: 700;
        }

        .menu a:hover {
            transform: translateX(2px);
        }

        .menu-icon {
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

        .menu a.active .menu-icon {
            background: #FFFFFF;
        }

        .logout {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #B64B57;
            text-align: left;
            font-size: 13px;
            cursor: pointer;
        }

        .logout button:hover { background: #FFF1F2; }

        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 34px 36px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 27px;
        }

        .eyebrow {
            margin-bottom: 9px;
            color: #8060A8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 0 0 9px;
            color: var(--purple-dark);
            font-size: 28px;
        }

        .header p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .profile {
            padding: 12px 16px;
            border: 1px solid #E6DDF0;
            border-radius: 11px;
            background: linear-gradient(135deg,#FFFFFF,#F7F2FC);
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
        }

        .welcome {
            position: relative;
            overflow: hidden;
            margin-bottom: 29px;
            padding: 29px;
            border: 1px solid #E3D5F2;
            border-left: 4px solid var(--gold);
            border-radius: 16px;
            background: linear-gradient(115deg,#FFFFFF,#F6F0FC 52%,#E7D9F5);
            box-shadow: 0 10px 30px rgba(91,58,142,.06);
        }

        .welcome h2 {
            margin: 0 0 9px;
            color: var(--purple-dark);
            font-size: 22px;
        }

        .welcome p {
            max-width: 650px;
            margin: 0;
            color: #776C88;
            font-size: 13px;
            line-height: 1.8;
        }

        .section-title {
            margin: 0 0 16px;
            color: var(--purple-dark);
            font-size: 17px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4,minmax(0,1fr));
            gap: 16px;
            margin-bottom: 30px;
        }

        .card {
            min-width: 0;
            padding: 22px 20px;
            border: 1px solid #E7DFF0;
            border-top: 3px solid var(--purple);
            border-radius: 14px;
            background: linear-gradient(145deg,#FFFFFF,#F8F3FC);
            box-shadow: 0 7px 22px rgba(67,39,101,.05);
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 13px 28px rgba(67,39,101,.09);
        }

        .card.pending { border-top-color: #C9A227; }
        .card.approved { border-top-color: #41976B; }
        .card.rejected { border-top-color: #C45B68; }

        .card-label { margin-bottom: 14px; color: var(--muted); font-size: 12px; }
        .card-number { color: var(--purple); font-size: 30px; font-weight: 800; }
        .card-note { margin-top: 9px; color: #9589A7; font-size: 10px; line-height: 1.5; }

        .actions {
            display: grid;
            grid-template-columns: repeat(2,minmax(0,1fr));
            gap: 18px;
        }

        .action-card {
            padding: 24px;
            border: 1px solid #E7DFF0;
            border-radius: 14px;
            background: linear-gradient(145deg,#FFFFFF,#FAF7FE);
            box-shadow: 0 6px 22px rgba(67,39,101,.045);
        }

        .action-card h3 {
            margin: 0 0 10px;
            color: var(--purple);
            font-size: 16px;
        }

        .action-card p {
            margin: 0 0 19px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .action-link {
            display: inline-block;
            padding: 11px 16px;
            border: 1px solid var(--purple);
            border-radius: 9px;
            background: linear-gradient(120deg,#8058B8,#5B3A8E 55%,#432765);
            color: white;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .action-link:hover {
            background: linear-gradient(120deg,#6C46A2,#472D70);
            color: white;
        }

        @media (max-width: 1200px) {
            .content { padding: 28px 24px; }
            .cards { grid-template-columns: repeat(2,minmax(0,1fr)); }
        }

        @media (max-width: 700px) {
            .layout { display: block; }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                overflow: visible;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }
            .logout { margin-top: 20px; }
            .content { width: 100%; margin: 0; padding: 24px 16px; }
            .cards { grid-template-columns: repeat(2,minmax(0,1fr)); }
            .header { align-items: flex-start; flex-direction: column; }
            .actions { grid-template-columns: 1fr; }
        }

        @media (max-width: 380px) {
            .cards { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="layout">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <span>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas Akademika</span>
        </a>

        <div class="gold-line"></div>
        <div class="menu-title">MENU MAHASISWA</div>

        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">⌂</span>
                Dashboard
            </a>
            <a href="{{ route('prestasi') }}" class="{{ request()->routeIs('prestasi') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">▤</span>
                Daftar Prestasi
            </a>
            <a href="{{ route('prestasi.create') }}" class="{{ request()->routeIs('prestasi.create') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">＋</span>
                Pengajuan Prestasi
            </a>
            <a href="{{ route('panduan') }}" class="{{ request()->routeIs('panduan') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">ⓘ</span>
                Panduan Penggunaan
            </a>
        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Keluar dari Akun</button>
            </form>
        </div>
    </aside>

    <main class="content">
        <header class="header">
            <div>
                <div class="eyebrow">DASHBOARD MAHASISWA</div>
                <h1>Dashboard Saya</h1>
                <p>Pantau pengajuan dan informasi prestasimu di SIPRESKA.</p>
            </div>
            <div class="profile">{{ session('campus_display_name', auth()->user()->sivitas?->nama ?? 'Mahasiswa') }}</div>
        </header>

        <section class="welcome">
            <h2>Selamat datang, {{ session('campus_display_name', auth()->user()->sivitas?->nama ?? 'Mahasiswa') }}!</h2>
            <p>Kelola pengajuan prestasimu dan lihat informasi prestasi sivitas akademika melalui satu sistem.</p>
        </section>

        <h2 class="section-title">Ringkasan Prestasi Saya</h2>

        <section class="cards">
            <div class="card">
                <div class="card-label">Total Prestasi</div>
                <div class="card-number">{{ $totalPrestasiMahasiswa ?? 0 }}</div>
                <div class="card-note">Prestasi yang tercatat</div>
            </div>
            <div class="card pending">
                <div class="card-label">Menunggu Verifikasi</div>
                <div class="card-number">{{ $pengajuanMenunggu ?? 0 }}</div>
                <div class="card-note">Pengajuan dalam proses</div>
            </div>
            <div class="card approved">
                <div class="card-label">Disetujui</div>
                <div class="card-number">{{ $prestasiDisetujui ?? 0 }}</div>
                <div class="card-note">Pengajuan yang disetujui</div>
            </div>
            <div class="card rejected">
                <div class="card-label">Ditolak</div>
                <div class="card-number">{{ $prestasiDitolak ?? 0 }}</div>
                <div class="card-note">Pengajuan ditolak</div>
            </div>
        </section>

        <h2 class="section-title">Akses Cepat</h2>

        <section class="actions">
            <div class="action-card">
                <h3>Ajukan Prestasi</h3>
                <p>Catat pencapaianmu dan lengkapi dokumen pendukung sesuai ketentuan pengajuan.</p>
                <a href="{{ route('prestasi.create') }}" class="action-link">Buat Pengajuan →</a>
            </div>
            <div class="action-card">
                <h3>Jelajahi Prestasi</h3>
                <p>Lihat daftar prestasi yang telah tercatat di SIPRESKA.</p>
                <a href="{{ route('prestasi') }}" class="action-link">Lihat Prestasi →</a>
            </div>
        </section>
    </main>
</div>
</body>
</html>
