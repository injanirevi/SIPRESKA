@extends('layouts.app')

@section('title', 'Daftar Prestasi - SIPRESKA')

@section('content')

@php
    $user = auth()->user();

    // Halaman user menampilkan data sesuai peran; pengunjung melihat semua sivitas.
    if ($user && in_array($user->role, ['mahasiswa', 'dosen'], true)) {
        $roleSivitas = $user->role;

        $prestasis = $prestasis->filter(function ($prestasi) use ($roleSivitas) {
            return $prestasi->anggota->contains(function ($anggota) use ($roleSivitas) {
                if ($roleSivitas === 'mahasiswa' && $anggota->peran === 'anggota') {
                    return true;
                }

                return data_get($anggota, 'sivitas.user.role') === $roleSivitas;
            });
        })->values();
    }

    $judulPrestasi = match ($user?->role) {
        'dosen' => 'Prestasi Sivitas Dosen',
        'admin', 'super_admin' => 'Semua Data Prestasi Sivitas',
        null => 'Prestasi Sivitas Akademika',
        default => 'Prestasi Sivitas Mahasiswa',
    };

    $labelSivitas = match ($user?->role) {
        'dosen' => 'Dosen',
        'admin', 'super_admin' => 'Anggota Prestasi',
        null => 'Anggota Sivitas Akademika',
        default => 'Mahasiswa',
    };

    $deskripsiHero = match ($user?->role) {
        'dosen' => 'Jelajahi rekam jejak capaian Tridharma dan kompetisi dosen yang telah tervalidasi dan terpublikasi resmi.',
        'admin', 'super_admin' => 'Kelola, cari, dan tinjau seluruh arsip data prestasi sivitas akademika kampus.',
        null => 'Jelajahi rekam jejak prestasi mahasiswa dan dosen yang telah divalidasi dan terpublikasi di SIPRESKA.',
        default => 'Jelajahi rekam jejak prestasi mahasiswa yang telah divalidasi dan temukan pencapaian inspiratif Anda.',
    };

    $deskripsiPrestasi = match ($user?->role) {
        'dosen' => 'Cari prestasi dosen berdasarkan nama kejuaraan, kategori, tingkat, atau tahun perolehan.',
        'admin', 'super_admin' => 'Telusuri seluruh arsip data prestasi yang tercatat dalam sistem secara real-time.',
        null => 'Cari prestasi sivitas berdasarkan nama, kategori, tingkat kompetisi, atau tahun perolehan.',
        default => 'Cari prestasi mahasiswa berdasarkan nama kompetisi, kategori, tingkat, atau tahun perolehan.',
    };

    $pesanKosong = match ($user?->role) {
        'dosen' => 'Belum ada pengajuan prestasi dari akun dosen ini.',
        'admin', 'super_admin' => 'Belum ada data prestasi yang tersedia.',
        null => 'Belum ada data prestasi sivitas akademika yang disetujui.',
        default => 'Belum ada pengajuan prestasi dari akun mahasiswa ini.',
    };

    $tampilkanFilterStatus = $user
        && in_array($user->role, ['admin', 'super_admin', 'mahasiswa', 'dosen'], true);
@endphp

<div class="sp-public-page">

    {{-- HERO / BANNER HEADER MODERN --}}
    <section class="sp-hero">
        <div class="sp-hero-content">
            <span class="sp-eyebrow">PUSAT INFORMASI PRESTASI</span>
            <h1>Daftar <span>Prestasi</span></h1>
            <p>{{ $deskripsiHero }}</p>
        </div>
    </section>

    {{-- JUDUL DAN JUMLAH DATA --}}
    <section class="sp-list-section">

        <div class="sp-section-heading">
            <div>
                <span class="sp-section-kicker">JELAJAHI PENCAPAIAN</span>
                <h2>{{ $judulPrestasi }}</h2>
                <p>{{ $deskripsiPrestasi }}</p>
            </div>

            <div class="sp-count">
                <span id="prestasiCount">{{ $prestasis->count() }}</span>
                <small>data prestasi</small>
            </div>
        </div>

        {{-- PANEL FILTER MODERN --}}
        <div class="sp-filter-panel">

            {{-- BILAH PENCARIAN DENGAN IKON SVG --}}
            <div class="sp-search-field">
                <svg class="sp-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>

                <input
                    type="search"
                    id="searchPrestasi"
                    placeholder="Cari nama prestasi, anggota sivitas, atau penyelenggara..."
                    aria-label="Cari prestasi"
                    autocomplete="off"
                >
            </div>

            {{-- FILTER GRID: KATEGORI, TINGKAT, TAHUN, STATUS --}}
            <div class="sp-filter-grid {{ $tampilkanFilterStatus ? 'with-status' : '' }}">

                <div class="sp-filter-field">
                    <label for="filterKategori">Kategori</label>
                    <select id="filterKategori">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriFilter as $kategori)
                            <option value="{{ $kategori }}">
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sp-filter-field">
                    <label for="filterTingkat">Tingkat Prestasi</label>
                    <select id="filterTingkat">
                        <option value="">Semua Tingkat</option>
                        @foreach ($tingkatFilter as $tingkat)
                            <option value="{{ $tingkat }}">
                                {{ $tingkat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sp-filter-field">
                    <label for="filterTahun">Tahun Perolehan</label>
                    <select id="filterTahun">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunFilter as $tahun)
                            <option value="{{ $tahun }}">
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($tampilkanFilterStatus)
                    <div class="sp-filter-field">
                        <label for="filterStatus">Status Verifikasi</label>
                        <select id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                @endif

                <button
                    type="button"
                    id="resetFilter"
                    class="sp-reset-button"
                >
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                    <span>Reset Filter</span>
                </button>

            </div>
        </div>

        {{-- JUDUL HASIL --}}
        <div class="sp-results-heading">
            <span>Daftar Hasil Pencarian</span>
            <span class="sp-results-line"></span>
        </div>

        {{-- TABEL HASIL DENGAN GAYA MODERN --}}
        <div class="sp-results-table-wrap">
            <table class="sp-results-table" id="prestasiList">
                <thead>
                    <tr>
                        <th>Nama Prestasi & Anggota</th>
                        <th>Tingkat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

            @foreach ($prestasis as $prestasi)

                @php
                    $tingkat = $prestasi->tingkat?->nama_tingkat ?? '-';
                    $kategoriNama = $prestasi->kategori?->nama_kategori ?? '-';
                    $buktiDetail = $prestasi->bukti->map(fn ($bukti) => [
                        'jenis' => $bukti->jenis_bukti,
                        'nama' => $bukti->nama_file ?: $bukti->jenis_bukti,
                        'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($bukti->file_path),
                    ])->values();
                    $catatanVerifikasi = $prestasi->verifikasi
                        ->sortByDesc('tanggal_verifikasi')
                        ->first()?->catatan ?? '';

                    $anggota = $prestasi->anggota
                        ->map(function ($item) {
                            return $item->nama ?? $item->sivitas?->nama;
                        })
                        ->filter()
                        ->values();

                    $searchText = mb_strtolower(implode(' ', [
                        $prestasi->nama_prestasi ?? '',
                        $prestasi->penyelenggara ?? '',
                        $anggota->join(' '),
                        $kategoriNama,
                        $tingkat,
                        (string) $prestasi->tahun,
                        $prestasi->peringkat ?? '',
                    ]));

                    $statusLabel = match ($prestasi->status) {
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'disetujui' => 'Disetujui',
                        'perlu_perbaikan' => 'Perlu Perbaikan',
                        'ditolak' => 'Ditolak',
                        default => 'Dalam Proses',
                    };

                    $statusClass = match ($prestasi->status) {
                        'disetujui' => 'approved',
                        'ditolak' => 'rejected',
                        'perlu_perbaikan' => 'revision',
                        default => 'pending',
                    };
                @endphp

                <tr
                    class="sp-prestasi-row"
                    data-kategori="{{ $kategoriNama }}"
                    data-tingkat="{{ $tingkat }}"
                    data-tahun="{{ $prestasi->tahun }}"
                    data-status="{{ $prestasi->status }}"
                    data-search="{{ $searchText }}"
                >
                    <td>
                        <div class="sp-table-name">{{ $prestasi->nama_prestasi }}</div>
                        <div class="sp-table-subtitle">
                            {{ $anggota->isNotEmpty() ? $anggota->join(', ') : 'Anggota belum diisi' }}
                        </div>
                    </td>
                    <td>
                        <span class="sp-level-pill">{{ $tingkat }}</span>
                    </td>
                    <td>
                        <strong>{{ $prestasi->tahun ?? '-' }}</strong>
                    </td>
                    <td>
                        <span class="sp-table-status {{ $statusClass }}">
                            <span class="sp-status-dot"></span>
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div class="sp-table-actions">
                            <button
                                type="button"
                                class="sp-table-detail-button"
                                onclick='showPrestasiDetail(
                                    @json($prestasi->nama_prestasi),
                                    @json($anggota->join("\n")),
                                    @json($prestasi->jenis_prestasi === "tim" ? "Tim" : "Individu"),
                                    @json($tingkat),
                                    @json($kategoriNama),
                                    @json($prestasi->peringkat ?: "Belum ada peringkat"),
                                    @json((string) $prestasi->tahun),
                                    @json($prestasi->penyelenggara ?: "-"),
                                    @json($prestasi->deskripsi ?: "Belum ada deskripsi."),
                                    @json($statusLabel),
                                    @json($statusClass),
                                    @json($catatanVerifikasi),
                                    @json($buktiDetail)
                                )'
                            >
                                <span>Lihat Rincian</span>
                                <span aria-hidden="true">&rarr;</span>
                            </button>

                            @if (in_array($user?->role, ['mahasiswa', 'dosen'], true) && in_array($prestasi->status, ['ditolak', 'perlu_perbaikan'], true))
                                <a
                                    href="{{ route('prestasi.edit', $prestasi) }}"
                                    class="sp-table-edit-link"
                                    title="Ajukan Kembali"
                                    aria-label="Ajukan Kembali"
                                >
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    <span>Ajukan Kembali</span>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>

            @endforeach

                </tbody>
            </table>
        </div>

        {{-- PESAN HASIL KOSONG --}}
        <div
            id="prestasiEmpty"
            class="sp-empty-state"
            style="display: none;"
        >
            <div class="sp-empty-icon" aria-hidden="true">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple);"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>

            <h3 id="prestasiEmptyTitle">{{ $pesanKosong }}</h3>

            <p id="prestasiEmptyDescription">
                Coba ubah kata kunci atau kombinasi filter pencarian Anda.
            </p>
        </div>

    </section>
</div>

{{-- MODAL DETAIL PRESTASI MODERN --}}
<div
    class="sp-detail-modal"
    id="prestasiModal"
    aria-hidden="true"
>
    <div
        class="sp-modal-backdrop"
        onclick="closePrestasiDetail()"
    ></div>

    <div
        class="sp-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalJudul"
    >
        <button
            type="button"
            class="sp-modal-close"
            onclick="closePrestasiDetail()"
            aria-label="Tutup detail"
        >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="sp-modal-heading">
            <span class="sp-section-kicker">INFORMASI LENGKAP PENCAPAIAN</span>
            <span id="modalStatus" class="sp-modal-status"></span>
        </div>
        <h2 id="modalJudul"></h2>

        <p class="sp-modal-intro" id="modalIntro">
            Rincian data capaian dan arsip berkas bukti pendukung prestasi.
        </p>

        <div class="sp-modal-details">
            <div class="sp-modal-detail-item">
                <span>Peserta / Sivitas</span>
                <strong id="modalNama"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Jenis Prestasi</span>
                <strong id="modalJenisPrestasi"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Tingkat Kompetisi</span>
                <strong id="modalTingkat"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Kategori Bidang</span>
                <strong id="modalKategori"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Peringkat / Capaian</span>
                <strong id="modalPeringkat"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Tahun Perolehan</span>
                <strong id="modalTahun"></strong>
            </div>

            <div class="sp-modal-detail-item full-width">
                <span>Penyelenggara Kegiatan</span>
                <strong id="modalPenyelenggara"></strong>
            </div>

            <div class="sp-modal-detail-item full-width">
                <span>Deskripsi Kegiatan & Capaian</span>
                <strong id="modalDeskripsi"></strong>
            </div>

            <section class="sp-modal-evidence full-width">
                <h3>Dokumen & Berkas Bukti</h3>
                <div id="modalBukti" class="sp-modal-evidence-list"></div>
            </section>

            <section id="modalCatatanWrap" class="sp-modal-note full-width" hidden>
                <h3>Catatan Verifikator</h3>
                <p id="modalCatatan"></p>
            </section>
        </div>
    </div>
</div>

<style>
    /* VARIABEL DAN TEMA DASAR */
    .sp-public-page {
        --sp-purple: #5B3A8E;
        --sp-purple-dark: #432765;
        --sp-purple-light: #F4EFFB;
        --sp-lavender: #EEE5F7;
        --sp-gold: #C9A227;
        --sp-text: #342847;
        --sp-muted: #80758F;
        --sp-border: #E7DFF0;

        width: 100%;
        min-width: 0;
        color: var(--sp-text);
        font-family: inherit;
    }

    .sp-public-page *,
    .sp-detail-modal * {
        box-sizing: border-box;
    }

    /* HERO BANNER MODERN DENGAN AKSEN EMAS */
    .sp-hero {
        position: relative;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(246, 239, 253, 0.95) 100%);
        border: 1px solid #E4D8F0;
        border-left: 5px solid var(--sp-gold);
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 26px;
        box-shadow: 0 6px 20px rgba(67, 39, 101, 0.04);
    }

    .sp-hero-content {
        max-width: 720px;
    }

    .sp-eyebrow,
    .sp-section-kicker {
        display: inline-block;
        color: var(--sp-purple);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .sp-eyebrow {
        padding: 4px 10px;
        border: 1px solid #DFD2ED;
        border-radius: 20px;
        background: #FAF7FD;
        margin-bottom: 8px;
    }

    .sp-hero h1 {
        margin: 8px 0 10px;
        font-family: 'Poppins', sans-serif;
        color: #2D1A47;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .sp-hero h1 span {
        color: var(--sp-purple);
    }

    .sp-hero p {
        margin: 0;
        color: #6C5E7F;
        font-size: 13.5px;
        line-height: 1.6;
    }

    .sp-list-section {
        margin-top: 24px;
    }

    /* JUDUL DAN HITUNGAN */
    .sp-section-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .sp-section-heading h2 {
        margin: 4px 0 6px;
        font-family: 'Poppins', sans-serif;
        color: #26193D;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -0.3px;
    }

    .sp-section-heading p {
        margin: 0;
        color: #716484;
        font-size: 13px;
        line-height: 1.6;
    }

    .sp-count {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        padding: 8px 16px;
        border: 1px solid var(--sp-border);
        border-radius: 12px;
        background: #FFFFFF;
        box-shadow: 0 2px 8px rgba(67, 39, 101, 0.03);
    }

    .sp-count span {
        font-family: 'Poppins', sans-serif;
        color: var(--sp-purple);
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
    }

    .sp-count small {
        color: var(--sp-muted);
        font-size: 11.5px;
        font-weight: 600;
    }

    /* PANEL FILTER */
    .sp-filter-panel {
        padding: 22px 24px;
        border: 1px solid var(--sp-border);
        border-radius: 16px;
        background: #FFFFFF;
        box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
        margin-bottom: 24px;
    }

    .sp-search-field {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 48px;
        padding: 0 16px;
        border: 1px solid #E2D7ED;
        border-radius: 12px;
        background: #FCFAFF;
        transition: all .2s ease;
    }

    .sp-search-field:focus-within {
        border-color: var(--sp-purple);
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(91, 58, 142, 0.12);
    }

    .sp-search-icon {
        color: var(--sp-purple);
        flex-shrink: 0;
    }

    .sp-search-field input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: none;
        background: transparent;
        color: var(--sp-text);
        font-size: 13px;
        font-family: inherit;
    }

    .sp-search-field input::placeholder {
        color: #A396B2;
    }

    .sp-filter-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr)) auto;
        gap: 14px;
        align-items: end;
        margin-top: 16px;
    }

    .sp-filter-grid.with-status {
        grid-template-columns: repeat(4, minmax(0, 1fr)) auto;
    }

    @media (max-width: 900px) {
        .sp-filter-grid,
        .sp-filter-grid.with-status {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 550px) {
        .sp-filter-grid,
        .sp-filter-grid.with-status {
            grid-template-columns: 1fr;
        }
    }

    .sp-filter-field {
        min-width: 0;
    }

    .sp-filter-field label {
        display: block;
        margin-bottom: 6px;
        color: #55486B;
        font-size: 11.5px;
        font-weight: 700;
    }

    .sp-filter-field select {
        width: 100%;
        min-width: 0;
        min-height: 42px;
        padding: 0 12px;
        border: 1px solid #E5DCED;
        border-radius: 10px;
        outline: none;
        background: #FFFFFF;
        color: var(--sp-text);
        font-size: 12.5px;
        font-family: inherit;
        transition: all .2s;
    }

    .sp-filter-field select:focus {
        border-color: var(--sp-purple);
        box-shadow: 0 0 0 3px rgba(91, 58, 142, 0.1);
    }

    .sp-reset-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 16px;
        border: 1px solid #DFD2ED;
        border-radius: 10px;
        background: #FAF7FD;
        color: var(--sp-purple);
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        font-family: inherit;
        white-space: nowrap;
        transition: all .2s ease;
    }

    .sp-reset-button:hover {
        background: #EDE4F8;
        border-color: var(--sp-purple);
        color: var(--sp-purple-dark);
        transform: translateY(-1px);
    }

    /* HASIL PENCARIAN */
    .sp-results-heading {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 24px 0 16px;
        color: #4C3C63;
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sp-results-line {
        flex: 1;
        height: 1px;
        background: var(--sp-border);
    }

    .sp-results-table-wrap {
        overflow-x: auto;
        border: 1px solid #EFE9F6;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
    }

    .sp-results-table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
    }

    .sp-results-table th {
        background: #F9F7FC;
        color: #55486B;
        font-weight: 700;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 13px 18px;
        border-bottom: 1px solid #EAE1F3;
        white-space: nowrap;
    }

    .sp-results-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #F1EBF7;
        color: #382C4E;
        vertical-align: middle;
    }

    .sp-results-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .sp-results-table tbody tr:hover {
        background: #FAF8FD;
    }

    .sp-table-name {
        font-weight: 700;
        color: #23163A;
        font-size: 13.5px;
        margin-bottom: 2px;
    }

    .sp-table-subtitle {
        color: #7A6F8C;
        font-size: 11.5px;
        line-height: 1.5;
    }

    .sp-level-pill {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        background: #F3EDFA;
        color: #523483;
        border: 1px solid #E5D9F3;
    }

    .sp-table-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .sp-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .sp-table-status.pending {
        background: #FEF3C7;
        color: #92400E;
        border: 1px solid #FDE68A;
    }
    .sp-table-status.pending .sp-status-dot {
        background: #D97706;
    }

    .sp-table-status.approved {
        background: #D1FAE5;
        color: #065F46;
        border: 1px solid #A7F3D0;
    }
    .sp-table-status.approved .sp-status-dot {
        background: #059669;
    }

    .sp-table-status.rejected {
        background: #FEE2E2;
        color: #991B1B;
        border: 1px solid #FECACA;
    }
    .sp-table-status.rejected .sp-status-dot {
        background: #DC2626;
    }

    .sp-table-status.revision {
        background: #FEF9C3;
        color: #854D0E;
        border: 1px solid #FEF08A;
    }
    .sp-table-status.revision .sp-status-dot {
        background: #CA8A04;
    }

    .sp-table-actions {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: flex-end;
    }

    .sp-table-detail-button {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        font-family: inherit;
        background: #FAF7FD;
        border: 1px solid #DFD2ED;
        color: var(--sp-purple);
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .sp-table-detail-button:hover {
        background: #EDE4F8;
        border-color: var(--sp-purple);
        color: var(--sp-purple-dark);
        transform: translateY(-1px);
    }

    .sp-table-edit-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        background: #FFF7ED;
        border: 1px solid #FED7AA;
        color: #C2410C;
        transition: all 0.15s ease;
    }

    .sp-table-edit-link:hover {
        background: #FFEDD5;
        border-color: #FB923C;
        transform: translateY(-1px);
    }

    /* EMPTY STATE */
    .sp-empty-state {
        padding: 48px 20px;
        text-align: center;
        background: #FFFFFF;
        border: 1px solid var(--sp-border);
        border-radius: 16px;
        margin-top: 16px;
    }

    .sp-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #F4EFFB;
        color: var(--sp-purple);
        margin-bottom: 14px;
    }

    .sp-empty-state h3 {
        margin: 0 0 6px;
        font-family: 'Poppins', sans-serif;
        color: #2D1A47;
        font-size: 16px;
        font-weight: 700;
    }

    .sp-empty-state p {
        margin: 0;
        color: var(--sp-muted);
        font-size: 13px;
    }

    /* MODAL DETAIL PRESTASI */
    .sp-detail-modal {
        position: fixed;
        inset: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .sp-detail-modal.is-open {
        opacity: 1;
        visibility: visible;
    }

    .sp-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(36, 22, 56, 0.45);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }

    .sp-modal-box {
        position: relative;
        width: 100%;
        max-width: 680px;
        max-height: 88vh;
        overflow-y: auto;
        background: #FFFFFF;
        border-radius: 18px;
        border: 1px solid #ECE4F4;
        box-shadow: 0 20px 45px rgba(45, 26, 71, 0.2);
        padding: 28px 32px;
        z-index: 10;
        transform: translateY(12px) scale(0.98);
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .sp-detail-modal.is-open .sp-modal-box {
        transform: translateY(0) scale(1);
    }

    .sp-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid #EAE1F3;
        background: #FAF7FD;
        color: #655874;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }

    .sp-modal-close:hover {
        background: #F2EBF9;
        color: var(--sp-purple);
        transform: rotate(90deg);
    }

    .sp-modal-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 6px;
        padding-right: 40px;
    }

    .sp-modal-box h2 {
        margin: 6px 0 8px;
        font-family: 'Poppins', sans-serif;
        color: #241638;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.3;
    }

    .sp-modal-intro {
        margin: 0 0 22px;
        color: #7A6F8C;
        font-size: 13px;
        line-height: 1.5;
        border-bottom: 1px solid #F1EBF7;
        padding-bottom: 16px;
    }

    .sp-modal-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }
    .sp-modal-status.pending { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
    .sp-modal-status.approved { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
    .sp-modal-status.rejected { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
    .sp-modal-status.revision { background: #FEF9C3; color: #854D0E; border: 1px solid #FEF08A; }

    .sp-modal-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px 18px;
    }

    .sp-modal-detail-item {
        background: #FBF9FD;
        border: 1px solid #EFE9F6;
        border-radius: 10px;
        padding: 10px 14px;
    }

    .sp-modal-detail-item.full-width {
        grid-column: 1 / -1;
    }

    .sp-modal-detail-item span {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #7D7090;
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sp-modal-detail-item strong {
        display: block;
        font-size: 13px;
        color: #26193D;
        line-height: 1.5;
        white-space: pre-line;
    }

    .sp-modal-evidence {
        grid-column: 1 / -1;
        margin-top: 10px;
    }

    .sp-modal-evidence h3,
    .sp-modal-note h3 {
        margin: 0 0 10px;
        font-size: 12.5px;
        font-weight: 700;
        color: #3C2E52;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sp-modal-evidence-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
    }

    .sp-modal-evidence-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #E6DCF0;
        background: #FAF7FD;
        text-decoration: none;
        color: var(--sp-purple);
        font-size: 12px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .sp-modal-evidence-card:hover {
        background: #EDE2F8;
        border-color: var(--sp-purple);
        transform: translateY(-1px);
    }

    .sp-modal-evidence-card img {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        object-fit: cover;
    }

    .sp-modal-file-type {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: #FEE2E2;
        color: #B91C1C;
        font-size: 10px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .sp-modal-file-info {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sp-modal-file-info strong {
        font-size: 12px;
        color: #241638;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sp-modal-file-info small {
        color: var(--sp-purple);
        font-size: 11px;
    }

    .sp-modal-empty {
        margin: 0;
        color: var(--sp-muted);
        font-size: 12px;
        font-style: italic;
    }

    .sp-modal-note {
        grid-column: 1 / -1;
        margin-top: 10px;
        padding: 14px 16px;
        border-radius: 10px;
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-left: 4px solid #D97706;
    }

    .sp-modal-note h3 {
        color: #92400E;
        margin-bottom: 4px;
    }

    .sp-modal-note p {
        margin: 0;
        color: #78350F;
        font-size: 12.5px;
        line-height: 1.5;
    }
</style>

<script>
    (() => {
        const searchInput = document.getElementById('searchPrestasi');
        const filterKategori = document.getElementById('filterKategori');
        const filterTingkat = document.getElementById('filterTingkat');
        const filterTahun = document.getElementById('filterTahun');
        const filterStatus = document.getElementById('filterStatus');
        const resetButton = document.getElementById('resetFilter');
        const countBadge = document.getElementById('prestasiCount');
        const emptyState = document.getElementById('prestasiEmpty');
        const tableWrap = document.querySelector('.sp-results-table-wrap');
        const rows = Array.from(document.querySelectorAll('.sp-prestasi-row'));

        function applyFilters() {
            const query = (searchInput.value || '').trim().toLowerCase();
            const kategori = filterKategori.value;
            const tingkat = filterTingkat.value;
            const tahun = filterTahun.value;
            const status = filterStatus ? filterStatus.value : '';

            let visibleCount = 0;

            rows.forEach((row) => {
                const rowKategori = row.dataset.kategori;
                const rowTingkat = row.dataset.tingkat;
                const rowTahun = row.dataset.tahun;
                const rowStatus = row.dataset.status;
                const rowSearch = row.dataset.search || '';

                const matchesQuery = !query || rowSearch.includes(query);
                const matchesKategori = !kategori || rowKategori === kategori;
                const matchesTingkat = !tingkat || rowTingkat === tingkat;
                const matchesTahun = !tahun || rowTahun === tahun;
                const matchesStatus = !status || rowStatus === status;

                const isVisible =
                    matchesQuery &&
                    matchesKategori &&
                    matchesTingkat &&
                    matchesTahun &&
                    matchesStatus;

                row.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    visibleCount += 1;
                }
            });

            if (countBadge) {
                countBadge.textContent = visibleCount;
            }

            if (emptyState && tableWrap) {
                if (visibleCount === 0) {
                    tableWrap.style.display = 'none';
                    emptyState.style.display = 'block';
                } else {
                    tableWrap.style.display = '';
                    emptyState.style.display = 'none';
                }
            }
        }

        [searchInput, filterKategori, filterTingkat, filterTahun].forEach((el) => {
            if (!el) return;
            el.addEventListener('input', applyFilters);
            el.addEventListener('change', applyFilters);
        });

        if (filterStatus) {
            filterStatus.addEventListener('change', applyFilters);
        }

        if (resetButton) {
            resetButton.addEventListener('click', () => {
                searchInput.value = '';
                filterKategori.value = '';
                filterTingkat.value = '';
                filterTahun.value = '';

                if (filterStatus) {
                    filterStatus.value = '';
                }

                applyFilters();
            });
        }

        applyFilters();
    })();

    function showPrestasiDetail(
        nama,
        anggota,
        jenis,
        tingkat,
        kategori,
        peringkat,
        tahun,
        penyelenggara,
        deskripsi,
        statusLabel,
        statusClass,
        catatan,
        bukti
    ) {
        document.getElementById('modalJudul').textContent = nama || '-';
        document.getElementById('modalNama').textContent = anggota || '-';
        document.getElementById('modalJenisPrestasi').textContent = jenis || '-';
        document.getElementById('modalTingkat').textContent = tingkat || '-';
        document.getElementById('modalKategori').textContent = kategori || '-';
        document.getElementById('modalPeringkat').textContent = peringkat || '-';
        document.getElementById('modalTahun').textContent = tahun || '-';

        document.getElementById('modalPenyelenggara').textContent = penyelenggara || '-';
        document.getElementById('modalDeskripsi').textContent = deskripsi || '-';

        const statusBadge = document.getElementById('modalStatus');
        statusBadge.textContent = statusLabel || '-';
        statusBadge.className = `sp-modal-status ${statusClass || 'pending'}`;

        const catatanWrap = document.getElementById('modalCatatanWrap');
        const catatanText = document.getElementById('modalCatatan');
        catatanWrap.hidden = !catatan;
        catatanText.textContent = catatan || '';

        const buktiContainer = document.getElementById('modalBukti');
        buktiContainer.replaceChildren();
        if (!Array.isArray(bukti) || bukti.length === 0) {
            const emptyEvidence = document.createElement('p');
            emptyEvidence.className = 'sp-modal-empty';
            emptyEvidence.textContent = 'Belum ada dokumen bukti yang diunggah.';
            buktiContainer.appendChild(emptyEvidence);
        } else {
            bukti.forEach((item) => {
                const link = document.createElement('a');
                link.className = 'sp-modal-evidence-card';
                link.href = item.url;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';

                if (/\.(jpe?g|png)$/i.test(item.nama || item.url)) {
                    const image = document.createElement('img');
                    image.src = item.url;
                    image.alt = item.jenis || item.nama || 'Bukti prestasi';
                    image.loading = 'lazy';
                    link.appendChild(image);
                } else {
                    const fileType = document.createElement('span');
                    fileType.className = 'sp-modal-file-type';
                    fileType.textContent = 'PDF';
                    link.appendChild(fileType);
                }

                const fileInfo = document.createElement('span');
                fileInfo.className = 'sp-modal-file-info';
                const fileName = document.createElement('strong');
                fileName.textContent = item.jenis || 'Dokumen bukti';
                const fileAction = document.createElement('small');
                fileAction.textContent = 'Buka dokumen';
                fileInfo.append(fileName, fileAction);
                link.appendChild(fileInfo);
                buktiContainer.appendChild(link);
            });
        }

        const modal = document.getElementById('prestasiModal');
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closePrestasiDetail() {
        const modal = document.getElementById('prestasiModal');
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closePrestasiDetail();
        }
    });
</script>

@endsection
