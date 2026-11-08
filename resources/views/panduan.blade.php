@extends('layouts.app')

@section('title', 'Panduan Penggunaan - SIPRESKA')

@section('content')
<div class="guide-page">

    {{-- HERO HEADER --}}
    <header class="guide-hero">
        <span class="guide-eyebrow">PUSAT PANDUAN SIVITAS AKADEMIKA</span>
        <h1>Panduan Penggunaan <span>SIPRESKA</span></h1>
        <p>
            Panduan lengkap bagi Mahasiswa dan Dosen untuk mendokumentasikan pencapaian, mengajukan data prestasi, melampirkan berkas bukti yang sah, serta memantau status telaah verifikasi.
        </p>
    </header>

    {{-- 6 LANGKAH PENGGUNAAN --}}
    <section class="guide-section">
        <div class="guide-section-heading">
            <span class="guide-kicker">TAHAPAN SISTEM</span>
            <h2>6 Langkah Mudah Pengelolaan Prestasi</h2>
            <p>Ikuti tahapan berikut mulai dari eksplorasi data hingga pengajuan mandiri.</p>
        </div>

        <div class="guide-grid">

            <article class="guide-card">
                <div class="guide-card-top">
                    <div class="guide-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    </div>
                    <span class="guide-number">Tahap 01</span>
                </div>
                <h3>Dashboard Mandiri</h3>
                <p>
                    Akses Dashboard untuk memantau ringkasan seluruh pengajuan yang pernah Anda kirim, jumlah prestasi yang disetujui, dan pengajuan yang masih dalam proses verifikasi.
                </p>
            </article>

            <article class="guide-card">
                <div class="guide-card-top">
                    <div class="guide-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <span class="guide-number">Tahap 02</span>
                </div>
                <h3>Eksplorasi Prestasi</h3>
                <p>
                    Jelajahi portofolio pencapaian kampus di halaman Daftar Prestasi. Cari berdasarkan nama rekan sivitas, tingkat kompetisi, tahun lomba, atau kategori bidang.
                </p>
            </article>

            <article class="guide-card">
                <div class="guide-card-top">
                    <div class="guide-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    </div>
                    <span class="guide-number">Tahap 03</span>
                </div>
                <h3>Formulir Pengajuan</h3>
                <p>
                    Klik tombol <strong>Ajukan Prestasi</strong>. Isi data secara lengkap: nama kompetisi, capaian juara, kategori (Akademik/Non-Akademik), tingkat kompetisi, tahun, dan pihak penyelenggara.
                </p>
            </article>

            <article class="guide-card">
                <div class="guide-card-top">
                    <div class="guide-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <span class="guide-number">Tahap 04</span>
                </div>
                <h3>Keanggotaan Tim</h3>
                <p>
                    Untuk prestasi beregu/kelompok, pilih tipe <em>Tim</em> lalu tambahkan nama dan NIM/NIP anggota tim lainnya. Sistem akan otomatis menghubungkan portofolio ke seluruh anggota.
                </p>
            </article>

            <article class="guide-card">
                <div class="guide-card-top">
                    <div class="guide-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <span class="guide-number">Tahap 05</span>
                </div>
                <h3>Unggah Berkas Bukti</h3>
                <p>
                    Lampirkan file bukti digital resmi berupa scan sertifikat/piagam, dokumentasi foto penyerahan penghargaan, dan Surat Keputusan (SK) tugas jika ada. Pastikan file terbaca dengan jelas.
                </p>
            </article>

            <article class="guide-card">
                <div class="guide-card-top">
                    <div class="guide-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <span class="guide-number">Tahap 06</span>
                </div>
                <h3>Proses Verifikasi</h3>
                <p>
                    Setelah pengajuan terkirim, berkas akan diperiksa oleh Administrator. Pantau perubahan status secara berkala. Prestasi yang disetujui akan langsung diterbitkan ke portofolio kampus.
                </p>
            </article>

        </div>
    </section>

    {{-- STATUS PENGAJUAN --}}
    <section class="guide-status-panel">
        <span class="guide-kicker">INFORMASI STATUS</span>
        <h2>Kenali Status Pengajuan Anda</h2>
        <p style="margin: 0 0 18px; color: var(--guide-muted); font-size: 13px;">Setiap pengajuan yang Anda kirimkan akan melalui tahapan evaluasi dengan status sebagai berikut:</p>

        <div class="guide-status-list">
            <div class="guide-status-row">
                <span class="guide-status-badge pending">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Menunggu Verifikasi
                </span>
                <p>Pengajuan telah berhasil masuk ke database dan sedang berada dalam antrean peninjauan oleh tim administrator kampus.</p>
            </div>

            <div class="guide-status-row">
                <span class="guide-status-badge approved">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Prestasi Disetujui
                </span>
                <p>Berkas telah divalidasi keabsahannya. Prestasi resmi tercatat di SIPRESKA dan tampil pada halaman pencarian publik serta profil sivitas.</p>
            </div>

            <div class="guide-status-row">
                <span class="guide-status-badge rejected">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    Prestasi Ditolak
                </span>
                <p>Pengajuan tidak memenuhi kriteria validasi (misalnya berkas tidak valid atau tidak terbaca). Alasan penolakan dapat dilihat pada riwayat pengajuan.</p>
            </div>
        </div>
    </section>

    {{-- TIPS BOX --}}
    <section class="guide-note">
        <div class="guide-note-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        </div>
        <div>
            <strong>Tips Pengajuan Agar Cepat Disetujui:</strong>
            <p>
                Pastikan nama kompetisi dan nama penyelenggara diketik sesuai teks resmi di sertifikat. Unggah berkas hasil scan yang jelas (tidak buram), serta pastikan nomor identitas (NIM/NIP) seluruh anggota tim sudah benar sebelum menekan tombol kirim pengajuan.
            </p>
        </div>
    </section>

</div>

<style>
    .guide-page {
        --guide-purple: #5B3A8E;
        --guide-dark: #342847;
        --guide-muted: #746886;
        --guide-border: #E8DFF2;
        --guide-gold: #C9A227;
        color: #342847;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .guide-page *,
    .guide-page *::before,
    .guide-page *::after {
        box-sizing: border-box;
    }

    .guide-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        padding: 30px 34px;
        border: 1px solid #E3D5F2;
        border-left: 5px solid var(--guide-gold);
        border-radius: 16px;
        background: linear-gradient(115deg, #FFFFFF, #F6F0FC 52%, #E7D9F5);
        box-shadow: 0 8px 25px rgba(91,58,142,.05);
    }

    .guide-eyebrow,
    .guide-kicker {
        display: inline-block;
        color: #8C6FA8;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .guide-hero h1 {
        margin: 8px 0 10px;
        color: var(--guide-dark);
        font-size: clamp(24px, 3vw, 30px);
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        letter-spacing: -0.4px;
        line-height: 1.3;
    }

    .guide-hero h1 span {
        color: var(--guide-purple);
    }

    .guide-hero p {
        max-width: 720px;
        margin: 0;
        color: var(--guide-muted);
        font-size: 13.5px;
        line-height: 1.75;
    }

    .guide-section {
        margin-bottom: 30px;
    }

    .guide-section-heading {
        margin-bottom: 18px;
    }

    .guide-section-heading h2,
    .guide-status-panel h2 {
        margin: 4px 0 6px;
        color: var(--guide-dark);
        font-size: 20px;
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
    }

    .guide-section-heading p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .guide-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .guide-card {
        background: #FFFFFF;
        border: 1px solid #ECE4F4;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        display: flex;
        flex-direction: column;
    }

    .guide-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(67, 39, 101, 0.08);
        border-color: #DCCFE8;
    }

    .guide-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .guide-number {
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

    .guide-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #F3EDFA;
        border: 1px solid #E4D7F3;
        color: var(--guide-purple);
    }

    .guide-card h3 {
        margin: 0 0 8px;
        color: var(--guide-dark);
        font-size: 16px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .guide-card p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 12.5px;
        line-height: 1.75;
    }

    .guide-status-panel {
        margin-bottom: 26px;
        padding: 26px 30px;
        border: 1px solid #ECE4F4;
        border-radius: 16px;
        background: #FFFFFF;
        box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
    }

    .guide-status-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .guide-status-row {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 14px 0;
        border-top: 1px solid #F3EDF8;
    }

    .guide-status-row p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 12.5px;
        line-height: 1.7;
    }

    .guide-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex: 0 0 170px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .guide-status-badge.pending {
        background: #FFF7E6;
        color: #9A6C05;
        border: 1px solid #FFE6A8;
    }

    .guide-status-badge.approved {
        background: #EDF9F1;
        color: #157A3C;
        border: 1px solid #C4ECCF;
    }

    .guide-status-badge.rejected {
        background: #FDF2F2;
        color: #B91C1C;
        border: 1px solid #FACDCD;
    }

    .guide-note {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 22px 26px;
        border: 1px solid #E3D5F2;
        border-left: 5px solid var(--guide-purple);
        border-radius: 14px;
        background: linear-gradient(120deg, #FAF7FE, #FFFDF8);
    }

    .guide-note-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #EDE4F8;
        color: var(--guide-purple);
        border: 1px solid #D8C5ED;
    }

    .guide-note strong {
        display: block;
        margin-bottom: 6px;
        color: var(--guide-dark);
        font-size: 13.5px;
    }

    .guide-note p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 12.5px;
        line-height: 1.75;
    }

    @media (max-width: 950px) {
        .guide-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .guide-hero {
            padding: 22px;
        }

        .guide-grid {
            grid-template-columns: 1fr;
        }

        .guide-status-panel {
            padding: 20px;
        }

        .guide-status-row {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

        .guide-status-badge {
            flex-basis: auto;
        }

        .guide-note {
            padding: 18px;
        }
    }
</style>
@endsection
