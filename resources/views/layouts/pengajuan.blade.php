<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Pengajuan Prestasi - SIPRESKA')</title>

    <link rel="stylesheet" href="{{ asset('css/sipreska.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengajuan.css') }}">
</head>
<body class="pengajuan-page">

<div class="pengajuan-app">

    <aside class="pengajuan-sidebar">

        <a href="{{ route('home') }}" class="pengajuan-brand">
            <span class="brand-symbol">S</span>
            <span>
                <strong>SIPRESKA</strong>
                <small>Sistem Informasi Prestasi</small>
            </span>
        </a>

        <div class="sidebar-caption">MENU UTAMA</div>

        <nav class="sidebar-menu">
            <a href="{{ route('home') }}" class="side-link">
                <span class="side-icon">⌂</span>
                <span>Beranda</span>
            </a>

            <a href="{{ route('prestasi') }}" class="side-link">
                <span class="side-icon">▤</span>
                <span>Daftar Prestasi</span>
            </a>

            <a href="{{ route('prestasi.create') }}"
               class="side-link active">
                <span class="side-icon">＋</span>
                <span>Pengajuan Prestasi</span>
            </a>

            <a href="{{ route('tentang') }}" class="side-link">
                <span class="side-icon">ⓘ</span>
                <span>Tentang SIPRESKA</span>
            </a>
        </nav>

        <div class="sidebar-help">
            <span class="help-icon">i</span>
            <strong>Informasi Pengajuan</strong>
            <p>
                Lengkapi data prestasi sesuai pencapaian
                yang sebenarnya. Pastikan informasi benar
                sebelum dikirim.
            </p>
        </div>

        <div class="sidebar-bottom">
            <span class="sidebar-status-dot"></span>
            Prototype SIPRESKA
        </div>

    </aside>

    <div class="pengajuan-main">

        <header class="pengajuan-topbar">
            <div>
                <div class="topbar-breadcrumb">
                    SIPRESKA <span>/</span> Pengajuan
                </div>
                <h2>Form Pengajuan Prestasi Sivitas</h2>
            </div>

            <a href="{{ route('prestasi') }}" class="topbar-back">
                ← Daftar Prestasi
            </a>
        </header>

        <main class="pengajuan-content">
            @yield('content')
        </main>

        <footer class="pengajuan-footer">
            © {{ date('Y') }} SIPRESKA
            <span>Sistem Informasi Pendataan dan Pengelolaan Prestasi</span>
        </footer>

    </div>

</div>

</body>
</html>