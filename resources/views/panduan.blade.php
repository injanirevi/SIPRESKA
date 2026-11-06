@extends('layouts.app')

@section('title', 'Panduan Penggunaan App - SIPRESKA')

@section('content')
<div class="guide-page">

    <header class="guide-hero">
        <span class="guide-eyebrow">PANDUAN PENGGUNA</span>
        <h1>Panduan Penggunaan <span>SIPRESKA</span></h1>
        <p>
            Pelajari cara menggunakan SIPRESKA untuk melihat prestasi,
            mengajukan pencapaian, dan memantau hasil verifikasi.
        </p>
    </header>

    <section class="guide-section">
        <div class="guide-section-heading">
            <div>
                <span class="guide-kicker">MULAI DI SINI</span>
                <h2>Langkah Penggunaan</h2>
                <p>Ikuti tahapan berikut sesuai kebutuhanmu.</p>
            </div>
        </div>

        <div class="guide-grid">

            <article class="guide-card">
                <span class="guide-number">01</span>
                <div class="guide-icon">⌂</div>
                <h3>Dashboard</h3>
                <p>
                    Buka Dashboard untuk melihat ringkasan prestasi,
                    jumlah pengajuan, dan informasi yang tersedia
                    untuk akunmu.
                </p>
            </article>

            <article class="guide-card">
                <span class="guide-number">02</span>
                <div class="guide-icon">▤</div>
                <h3>Daftar Prestasi</h3>
                <p>
                    Gunakan halaman Daftar Prestasi untuk mencari
                    prestasi mahasiswa berdasarkan nama, tingkat,
                    dan tahun perolehan.
                </p>
            </article>

            <article class="guide-card">
                <span class="guide-number">03</span>
                <div class="guide-icon">＋</div>
                <h3>Pengajuan Prestasi</h3>
                <p>
                    Lengkapi kategori, tingkat, nama prestasi,
                    jenis pencapaian, tahun, dan penyelenggara.
                    Pastikan data sesuai sebelum mengirim.
                </p>
            </article>

            <article class="guide-card">
                <span class="guide-number">04</span>
                <div class="guide-icon">♧</div>
                <h3>Anggota Tim</h3>
                <p>
                    Untuk prestasi tim, pilih jenis Tim dan tambahkan
                    nama serta NIM anggota lain sesuai profil yang
                    terdaftar di sistem.
                </p>
            </article>

            <article class="guide-card">
                <span class="guide-number">05</span>
                <div class="guide-icon">◎</div>
                <h3>Bukti Prestasi</h3>
                <p>
                    Unggah sertifikat dan dokumentasi prestasi sesuai
                    ketentuan formulir. Surat Keputusan (SK) dapat
                    disertakan sebagai dokumen tambahan.
                </p>
            </article>

            <article class="guide-card">
                <span class="guide-number">06</span>
                <div class="guide-icon">✓</div>
                <h3>Verifikasi</h3>
                <p>
                    Setelah pengajuan dikirim, admin akan memeriksanya.
                    Pantau status pengajuan dan tindak lanjuti jika
                    ada permintaan perbaikan.
                </p>
            </article>

        </div>
    </section>

    <section class="guide-status-panel">
        <span class="guide-kicker">STATUS PENGAJUAN</span>
        <h2>Kenali Status Prestasimu</h2>

        <div class="guide-status-list">
            <div class="guide-status-row">
                <span class="guide-status-badge pending">Menunggu Verifikasi</span>
                <p>Pengajuan sudah diterima dan menunggu pemeriksaan admin.</p>
            </div>

            <div class="guide-status-row">
                <span class="guide-status-badge approved">Disetujui</span>
                <p>Pengajuan telah disetujui dan dapat ditampilkan pada daftar publik sesuai aturan sistem.</p>
            </div>

            <div class="guide-status-row">
                <span class="guide-status-badge revision">Perlu Perbaikan</span>
                <p>Periksa kembali informasi atau bukti yang perlu dilengkapi.</p>
            </div>

            <div class="guide-status-row">
                <span class="guide-status-badge rejected">Ditolak</span>
                <p>Pengajuan tidak disetujui oleh admin.</p>
            </div>
        </div>
    </section>

    <section class="guide-note">
        <span class="guide-note-icon">i</span>
        <div>
            <strong>Tips sebelum mengirim pengajuan</strong>
            <p>
                Pastikan data sudah benar, file bukti dapat dibuka,
                serta nama dan NIM anggota tim sesuai dengan profil yang
                terdaftar. Hindari mengirim formulir yang sama berulang kali.
            </p>
        </div>
    </section>

</div>

<style>
    .guide-page {
        --guide-purple: #5B3A8E;
        --guide-dark: #432765;
        --guide-gold: #C9A227;
        --guide-muted: #81788F;
        --guide-border: #E7DFF0;

        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 0 30px;
        color: #30283D;
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
        padding: 32px;
        border: 1px solid #E3D5F2;
        border-left: 4px solid var(--guide-gold);
        border-radius: 15px;
        background: linear-gradient(
            115deg,
            #FFFFFF,
            #F6F0FC 52%,
            #E7D9F5
        );
        box-shadow: 0 10px 30px rgba(91,58,142,.06);
    }

    .guide-eyebrow,
    .guide-kicker {
        display: inline-block;
        color: #8060A8;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.4px;
    }

    .guide-hero h1 {
        margin: 12px 0 10px;
        color: var(--guide-dark);
        font-size: clamp(25px, 3vw, 32px);
        line-height: 1.3;
    }

    .guide-hero h1 span {
        color: var(--guide-purple);
    }

    .guide-hero p {
        max-width: 680px;
        margin: 0;
        color: var(--guide-muted);
        font-size: 13px;
        line-height: 1.8;
    }

    .guide-section {
        margin-bottom: 28px;
    }

    .guide-section-heading {
        margin-bottom: 17px;
    }

    .guide-section-heading h2,
    .guide-status-panel h2 {
        margin: 7px 0;
        color: var(--guide-dark);
        font-size: 19px;
    }

    .guide-section-heading p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .guide-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .guide-card {
        position: relative;
        min-width: 0;
        padding: 21px;
        border: 1px solid var(--guide-border);
        border-top: 3px solid var(--guide-purple);
        border-radius: 13px;
        background: linear-gradient(145deg, #FFFFFF, #F8F3FC);
        box-shadow: 0 7px 22px rgba(67,39,101,.05);
        transition: transform .2s, box-shadow .2s;
    }

    .guide-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 13px 28px rgba(67,39,101,.09);
    }

    .guide-number {
        position: absolute;
        top: 18px;
        right: 18px;
        color: #C9B7DC;
        font-size: 12px;
        font-weight: 800;
    }

    .guide-icon {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        margin-bottom: 16px;
        border: 1px solid #E5D9F3;
        border-radius: 11px;
        background: #F0EAF8;
        color: var(--guide-purple);
        font-size: 21px;
    }

    .guide-card h3 {
        margin: 0 0 9px;
        color: var(--guide-dark);
        font-size: 15px;
    }

    .guide-card p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 12px;
        line-height: 1.85;
    }

    .guide-status-panel {
        margin-bottom: 22px;
        padding: 24px;
        border: 1px solid var(--guide-border);
        border-radius: 14px;
        background: rgba(255,255,255,.97);
        box-shadow: 0 7px 24px rgba(67,39,101,.045);
    }

    .guide-status-list {
        display: grid;
        gap: 0;
        margin-top: 17px;
    }

    .guide-status-row {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 0;
        border-top: 1px solid #F0EAF6;
    }

    .guide-status-row p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .guide-status-badge {
        display: inline-block;
        flex: 0 0 165px;
        padding: 7px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-align: center;
    }

    .guide-status-badge.pending {
        background: #FFF4D3;
        color: #826219;
    }

    .guide-status-badge.approved {
        background: #E3F5E7;
        color: #28653D;
    }

    .guide-status-badge.revision {
        background: #FCEBDD;
        color: #92531D;
    }

    .guide-status-badge.rejected {
        background: #FBE5E8;
        color: #9D3948;
    }

    .guide-note {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 19px 21px;
        border: 1px solid #E3D5F2;
        border-left: 4px solid var(--guide-gold);
        border-radius: 12px;
        background: linear-gradient(120deg, #FAF7FE, #FFFDF8);
    }

    .guide-note-icon {
        display: grid;
        place-items: center;
        flex: 0 0 28px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #EEE5F7;
        color: var(--guide-purple);
        font-family: Georgia, serif;
        font-weight: 800;
    }

    .guide-note strong {
        display: block;
        margin-bottom: 6px;
        color: var(--guide-dark);
        font-size: 12px;
    }

    .guide-note p {
        margin: 0;
        color: var(--guide-muted);
        font-size: 11px;
        line-height: 1.9;
    }

    @media (max-width: 950px) {
        .guide-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .guide-hero {
            padding: 23px;
        }

        .guide-grid {
            grid-template-columns: 1fr;
        }

        .guide-status-panel {
            padding: 18px;
        }

        .guide-status-row {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

        .guide-status-badge {
            flex-basis: auto;
            text-align: left;
        }

        .guide-note {
            padding: 16px;
        }
    }
</style>
@endsection