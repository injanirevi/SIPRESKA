@php
    abort_unless(
        auth()->check() && auth()->user()->role === 'dosen',
        403
    );
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --purple-light: #F0EAF8;
            --gold: #C9A227;
            --text: #30283D;
            --muted: #81788F;
            --border: #EAE4F1;
            --white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar,
        .sidebar * {
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF, #F8F5FC 48%, #EEE5F8);
        }

        a {
            -webkit-tap-highlight-color: transparent;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

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
            color: var(--purple);
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
            text-decoration: none;
        }

        .logo small {
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
            text-decoration: none;
            font-size: 13px;
            line-height: 1.5;
            transition: background .2s, color .2s, transform .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(110deg, #F0EAF8, #E3D5F3);
            color: var(--purple);
        }

        .menu a:hover {
            transform: translateX(2px);
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

        .menu a.active .menu-icon {
            background: #FFFFFF;
        }

        .logout {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .logout form {
            margin: 0;
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

        .logout button:hover {
            background: #FFF1F2;
        }

        /* KONTEN UTAMA */

        .content {
            width: calc(100% - 250px);
            min-width: 0;
            margin-left: 250px;
            padding: 36px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .eyebrow {
            margin-bottom: 10px;
            color: #8060A8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        h1 {
            margin: 0 0 9px;
            color: var(--purple-dark);
            font-size: clamp(25px, 3vw, 32px);
            line-height: 1.25;
        }

        .header p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 240px;
            padding: 11px 15px;
            border: 1px solid #E6DDF0;
            border-radius: 12px;
            background: linear-gradient(135deg, #FFFFFF, #F7F2FC);
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .profile-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--purple-light);
            color: var(--purple);
            font-size: 15px;
        }

        /* SAMBUTAN */

        .welcome {
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            padding: 28px;
            border: 1px solid #E3D5F2;
            border-left: 4px solid var(--gold);
            border-radius: 16px;
            background:
                radial-gradient(circle at 95% 10%, rgba(255,255,255,.8), transparent 30%),
                linear-gradient(115deg, #FFFFFF, #F6F0FC 52%, #E7D9F5);
            box-shadow: 0 10px 30px rgba(91,58,142,.06);
        }

        .welcome-label {
            display: inline-block;
            margin-bottom: 12px;
            color: #8060A8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .welcome h2 {
            margin: 0 0 10px;
            color: var(--purple-dark);
            font-size: 22px;
            line-height: 1.4;
        }

        .welcome p {
            max-width: 650px;
            margin: 0;
            color: #776C88;
            font-size: 13px;
            line-height: 1.9;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 19px;
            padding: 12px 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            background: linear-gradient(120deg, #69469A, #432765);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 7px 18px rgba(91,58,142,.16);
            transition: transform .2s, box-shadow .2s;
        }

        .btn-primary:hover {
            color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 11px 24px rgba(91,58,142,.23);
        }

        /* STATISTIK */

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 16px;
        }

        .section-title {
            margin: 0 0 6px;
            color: var(--purple-dark);
            font-size: 18px;
        }

        .section-description {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            min-width: 0;
            padding: 20px;
            border: 1px solid #E7DFF0;
            border-top: 3px solid var(--purple);
            border-radius: 14px;
            background: linear-gradient(145deg, #FFFFFF, #F8F3FC);
            box-shadow: 0 7px 22px rgba(67,39,101,.045);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 13px 28px rgba(67,39,101,.09);
        }

        .stat-card.pending {
            border-top: 3px solid #C9A227;
        }

        .stat-card.approved {
            border-top: 3px solid #41976B;
        }


        .stat-card.rejected {
            border-top: 3px solid #C45B68;
        }

        .stat-label {
            margin-bottom: 14px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .stat-number {
            color: var(--purple);
            font-size: 30px;
            font-weight: 800;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .stat-note {
            margin-top: 9px;
            color: #9589A7;
            font-size: 10px;
            line-height: 1.6;
        }

        /* TABEL PRESTASI */

        .panel {
            padding: 24px;
            border: 1px solid #E7DFF0;
            border-radius: 15px;
            background: rgba(255,255,255,.97);
            box-shadow: 0 7px 24px rgba(67,39,101,.045);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 9px;
        }

        .panel-header h2 {
            margin: 0;
            color: var(--purple-dark);
            font-size: 17px;
        }

        .panel-description {
            margin: 0 0 20px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .panel-header a {
            flex-shrink: 0;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .panel-header a:hover {
            color: var(--purple-dark);
            text-decoration: underline;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .prestasi-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .prestasi-table th,
        .prestasi-table td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: middle;
        }

        .prestasi-table th {
            background: #F8F4FC;
            color: var(--purple-dark);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .prestasi-table th:first-child {
            border-radius: 8px 0 0 8px;
        }

        .prestasi-table th:last-child {
            border-radius: 0 8px 8px 0;
        }

        .prestasi-table td {
            color: #655B73;
            line-height: 1.6;
        }

        .prestasi-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .prestasi-table tbody tr:hover {
            background: #FCFAFE;
        }

        .prestasi-name {
            color: var(--purple-dark) !important;
            font-weight: 700;
            min-width: 180px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #F4EBD2;
            color: #80651D;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-badge.approved {
            background: #E5F4EB;
            color: #27734B;
        }

        .status-badge.rejected {
            background: #FCE9EB;
            color: #B13E4A;
        }

        .status-badge.revision {
            background: #FCEEDC;
            color: #97611A;
        }

        .empty-state {
            padding: 35px 20px;
            border: 1px dashed #D7C8E9;
            border-radius: 12px;
            background: #FCFAFE;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            text-align: center;
        }

        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            border-radius: 16px;
            background: #F0EAF8;
            color: var(--purple);
            font-size: 24px;
        }

        .empty-state strong {
            display: block;
            margin-bottom: 5px;
            color: var(--purple-dark);
            font-size: 14px;
        }

        .empty-state p {
            margin: 0;
        }

        .flash-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.7;
        }

        .flash-success {
            border: 1px solid #BFE4CC;
            background: #EFFAF2;
            color: #276A43;
        }

        .flash-error {
            border: 1px solid #F1C7CD;
            background: #FFF2F3;
            color: #A63746;
        }

        .footer {
            padding: 25px 0 5px;
            color: #9589A7;
            font-size: 11px;
            line-height: 1.8;
            text-align: center;
        }

        /* RESPONSIVE */

        @media (max-width: 1200px) {
            .content {
                padding: 28px 24px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .layout {
                display: block;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 22px 20px;
                overflow: visible;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }

            .gold-line {
                margin-bottom: 24px;
            }

            .menu {
                gap: 6px;
            }

            .menu a {
                padding: 11px 12px;
            }

            .logout {
                margin-top: 20px;
            }

            .content {
                width: 100%;
                margin: 0;
                padding: 24px 16px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .profile {
                max-width: 100%;
            }

            .welcome {
                padding: 23px 20px;
            }

            .welcome h2 {
                font-size: 20px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 11px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-number {
                font-size: 27px;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .panel {
                padding: 18px 14px;
            }

            .panel-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 380px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 22px 12px;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR KHUSUS DOSEN --}}
    <aside class="sidebar">

        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>
                Sistem Informasi Pendataan dan Pengelolaan
                Prestasi Sivitas Akademika
            </small>
        </a>

        <div class="gold-line"></div>

        <div class="menu-title">MENU DOSEN</div>

        {{-- URUTAN MENU: DASHBOARD, DAFTAR, PENGAJUAN, PANDUAN --}}
        <nav class="menu" aria-label="Menu Dosen">

            {{-- DASHBOARD DOSEN --}}
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">⌂</span>
                Dashboard
            </a>

            {{-- DAFTAR PRESTASI DOSEN --}}
            <a
                href="{{ route('dosen.prestasi.index') }}"
                class="{{ request()->routeIs('dosen.prestasi.index') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">▤</span>
                Daftar Prestasi
            </a>

            {{-- PENGAJUAN PRESTASI DOSEN --}}
            <a
                href="{{ route('dosen.prestasi.create') }}"
                class="{{ request()->routeIs('dosen.prestasi.create') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">＋</span>
                Pengajuan Prestasi
            </a>

            {{-- PANDUAN PENGGUNAAN --}}
            <a
                href="{{ route('panduan') }}"
                class="{{ request()->routeIs('panduan') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">ⓘ</span>
                Panduan Penggunaan
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Keluar dari Akun</button>
            </form>
        </div>

    </aside>

    {{-- KONTEN DASHBOARD DOSEN --}}
    <main class="content">

        <header class="header">
            <div>
                <div class="eyebrow">DASHBOARD DOSEN</div>
                <h1>Dashboard Dosen</h1>
                <p>
                    Pantau pengajuan prestasi dan perkembangan pencapaian
                    akademik Anda di SIPRESKA.
                </p>
            </div>

            <div class="profile">
                <span class="profile-avatar" aria-hidden="true">♙</span>
                <span>{{ session('campus_display_name', auth()->user()->sivitas?->nama ?? 'Dosen') }}</span>
            </div>
        </header>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="flash-message flash-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flash-message flash-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- SAMBUTAN --}}
        <section class="welcome">
            <span class="welcome-label">SELAMAT DATANG DI SIPRESKA</span>

            <h2>
                Selamat datang,
                {{ session('campus_display_name', auth()->user()->sivitas?->nama ?? 'Bapak/Ibu Dosen') }}!
            </h2>

            <p>
                Kelola prestasi akademik, ajukan pencapaian terbaru,
                dan pantau proses verifikasi pengajuan Anda melalui SIPRESKA.
            </p>

            {{-- TOMBOL PENGAJUAN DOSEN --}}
            <a
                href="{{ route('dosen.prestasi.create') }}"
                class="btn-primary"
            >
                <span aria-hidden="true">＋</span>
                Ajukan Prestasi
            </a>
        </section>

        {{-- STATISTIK --}}
        <div class="section-heading">
            <div>
                <h2 class="section-title">Ringkasan Prestasi</h2>
                <p class="section-description">
                    Ringkasan pengajuan prestasi yang terkait dengan akun Anda.
                </p>
            </div>
        </div>

        <section class="stats">

            <article class="stat-card">
                <div class="stat-label">Total Prestasi</div>

                <div class="stat-number">
                    {{ number_format($totalPrestasi ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">Seluruh pengajuan tercatat</div>
            </article>

            <article class="stat-card pending">
                <div class="stat-label">Menunggu Verifikasi</div>

                <div class="stat-number">
                    {{ number_format($menungguVerifikasi ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">Pengajuan dalam proses</div>
            </article>

            <article class="stat-card approved">
                <div class="stat-label">Disetujui</div>

                <div class="stat-number">
                    {{ number_format($prestasiDisetujui ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">Pengajuan telah disetujui</div>
            </article>

            <article class="stat-card rejected">
                <div class="stat-label">Ditolak</div>

                <div class="stat-number">
                    {{ number_format($prestasiDitolak ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">Pengajuan ditolak</div>
            </article>

        </section>

        {{-- PENGAJUAN TERBARU --}}
        <section class="panel">

            <div class="panel-header">
                <h2>Pengajuan Prestasi Terbaru</h2>

                {{-- TOMBOL DAFTAR KHUSUS DOSEN --}}
                <a href="{{ route('dosen.prestasi.index') }}">
                    Lihat daftar →
                </a>
            </div>

            <p class="panel-description">
                Lima pengajuan terakhir yang terhubung dengan akun Anda.
            </p>

            @if (isset($prestasiTerbaru) && $prestasiTerbaru->isNotEmpty())

                <div class="table-wrap">
                    <table class="prestasi-table">
                        <thead>
                            <tr>
                                <th>Nama Prestasi</th>
                                <th>Tingkat</th>
                                <th>Tahun</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($prestasiTerbaru as $prestasi)

                                @php
                                    $statusLabel = match ($prestasi->status) {
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'disetujui' => 'Disetujui',
                                        'perlu_perbaikan' => 'Perlu Perbaikan',
                                        'ditolak' => 'Ditolak',
                                        default => 'Status Tidak Diketahui',
                                    };

                                    $statusClass = match ($prestasi->status) {
                                        'disetujui' => 'approved',
                                        'ditolak' => 'rejected',
                                        'perlu_perbaikan' => 'revision',
                                        default => '',
                                    };
                                @endphp

                                <tr>
                                    <td class="prestasi-name">
                                        {{ $prestasi->nama_prestasi }}
                                    </td>

                                    <td>
                                        {{ $prestasi->tingkat?->nama_tingkat ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $prestasi->tahun ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty-state">
                    <div class="empty-icon" aria-hidden="true">🏆</div>

                    <strong>Belum ada pengajuan prestasi</strong>

                    <p>
                        Prestasi yang Anda ajukan akan muncul di bagian ini.
                    </p>

                    {{-- TOMBOL PENGAJUAN KHUSUS DOSEN --}}
                    <a
                        href="{{ route('dosen.prestasi.create') }}"
                        class="btn-primary"
                    >
                        ＋ Ajukan Prestasi
                    </a>
                </div>

            @endif

        </section>

        <footer class="footer">
            © {{ date('Y') }} SIPRESKA — Sistem Informasi Pendataan
            dan Pengelolaan Prestasi Sivitas Akademika
        </footer>

    </main>
</div>
</body>
</html>
