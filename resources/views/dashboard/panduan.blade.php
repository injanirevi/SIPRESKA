<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Penggunaan SIPRESKA | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar,
        .sidebar * {
            font-family: Arial, sans-serif;
        }

        :root {
            --purple: #5B3A8E;
            --deep: #432765;
            --lavender: #EEE6F8;
            --gold: #C9A227;
            --text: #342847;
            --muted: #80758F;
            --border: #E7DFF0;
        }

        body {
            margin: 0;
            color: var(--text);
            background: linear-gradient(135deg,#fff 0%,#F8F5FC 50%,#EBE1F7 100%);
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            display: flex;
            flex-direction: column;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid var(--border);
            z-index: 2;
        }

        .logo {
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            color: var(--purple);
        }

        .logo small {
            display: block;
            margin-top: 8px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.7;
        }

        .gold-line {
            width: 45px;
            height: 3px;
            margin: 17px 10px 30px;
            border-radius: 4px;
            background: var(--gold);
        }

        .menu-title {
            margin: 0 10px 12px;
            color: #A096AF;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
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
            color: #665A77;
            font-size: 13px;
            text-decoration: none;
        }

        .menu a:hover,
        .menu a.active {
            color: var(--purple);
            background: linear-gradient(110deg,#F3EEF9,#E7DCF5);
        }

        .menu a.active {
            border-color: #DED0EE;
            box-shadow: inset 3px 0 var(--purple);
            font-weight: 700;
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
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: #FCF4F5;
            color: #AC4655;
            text-align: left;
            cursor: pointer;
        }

        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 36px 38px;
        }

        .welcome {
            margin-bottom: 25px;
            padding: 28px;
            border: 1px solid #E4D7F2;
            border-left: 5px solid var(--gold);
            border-radius: 15px;
            background: linear-gradient(115deg,#fff 5%,#F0E7FB 100%);
            box-shadow: 0 8px 25px rgba(67,39,101,.06);
        }

        .eyebrow {
            margin-bottom: 10px;
            color: #8864B1;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 0 0 10px;
            color: var(--deep);
            font-size: 28px;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .guide-grid {
            display: grid;
            grid-template-columns: repeat(2,minmax(0,1fr));
            gap: 17px;
        }

        .guide-card {
            padding: 23px;
            border: 1px solid var(--border);
            border-top: 3px solid var(--purple);
            border-radius: 13px;
            background: rgba(255,255,255,.97);
            box-shadow: 0 7px 24px rgba(67,39,101,.05);
        }

        .number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            margin-bottom: 14px;
            border: 1px solid #E1D3F1;
            border-radius: 10px;
            background: #EFE7F8;
            color: var(--purple);
            font-weight: 800;
        }

        .guide-card h2 {
            margin: 0 0 11px;
            color: var(--deep);
            font-size: 17px;
        }

        .guide-card p,
        .guide-card li {
            color: #766B85;
            font-size: 13px;
            line-height: 1.9;
        }

        .guide-card ul {
            margin: 9px 0 0;
            padding-left: 20px;
        }

        .tip {
            margin-top: 20px;
            padding: 19px 22px;
            border: 1px solid #E4D7F2;
            border-left: 4px solid var(--gold);
            border-radius: 11px;
            background: #F7F2FC;
            color: #655477;
            font-size: 13px;
            line-height: 1.8;
        }

        @media (max-width: 800px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                overflow: visible;
                padding: 20px;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }

            .logout {
                position: static;
                margin-top: 20px;
            }

            .content {
                width: 100%;
                margin-left: 0;
                padding: 22px 16px;
            }

            .guide-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
        SIPRESKA
        <small>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas Akademika</small>
    </div>
    <div class="gold-line"></div>
    <div class="menu-title">MENU ADMIN</div>

    <nav class="menu">
        <a href="{{ route('dashboard') }}">
            <span class="menu-icon" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </span>
            Dashboard
        </a>
        <a href="{{ route('admin.prestasi.index') }}">
            <span class="menu-icon" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
            </span>
            Daftar Prestasi
        </a>
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
        @if(auth()->user()?->role === 'super_admin')
        <a href="{{ route('superadmin.users.index') }}">
            <span class="menu-icon" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </span>
            Manajemen Akun
        </a>
        @endif
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
            <button type="submit">Keluar dari Akun</button>
        </form>
    </div>
</aside>

<main class="content">
    <section class="welcome">
        <div class="eyebrow">PUSAT BANTUAN ADMIN</div>
        <h1>Panduan Penggunaan SIPRESKA</h1>
        <p>
            Panduan singkat untuk mengelola data, memeriksa pengajuan,
            dan memastikan prestasi yang dipublikasikan telah melalui verifikasi.
        </p>
    </section>

    <section class="guide-grid">
        <article class="guide-card">
            <div class="number">01</div>
            <h2>Daftar Prestasi</h2>
            <p>
                Gunakan menu Daftar Prestasi untuk melihat data prestasi yang tersimpan.
                Kamu dapat mencari nama prestasi dan menyaring data berdasarkan status
                atau tingkat kompetisi.
            </p>
        </article>

        <article class="guide-card">
            <div class="number">02</div>
            <h2>Verifikasi Prestasi</h2>
            <p>Periksa informasi prestasi dan bukti yang diberikan oleh pengaju.</p>
            <ul>
                <li><strong>Disetujui:</strong> pengajuan dinyatakan layak.</li>
                <li><strong>Perlu Perbaikan:</strong> pengaju perlu memperbaiki data atau bukti.</li>
                <li><strong>Ditolak:</strong> pengajuan tidak disetujui; isi catatan penolakan.</li>
            </ul>
        </article>

        <article class="guide-card">
            <div class="number">03</div>
            <h2>Publikasi Prestasi</h2>
            <p>
                Prestasi yang berstatus Disetujui dapat muncul pada halaman publik.
                Pastikan informasi yang disimpan sudah benar sebelum menyelesaikan verifikasi.
            </p>
        </article>

        <article class="guide-card">
            <div class="number">04</div>
            <h2>Memeriksa Status</h2>
            <p>
                Gunakan status pada daftar prestasi untuk membedakan pengajuan yang
                masih menunggu, sudah disetujui, perlu perbaikan, atau ditolak.
            </p>
        </article>
    </section>

    <div class="tip">
        <strong>Catatan:</strong> periksa nama prestasi, tahun, penyelenggara, anggota,
        dan dokumen bukti sebelum memutuskan hasil verifikasi.
    </div>
</main>
</body>
</html>