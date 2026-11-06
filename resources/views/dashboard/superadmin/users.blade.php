<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun & Pengguna (Super Admin) | SIPRESKA</title>
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
            --gold: #C9A227;
            --text: #30283D;
            --muted: #81788F;
            --border: #EAE4F1;
            --lavender: #F5F0FB;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF, #F8F5FC 48%, #EEE5F8);
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
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #655B73;
            text-decoration: none;
            font-size: 13px;
            line-height: 1.5;
            transition: background .2s, color .2s;
        }

        .menu a:hover, .menu a.active {
            background: linear-gradient(110deg,#F0EAF8,#E3D5F3);
            color: var(--purple);
        }

        .menu a.active {
            border-color: #E5D9F3;
            box-shadow: inset 3px 0 0 var(--purple);
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

        .menu a.active .menu-icon { background: #FFFFFF; }

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
            background: transparent;
            color: #B64B57;
            text-align: left;
            font-size: 13px;
            cursor: pointer;
            transition: background .2s;
        }

        .logout button:hover { background: #FFF1F2; }

        /* CONTENT */
        .content {
            width: calc(100% - 250px);
            min-width: 0;
            margin-left: 250px;
            padding: 36px 40px;
        }

        .welcome {
            margin-bottom: 26px;
            padding: 24px 28px;
            border: 1px solid #E3D5F2;
            border-left: 5px solid var(--gold);
            border-radius: 15px;
            background: linear-gradient(115deg,#FFFFFF,#F6F0FC 52%,#E7D9F5);
            box-shadow: 0 10px 30px rgba(91,58,142,.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .eyebrow {
            margin-bottom: 8px;
            color: #8060A8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        h1 { margin: 0 0 8px; color: var(--purple-dark); font-size: 26px; }
        .welcome p { margin: 0; color: #776C88; font-size: 13px; line-height: 1.7; }

        .btn-add-user {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(91,58,142,.2);
            transition: transform .15s, box-shadow .15s;
        }

        .btn-add-user:hover {
            transform: translateY(-2px);
            box-shadow: 0 9px 22px rgba(91,58,142,.3);
        }

        /* NOTICES */
        .notice {
            margin-bottom: 20px;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notice.success {
            background: #EAF8EE;
            border: 1px solid #B8E4C3;
            color: #246B39;
        }

        .notice.error {
            background: #FDF2F4;
            border: 1px solid #F5C6CC;
            color: #9A2F3D;
        }

        /* STATS */
        .stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 26px;
        }

        .stat-card {
            padding: 16px 18px;
            border: 1px solid #E7DFF0;
            border-top: 3px solid var(--purple);
            border-radius: 12px;
            background: #FFFFFF;
            box-shadow: 0 6px 18px rgba(67,39,101,.04);
        }

        .stat-card:nth-child(2) { border-top-color: var(--gold); }
        .stat-card:nth-child(3) { border-top-color: #5B3A8E; }
        .stat-card:nth-child(4) { border-top-color: #3A9D68; }
        .stat-card:nth-child(5) { border-top-color: #4A90E2; }

        .stat-label { margin-bottom: 8px; color: var(--muted); font-size: 11px; }
        .stat-number { color: var(--purple-dark); font-size: 24px; font-weight: 800; }

        /* PANEL */
        .panel {
            padding: 24px 28px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #FFFFFF;
            box-shadow: 0 8px 26px rgba(67,39,101,.04);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .panel-title { margin: 0; color: var(--purple-dark); font-size: 18px; font-weight: 800; }

        /* SEARCH & FILTER BAR */
        .filter-form {
            display: grid;
            grid-template-columns: minmax(220px, 2fr) repeat(2, minmax(140px, 1fr)) auto;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-input, .filter-select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #DDD1EA;
            border-radius: 9px;
            background: #FAF8FD;
            font-size: 12px;
            color: var(--text);
        }

        .filter-input:focus, .filter-select:focus {
            outline: 0;
            border-color: var(--purple);
            background: #FFFFFF;
        }

        .btn-filter {
            padding: 11px 18px;
            border: 0;
            border-radius: 9px;
            background: var(--purple);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-reset {
            padding: 11px 14px;
            border: 1px solid #DDD1EA;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        /* TABEL PENGGUNA */
        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 12px;
        }

        .users-table thead { background: #F6F1FB; }

        .users-table th {
            padding: 14px 16px;
            color: #6C5B82;
            font-weight: 700;
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }

        .users-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #F2ECF8;
            vertical-align: middle;
            color: #554866;
        }

        .users-table tbody tr:hover { background: #FAF7FE; }

        .user-identity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #EFE7F8;
            color: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .user-name-box strong {
            display: block;
            color: var(--purple-dark);
            font-size: 13px;
        }

        .user-name-box span {
            color: var(--muted);
            font-size: 11px;
        }

        /* BADGES */
        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 16px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .role-badge.super_admin { background: #FFF3CD; color: #856404; border: 1px solid #FFEEBA; }
        .role-badge.admin { background: #EAE0F5; color: var(--purple); }
        .role-badge.dosen { background: #E3F5E7; color: #28653D; }
        .role-badge.mahasiswa { background: #E7F1FF; color: #1D5DA3; }

        .status-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
        }

        .status-pill.aktif { background: #EAF8EE; color: #246B39; }
        .status-pill.nonaktif { background: #FDF2F4; color: #9A2F3D; }

        /* ACTION BUTTONS */
        .actions-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-action-icon {
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .15s;
        }

        .btn-action-password {
            background: #FFF9E6;
            border-color: #F7E4A8;
            color: #8C6A18;
        }

        .btn-action-password:hover { background: #FCECB8; }

        .btn-action-edit {
            background: #F3EDFA;
            border-color: #E0CEF5;
            color: var(--purple);
        }

        .btn-action-edit:hover { background: #E8DCF7; }

        .btn-action-delete {
            background: #FFF1F2;
            border-color: #F8D0D5;
            color: #AC3A48;
        }

        .btn-action-delete:hover { background: #FCD8DC; }

        /* PAGINATION */
        .pagination-wrap { margin-top: 18px; }

        /* MODALS */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(48,40,61,.55);
            backdrop-filter: blur(3px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-backdrop.show { display: flex; animation: modalFade .15s ease-out; }

        @keyframes modalFade {
            from { opacity: 0; transform: scale(.97); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-card {
            width: 100%;
            max-width: 520px;
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 15px 40px rgba(67,39,101,.18);
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 20px 24px;
            background: #FAF8FD;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 { margin: 0; color: var(--purple-dark); font-size: 16px; font-weight: 800; }

        .modal-close {
            background: transparent;
            border: 0;
            font-size: 20px;
            color: var(--muted);
            cursor: pointer;
            line-height: 1;
        }

        .modal-body {
            padding: 22px 24px;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 700;
            color: var(--purple-dark);
        }

        .form-control {
            width: 100%;
            padding: 10px 13px;
            border: 1px solid #DDD1EA;
            border-radius: 8px;
            font-size: 12px;
            background: #FAF8FD;
            color: var(--text);
        }

        .form-control:focus {
            outline: 0;
            border-color: var(--purple);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(91,58,142,.1);
        }

        .modal-footer {
            padding: 16px 24px;
            background: #FAF8FD;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-secondary {
            padding: 10px 16px;
            border: 1px solid #DDD1EA;
            border-radius: 8px;
            background: #FFFFFF;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-primary {
            padding: 10px 18px;
            border: 0;
            border-radius: 8px;
            background: var(--purple);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-primary:hover { background: var(--purple-dark); }

        @media (max-width: 950px) {
            .content { width: calc(100% - 210px); margin-left: 210px; padding: 25px 20px; }
            .sidebar { width: 210px; }
            .stats { grid-template-columns: repeat(3, minmax(0,1fr)); }
            .filter-form { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 720px) {
            .layout { display: block; }
            .sidebar { position: relative; width: 100%; height: auto; min-height: 0; }
            .content { width: 100%; margin: 0; padding: 20px 16px; }
            .stats { grid-template-columns: 1fr 1fr; }
            .filter-form { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR ADMIN / SUPER ADMIN --}}
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas</small>
        </div>

        <div class="gold-line"></div>
        <div class="menu-title">MENU SUPER ADMIN</div>

        <nav class="menu">
            <a href="{{ route('dashboard') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>

            <a href="{{ route('superadmin.users.index') }}" class="active">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Manajemen Akun
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

            <a href="{{ route('admin.panduan') }}">
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

    {{-- KONTEN UTAMA --}}
    <main class="content">

        <section class="welcome">
            <div>
                <div class="eyebrow">HAK AKSES KHUSUS &bull; TINGKAT TERTINGGI</div>
                <h1>👑 Manajemen Akun & Pengguna</h1>
                <p>
                    Kelola akun Administrator, Mahasiswa, dan Dosen. Anda memiliki hak akses penuh untuk membuat akun, mengatur hak akses, dan mereset kata sandi pengguna.
                </p>
            </div>

            <button type="button" class="btn-add-user" onclick="openCreateModal()">
                <span>+ Tambah Akun Baru</span>
            </button>
        </section>

        {{-- ALERT MESSAGES --}}
        @if (session('success'))
            <div class="notice success">
                <span>✅ {{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" style="background:transparent;border:0;cursor:pointer;font-weight:bold;">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="notice error">
                <span>❌ {{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" style="background:transparent;border:0;cursor:pointer;font-weight:bold;">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="notice error">
                <div>
                    <strong>Perhatian:</strong>
                    <ul style="margin: 4px 0 0; padding-left: 18px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- STATISTIK AKUN --}}
        <section class="stats">
            <div class="stat-card">
                <div class="stat-label">Total Semua Akun</div>
                <div class="stat-number">{{ number_format($totalSemua, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Super Administrator</div>
                <div class="stat-number">{{ number_format($totalSuperAdmin, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Administrator</div>
                <div class="stat-number">{{ number_format($totalAdmin, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Akun Mahasiswa</div>
                <div class="stat-number">{{ number_format($totalMahasiswa, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Akun Dosen</div>
                <div class="stat-number">{{ number_format($totalDosen, 0, ',', '.') }}</div>
            </div>
        </section>

        {{-- PANEL DAFTAR PENGGUNA --}}
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Daftar Akun Pengguna Sistem</h2>
                </div>
            </div>

            {{-- SEARCH & FILTER FORM --}}
            <form action="{{ route('superadmin.users.index') }}" method="GET" class="filter-form">
                <input
                    type="search"
                    name="q"
                    class="filter-input"
                    placeholder="Cari nama, NIM/NIP, email pengguna..."
                    value="{{ $q }}"
                >

                <select name="role" class="filter-select">
                    <option value="">Semua Peran (Role)</option>
                    <option value="super_admin" @selected($roleFilter === 'super_admin')>👑 Super Admin</option>
                    <option value="admin" @selected($roleFilter === 'admin')>🛡️ Administrator</option>
                    <option value="dosen" @selected($roleFilter === 'dosen')>👨‍🏫 Dosen</option>
                    <option value="mahasiswa" @selected($roleFilter === 'mahasiswa')>🎓 Mahasiswa</option>
                </select>

                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected($statusFilter === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected($statusFilter === 'nonaktif')>Nonaktif</option>
                </select>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn-filter">Cari</button>
                    @if ($q || $roleFilter || $statusFilter)
                        <a href="{{ route('superadmin.users.index') }}" class="btn-reset">Reset</a>
                    @endif
                </div>
            </form>

            {{-- TABEL PENGGUNA --}}
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Pengguna / Identitas</th>
                            <th>Peran (Role)</th>
                            <th>Kontak & Email</th>
                            <th>Fakultas / Prodi / Jabatan</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi Super Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            @php
                                $nama = $u->admin?->nama ?? $u->sivitas?->nama ?? 'Tanpa Nama';
                                $email = $u->admin?->email ?? $u->sivitas?->email ?? '—';
                                $noHp = $u->admin?->no_hp ?? $u->sivitas?->no_hp ?? '—';
                                $jabatan = $u->admin?->jabatan ?? '—';
                                $prodi = $u->sivitas?->program_studi ?? $jabatan;
                                $fakultas = $u->sivitas?->fakultas ?? '—';
                                $status = $u->sivitas?->status ?? 'aktif';
                                $inisial = strtoupper(substr($nama, 0, 2));
                            @endphp
                            <tr>
                                <td>
                                    <div class="user-identity">
                                        <div class="user-avatar">{{ $inisial }}</div>
                                        <div class="user-name-box">
                                            <strong>{{ $nama }}</strong>
                                            <span>NIM/NIP: {{ $u->nim_nip ?: '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge {{ $u->role }}">
                                        {{ str_replace('_', ' ', $u->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $email }}</div>
                                    <small style="color: var(--muted);">{{ $noHp !== '—' ? $noHp : '' }}</small>
                                </td>
                                <td>
                                    <div>{{ $prodi }}</div>
                                    @if ($fakultas !== '—' && $fakultas !== 'Belum diisi')
                                        <small style="color: var(--muted);">{{ $fakultas }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-pill {{ $status }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-cell" style="justify-content: flex-end;">
                                        {{-- TOMBOL UBAH PASSWORD --}}
                                        <button
                                            type="button"
                                            class="btn-action-icon btn-action-password"
                                            title="Ubah Kata Sandi"
                                            onclick='openPasswordModal(@json($u->id), @json($nama), @json($u->nim_nip))'
                                        >
                                            <span>🔑 Password</span>
                                        </button>

                                        {{-- TOMBOL EDIT AKUN --}}
                                        <button
                                            type="button"
                                            class="btn-action-icon btn-action-edit"
                                            title="Edit Data Pengguna"
                                            onclick='openEditModal(@json($u->id), @json($nama), @json($u->nim_nip), @json($email), @json($u->role), @json($status), @json($u->admin?->jabatan), @json($u->sivitas?->program_studi), @json($u->sivitas?->fakultas), @json($noHp))'
                                        >
                                            <span>✏️ Edit</span>
                                        </button>

                                        {{-- TOMBOL HAPUS AKUN --}}
                                        @if ($u->id !== auth()->id())
                                            <form action="{{ route('superadmin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $nama }}? Tindakan ini tidak dapat dibatalkan.');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-icon btn-action-delete" title="Hapus Akun">
                                                    <span>🗑️</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: var(--muted);">
                                    Tidak ada data akun pengguna yang cocok dengan kriteria pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $users->links() }}
            </div>
        </section>

    </main>
</div>

{{-- MODAL TAMBAH AKUN BARU --}}
<div class="modal-backdrop" id="modalCreate">
    <div class="modal-card">
        <div class="modal-header">
            <h3>+ Tambah Akun Pengguna Baru</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalCreate')">&times;</button>
        </div>
        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Ahmad Fauzi, M.Kom" required>
                </div>
                <div class="form-group">
                    <label>Peran (Role) *</label>
                    <select name="role" class="form-control" id="createRoleSelect" onchange="toggleRoleFields('create')" required>
                        <option value="admin">🛡️ Administrator</option>
                        <option value="super_admin">👑 Super Administrator</option>
                        <option value="dosen">👨‍🏫 Dosen</option>
                        <option value="mahasiswa">🎓 Mahasiswa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>NIM / NIP / Username Login *</label>
                    <input type="text" name="nim_nip" class="form-control" placeholder="Nomor identitas atau username" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="email@uinssc.ac.id" required>
                </div>
                <div class="form-group">
                    <label>Kata Sandi Awal * (Min. 6 Karakter)</label>
                    <input type="password" name="password" class="form-control" placeholder="Tentukan kata sandi awal" required minlength="6">
                </div>
                <div id="createAdminFields">
                    <div class="form-group">
                        <label>Jabatan / Unit</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Staf Kemahasiswaan">
                    </div>
                </div>
                <div id="createSivitasFields" style="display:none;">
                    <div class="form-group">
                        <label>Fakultas</label>
                        <input type="text" name="fakultas" class="form-control" placeholder="Contoh: Ilmu Tarbiyah dan Keguruan">
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" name="program_studi" class="form-control" placeholder="Contoh: Informatika">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nomor Handphone (Opsional)</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalCreate')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Akun Baru</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UBAH KATA SANDI (SUPER ADMIN) --}}
<div class="modal-backdrop" id="modalPassword">
    <div class="modal-card">
        <div class="modal-header">
            <h3>🔑 Ubah Kata Sandi Akun</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalPassword')">&times;</button>
        </div>
        <form id="formUpdatePassword" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <p style="font-size: 13px; color: var(--muted); margin-top: 0;">
                    Anda mengubah kata sandi untuk akun <strong id="pwModalUserName" style="color:var(--purple-dark);"></strong> (<span id="pwModalUserNip"></span>).
                </p>
                <div class="form-group">
                    <label>Kata Sandi Baru * (Min. 6 Karakter)</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Kata Sandi Baru *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" required minlength="6">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalPassword')">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Kata Sandi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT DATA AKUN --}}
<div class="modal-backdrop" id="modalEdit">
    <div class="modal-card">
        <div class="modal-header">
            <h3>✏️ Edit Data Akun</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Peran (Role) *</label>
                    <select name="role" id="editRole" class="form-control" onchange="toggleRoleFields('edit')" required>
                        <option value="super_admin">👑 Super Administrator</option>
                        <option value="admin">🛡️ Administrator</option>
                        <option value="dosen">👨‍🏫 Dosen</option>
                        <option value="mahasiswa">🎓 Mahasiswa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>NIM / NIP / Username Login *</label>
                    <input type="text" name="nim_nip" id="editNimNip" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" id="editEmail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status Akun</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div id="editAdminFields">
                    <div class="form-group">
                        <label>Jabatan / Unit</label>
                        <input type="text" name="jabatan" id="editJabatan" class="form-control">
                    </div>
                </div>
                <div id="editSivitasFields" style="display:none;">
                    <div class="form-group">
                        <label>Fakultas</label>
                        <input type="text" name="fakultas" id="editFakultas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" name="program_studi" id="editProdi" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nomor Handphone</label>
                    <input type="text" name="no_hp" id="editNoHp" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openCreateModal() {
        document.getElementById('modalCreate').classList.add('show');
        toggleRoleFields('create');
    }

    function openPasswordModal(userId, name, nimNip) {
        const modal = document.getElementById('modalPassword');
        document.getElementById('pwModalUserName').textContent = name;
        document.getElementById('pwModalUserNip').textContent = nimNip || 'Tanpa NIM/NIP';
        document.getElementById('formUpdatePassword').action = `/superadmin/users/${userId}/password`;
        modal.classList.add('show');
    }

    function openEditModal(userId, nama, nimNip, email, role, status, jabatan, prodi, fakultas, noHp) {
        const modal = document.getElementById('modalEdit');
        document.getElementById('editNama').value = nama || '';
        document.getElementById('editNimNip').value = nimNip || '';
        document.getElementById('editEmail').value = (email && email !== '—') ? email : '';
        document.getElementById('editRole').value = role;
        document.getElementById('editStatus').value = status || 'aktif';
        document.getElementById('editJabatan').value = (jabatan && jabatan !== '—') ? jabatan : '';
        document.getElementById('editProdi').value = (prodi && prodi !== '—') ? prodi : '';
        document.getElementById('editFakultas').value = (fakultas && fakultas !== '—') ? fakultas : '';
        document.getElementById('editNoHp').value = (noHp && noHp !== '—') ? noHp : '';

        document.getElementById('formEditUser').action = `/superadmin/users/${userId}`;
        toggleRoleFields('edit');
        modal.classList.add('show');
    }

    function toggleRoleFields(prefix) {
        const role = document.getElementById(prefix + 'Role' + (prefix === 'create' ? 'Select' : '')).value;
        const adminFields = document.getElementById(prefix + 'AdminFields');
        const sivitasFields = document.getElementById(prefix + 'SivitasFields');

        if (role === 'admin' || role === 'super_admin') {
            adminFields.style.display = 'block';
            sivitasFields.style.display = 'none';
        } else {
            adminFields.style.display = 'none';
            sivitasFields.style.display = 'block';
        }
    }

    // Tutup modal jika klik di luar box
    document.querySelectorAll('.modal-backdrop').forEach((backdrop) => {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.classList.remove('show');
            }
        });
    });
</script>
</body>
</html>

