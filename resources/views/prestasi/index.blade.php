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
        'dosen' => 'Prestasi Dosen',
        'admin' => 'Semua Prestasi',
        null => 'Prestasi Sivitas Akademika',
        default => 'Prestasi Mahasiswa',
    };

    $labelSivitas = match ($user?->role) {
        'dosen' => 'Dosen',
        'admin' => 'Anggota Prestasi',
        null => 'Anggota Sivitas Akademika',
        default => 'Mahasiswa',
    };

    $deskripsiHero = match ($user?->role) {
        'dosen' => 'Jelajahi prestasi dosen yang telah disetujui dan temukan pencapaian inspiratif.',
        'admin' => 'Kelola dan tinjau seluruh data prestasi sivitas akademika.',
        null => 'Jelajahi prestasi mahasiswa dan dosen yang telah disetujui.',
        default => 'Jelajahi prestasi mahasiswa yang telah disetujui dan temukan pencapaian inspiratif.',
    };

    $deskripsiPrestasi = match ($user?->role) {
        'dosen' => 'Cari prestasi dosen berdasarkan nama, kategori, tingkat, atau tahun perolehan.',
        'admin' => 'Lihat dan telusuri seluruh data prestasi yang tercatat.',
        null => 'Cari prestasi mahasiswa dan dosen berdasarkan nama, kategori, tingkat, atau tahun perolehan.',
        default => 'Cari prestasi mahasiswa berdasarkan nama, kategori, tingkat, atau tahun perolehan.',
    };

    $pesanKosong = match ($user?->role) {
        'dosen' => 'Belum ada pengajuan prestasi dari akun dosen ini.',
        'admin' => 'Belum ada data prestasi yang tersedia.',
        null => 'Belum ada data prestasi sivitas akademika yang disetujui.',
        default => 'Belum ada pengajuan prestasi dari akun mahasiswa ini.',
    };

    $tampilkanFilterStatus = $user
        && in_array($user->role, ['admin', 'mahasiswa', 'dosen'], true);
@endphp

<div class="sp-public-page">

    {{-- HERO --}}
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

        {{-- PANEL FILTER --}}
        <div class="sp-filter-panel">

            {{-- PENCARIAN --}}
            <div class="sp-search-field">
                <span class="sp-search-icon" aria-hidden="true">⌕</span>

                <input
                    type="search"
                    id="searchPrestasi"
                    placeholder="Cari nama prestasi, anggota, atau penyelenggara..."
                    aria-label="Cari prestasi"
                >
            </div>

            {{-- FILTER KATEGORI, TINGKAT, TAHUN, STATUS --}}
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
                        <label for="filterStatus">Status</label>

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
                    Reset Filter
                </button>

            </div>
        </div>

        {{-- JUDUL HASIL --}}
        <div class="sp-results-heading">
            <span>Hasil Pencarian</span>
            <span class="sp-results-line"></span>
        </div>

        {{-- DAFTAR HASIL DALAM TABEL --}}
        <div class="sp-results-table-wrap">
            <table class="sp-results-table" id="prestasiList">
                <thead>
                    <tr>
                        <th>Nama Prestasi</th>
                        <th>Tingkat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th>Detail</th>
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
                        default => 'Status Tidak Diketahui',
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
                    <td>{{ $tingkat }}</td>
                    <td>{{ $prestasi->tahun ?? '-' }}</td>
                    <td>
                        <span class="sp-table-status {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td>
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
                        >Lihat Detail</button>
                        @if (in_array($user?->role, ['mahasiswa', 'dosen'], true) && in_array($prestasi->status, ['ditolak', 'perlu_perbaikan'], true))
                            <a
                                href="{{ route('prestasi.edit', $prestasi) }}"
                                class="sp-table-edit-link"
                                title="Ajukan Kembali"
                                aria-label="Ajukan Kembali"
                            >
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="m14.5 6.5 3 3M4 20l4.2-.9L19 8.3a2.1 2.1 0 0 0-3-3L5.2 16.1 4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
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
            <div class="sp-empty-icon" aria-hidden="true">✦</div>

            <h3 id="prestasiEmptyTitle">{{ $pesanKosong }}</h3>

            <p id="prestasiEmptyDescription">
                Coba ubah kata kunci atau filter pencarianmu.
            </p>
        </div>

    </section>
</div>

{{-- MODAL DETAIL PRESTASI --}}
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
            &times;
        </button>

        <div class="sp-modal-heading">
            <span class="sp-section-kicker">INFORMASI PENCAPAIAN</span>
            <span id="modalStatus" class="sp-modal-status"></span>
        </div>
        <h2 id="modalJudul"></h2>

        <p class="sp-modal-intro" id="modalIntro">
            Rincian prestasi dan dokumen pendukung.
        </p>

        <div class="sp-modal-details">
            <div class="sp-modal-detail-item">
                <span>Peserta</span>
                <strong id="modalNama"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Jenis Prestasi</span>
                <strong id="modalJenisPrestasi"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Tingkat</span>
                <strong id="modalTingkat"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Kategori</span>
                <strong id="modalKategori"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Peringkat</span>
                <strong id="modalPeringkat"></strong>
            </div>



            <div class="sp-modal-detail-item">
                <span>Tahun</span>
                <strong id="modalTahun"></strong>
            </div>

            <div class="sp-modal-detail-item">
                <span>Penyelenggara</span>
                <strong id="modalPenyelenggara"></strong>
            </div>

            <div class="sp-modal-detail-item full-width">
                <span>Deskripsi</span>
                <strong id="modalDeskripsi"></strong>
            </div>

            <section class="sp-modal-evidence full-width">
                <h3>Bukti Prestasi</h3>
                <div id="modalBukti" class="sp-modal-evidence-list"></div>
            </section>

            <section id="modalCatatanWrap" class="sp-modal-note full-width" hidden>
                <h3>Catatan Verifikasi</h3>
                <p id="modalCatatan"></p>
            </section>
        </div>
    </div>
</div>

<style>
    /* WARNA DAN DASAR HALAMAN */
    .sp-public-page {
        --sp-purple: #65458e;
        --sp-purple-dark: #432765;
        --sp-purple-light: #f5effb;
        --sp-lavender: #eee5f7;
        --sp-gold: #c9a227;
        --sp-text: #342747;
        --sp-muted: #81758f;
        --sp-border: #e8e0ef;

        width: 100%;
        min-width: 0;
        padding: 30px 0 55px;
        color: var(--sp-text);
        font-family: inherit;
    }

    .sp-public-page *,
    .sp-detail-modal * {
        box-sizing: border-box;
    }

    /* HERO TANPA DEKORASI BULAT, BINTANG, DAN GARIS */
    .sp-hero {
        display: flex;
        align-items: center;
        min-height: 250px;
        padding: 38px clamp(22px, 4vw, 48px);
        border: 1px solid #e9dff4;
        border-radius: 22px;
        background:
            radial-gradient(circle at 93% 15%, rgba(201,162,39,.16), transparent 25%),
            linear-gradient(120deg, #f8f4fc, #e8ddf4);
    }

    .sp-hero-content {
        max-width: 700px;
    }

    .sp-eyebrow,
    .sp-section-kicker {
        display: inline-block;
        color: var(--sp-purple);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.8px;
    }

    .sp-eyebrow {
        padding: 9px 13px;
        border: 1px solid #ded0ed;
        border-radius: 30px;
        background: rgba(255,255,255,.65);
    }

    .sp-hero h1 {
        margin: 18px 0 12px;
        color: var(--sp-purple-dark);
        font-size: clamp(31px, 4vw, 45px);
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -1px;
    }

    .sp-hero h1 span {
        color: var(--sp-purple);
    }

    .sp-hero p {
        max-width: 590px;
        margin: 0;
        color: #776b87;
        font-size: 13px;
        line-height: 1.9;
    }

    .sp-list-section {
        margin-top: 32px;
    }

    /* JUDUL DAN HITUNGAN */
    .sp-section-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 22px;
    }

    .sp-section-heading h2 {
        margin: 8px 0;
        color: var(--sp-purple-dark);
        font-size: clamp(21px, 2.5vw, 27px);
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .sp-section-heading p {
        max-width: 700px;
        margin: 0;
        color: var(--sp-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .sp-count {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-shrink: 0;
        padding: 11px 14px;
        border: 1px solid var(--sp-border);
        border-radius: 12px;
        background: #fff;
    }

    .sp-count span {
        color: var(--sp-purple);
        font-size: 22px;
        font-weight: 800;
    }

    .sp-count small {
        color: var(--sp-muted);
        font-size: 10px;
    }

    /* PANEL FILTER */
    .sp-filter-panel {
        padding: 21px;
        border: 1px solid var(--sp-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(67,39,101,.045);
    }

    .sp-search-field {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 47px;
        padding: 0 13px;
        border: 1px solid #e4d9ef;
        border-radius: 10px;
        background: #fcfaff;
        transition: border-color .2s, box-shadow .2s;
    }

    .sp-search-field:focus-within {
        border-color: var(--sp-purple);
        box-shadow: 0 0 0 3px rgba(101,69,142,.08);
    }

    .sp-search-icon {
        color: var(--sp-purple);
        font-size: 25px;
        line-height: 1;
    }

    .sp-search-field input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: none;
        background: transparent;
        color: var(--sp-text);
        font-size: 12px;
    }

    .sp-search-field input::placeholder {
        color: #a398b1;
    }

    .sp-filter-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr)) auto;
        gap: 13px;
        align-items: end;
        margin-top: 16px;
    }

    .sp-filter-grid.with-status {
        grid-template-columns: repeat(4, minmax(0, 1fr)) auto;
    }

    .sp-filter-field {
        min-width: 0;
    }

    .sp-filter-field label {
        display: block;
        margin-bottom: 8px;
        color: #645472;
        font-size: 11px;
        font-weight: 800;
    }

    .sp-filter-field select {
        width: 100%;
        min-width: 0;
        min-height: 42px;
        padding: 0 10px;
        border: 1px solid #e7dfed;
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: var(--sp-text);
        font-size: 11px;
    }

    .sp-filter-field select:focus {
        border-color: var(--sp-purple);
        box-shadow: 0 0 0 3px rgba(101,69,142,.07);
    }

    .sp-reset-button {
        min-height: 42px;
        padding: 0 15px;
        border: 1px solid #d9c8e9;
        border-radius: 9px;
        background: var(--sp-purple-light);
        color: var(--sp-purple);
        cursor: pointer;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
        transition: .2s;
    }

    .sp-reset-button:hover {
        border-color: var(--sp-purple);
        background: var(--sp-purple);
        color: #fff;
    }

    /* HASIL PENCARIAN */
    .sp-results-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin: 27px 0 15px;
        color: var(--sp-purple-dark);
        font-size: 12px;
        font-weight: 800;
    }

    .sp-results-line {
        flex: 1;
        height: 1px;
        background: var(--sp-border);
    }

    .sp-results-table-wrap {
        overflow-x: auto;
        border: 1px solid var(--sp-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(67,39,101,.045);
    }

    .sp-results-table {
        width: 100%;
        min-width: 680px;
        border-collapse: collapse;
        font-size: 12px;
    }

    .sp-results-table th,
    .sp-results-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--sp-border);
        text-align: left;
        vertical-align: middle;
    }

    .sp-results-table th {
        background: #f8f4fc;
        color: var(--sp-purple-dark);
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sp-results-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .sp-results-table tbody tr:hover {
        background: #fcfaff;
    }

    .sp-table-name {
        color: var(--sp-purple-dark);
        font-weight: 800;
    }

    .sp-table-subtitle {
        margin-top: 4px;
        color: var(--sp-muted);
        font-size: 10px;
        line-height: 1.6;
    }

    .sp-table-status {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 20px;
        background: #fff4d7;
        color: #826219;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sp-table-status.approved {
        background: #e4f5e8;
        color: #28653d;
    }

    .sp-table-status.revision {
        background: #fceedf;
        color: #92531d;
    }

    .sp-table-status.rejected {
        background: #fbe8ea;
        color: #9d3948;
    }

    .sp-table-detail-button {
        padding: 8px 11px;
        border: 1px solid #e2d5ef;
        border-radius: 8px;
        background: #f8f4fc;
        color: var(--sp-purple);
        cursor: pointer;
        font: inherit;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sp-table-actions {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 10px;
        min-width: 112px;
    }

    .sp-table-detail-button:hover {
        border-color: var(--sp-purple);
        background: var(--sp-purple);
        color: #fff;
    }

    .sp-table-edit-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: auto;
        min-height: 34px;
        padding: 0 12px;
        border: 1px solid #ead8a8;
        border-radius: 8px;
        background: #fffaf0;
        color: #8a6824;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.3;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color .18s ease, border-color .18s ease, transform .15s ease;
    }

    .sp-table-edit-link:hover {
        border-color: #d5b65f;
        background: #f9efd5;
        color: #6c4e12;
        transform: translateY(-1px);
    }

    .sp-table-edit-link svg {
        width: 14px;
        height: 14px;
        flex: 0 0 14px;
    }

    .sp-prestasi-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-items: stretch;
        gap: 17px;
    }

    /* KARTU PRESTASI */
    .sp-prestasi-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 21px;
        border: 1px solid var(--sp-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(67,39,101,.035);
        transition: transform .2s, box-shadow .2s, border-color .2s;
    }

    .sp-prestasi-card::before {
        position: absolute;
        top: -1px;
        right: 18px;
        left: 18px;
        height: 3px;
        border-radius: 0 0 5px 5px;
        background: var(--sp-gold);
        content: "";
    }

    .sp-prestasi-card:hover {
        transform: translateY(-3px);
        border-color: #d7c5e8;
        box-shadow: 0 10px 25px rgba(67,39,101,.085);
    }

    .sp-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        min-height: 27px;
    }

    .sp-level-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 75%;
        padding: 7px 10px;
        border: 1px solid #e6d9f2;
        border-radius: 30px;
        background: #f7f2fc;
        color: var(--sp-purple);
        font-size: 10px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .sp-badge-dot {
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--sp-gold);
    }

    .sp-year {
        color: #9588a5;
        font-size: 11px;
        font-weight: 700;
    }

    .sp-card-icon {
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        margin: 18px 0 13px;
        border: 1px solid #eadff4;
        border-radius: 12px;
        background: linear-gradient(145deg, #f7f2fc, #eee4f7);
        color: var(--sp-gold);
        font-size: 24px;
    }

    .sp-prestasi-card h3 {
        margin: 0;
        color: var(--sp-purple-dark);
        font-size: 15px;
        font-weight: 800;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .sp-card-divider {
        height: 1px;
        margin: 16px 0;
        background: #f0eaf5;
    }

    .sp-detail-label {
        display: block;
        margin-bottom: 9px;
        color: #a094b0;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .sp-member-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .sp-member {
        max-width: 100%;
        padding: 6px 9px;
        border-radius: 7px;
        background: #f5effb;
        color: #5c437c;
        font-size: 10px;
        overflow-wrap: anywhere;
    }

    .sp-muted {
        color: var(--sp-muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .sp-card-meta {
        display: grid;
        gap: 10px;
        margin: 18px 0;
    }

    .sp-meta-row {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        color: #776b85;
        font-size: 11px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .sp-meta-icon {
        width: 15px;
        flex-shrink: 0;
        color: var(--sp-gold);
        font-size: 14px;
        font-weight: 800;
        line-height: 1.4;
    }

    /* STATUS */
    .sp-auth-status {
        align-self: flex-start;
        margin: 0 0 13px;
        padding: 7px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
    }

    .sp-auth-status.pending {
        background: #fff4d7;
        color: #826219;
    }

    .sp-auth-status.approved {
        background: #e4f5e8;
        color: #28653d;
    }

    .sp-auth-status.revision {
        background: #fceedf;
        color: #92531d;
    }

    .sp-auth-status.rejected {
        background: #fbe8ea;
        color: #9d3948;
    }

    /* TOMBOL DETAIL */
    .sp-detail-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        width: 100%;
        min-height: 42px;
        margin-top: auto;
        padding: 0 13px;
        border: 1px solid #e2d5ef;
        border-radius: 9px;
        background: #f8f4fc;
        color: var(--sp-purple);
        cursor: pointer;
        font-size: 11px;
        font-weight: 800;
        transition: .2s;
    }

    .sp-detail-button span {
        color: var(--sp-gold);
        font-size: 17px;
    }

    .sp-detail-button:hover {
        border-color: var(--sp-purple);
        background: var(--sp-purple);
        color: #fff;
    }

    /* PESAN KOSONG */
    .sp-empty-state {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 45px 20px;
        border: 1px dashed #d8c7e9;
        border-radius: 16px;
        background: #fbf8fe;
        text-align: center;
    }

    .sp-empty-icon {
        display: grid;
        place-items: center;
        width: 52px;
        height: 52px;
        margin-bottom: 13px;
        border-radius: 16px;
        background: #eee5f7;
        color: var(--sp-gold);
        font-size: 27px;
    }

    .sp-empty-state h3 {
        margin: 0 0 8px;
        color: var(--sp-purple-dark);
        font-size: 16px;
    }

    .sp-empty-state p {
        max-width: 420px;
        margin: 0;
        color: var(--sp-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    /* MODAL */
    .sp-detail-modal {
        position: fixed;
        z-index: 9999;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .sp-detail-modal.is-open {
        display: flex;
    }

    .sp-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(35,22,49,.57);
        backdrop-filter: blur(4px);
    }

    .sp-modal-box {
        position: relative;
        z-index: 1;
        width: min(100%, 570px);
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        padding: 30px;
        border: 1px solid #e8def2;
        border-radius: 19px;
        background: #fff;
        box-shadow: 0 24px 70px rgba(26,15,40,.24);
    }

    .sp-modal-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-right: 48px;
    }

    .sp-modal-heading .sp-section-kicker {
        margin: 0;
    }

    .sp-modal-status {
        display: inline-flex;
        align-items: center;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sp-modal-status.pending {
        background: #fff4d7;
        color: #826219;
    }

    .sp-modal-status.approved {
        background: #e4f5e8;
        color: #28653d;
    }

    .sp-modal-status.rejected {
        background: #fbe8ea;
        color: #9d3948;
    }

    .sp-modal-status.revision {
        background: #fceedf;
        color: #92531d;
    }

    .sp-modal-evidence,
    .sp-modal-note {
        grid-column: 1 / -1;
        min-width: 0;
        padding: 15px;
        border: 1px solid #eee6f5;
        border-radius: 10px;
        background: #fcfaff;
    }

    .sp-modal-evidence h3,
    .sp-modal-note h3 {
        margin: 0 0 11px;
        color: var(--sp-purple-dark);
        font-size: 12px;
    }

    .sp-modal-evidence-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
    }

    .sp-modal-evidence-card {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        padding: 9px;
        border: 1px solid #eee6f5;
        border-radius: 9px;
        background: #fff;
        color: var(--sp-purple-dark);
        text-decoration: none;
        transition: border-color .2s, transform .2s;
    }

    .sp-modal-evidence-card:hover {
        border-color: var(--sp-gold);
        transform: translateY(-1px);
    }

    .sp-modal-evidence-card img,
    .sp-modal-file-type {
        display: grid;
        place-items: center;
        flex: 0 0 54px;
        width: 54px;
        height: 54px;
        border-radius: 7px;
        background: #f3edf9;
        object-fit: cover;
    }

    .sp-modal-file-type {
        color: var(--sp-purple);
        font-size: 11px;
        font-weight: 800;
    }

    .sp-modal-file-info {
        display: grid;
        gap: 4px;
        min-width: 0;
    }

    .sp-modal-file-info strong,
    .sp-modal-file-info small {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sp-modal-file-info strong {
        font-size: 10px;
    }

    .sp-modal-file-info small,
    .sp-modal-empty {
        color: var(--sp-muted);
        font-size: 10px;
    }

    .sp-modal-empty,
    .sp-modal-note p {
        margin: 0;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .sp-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        display: grid;
        place-items: center;
        width: 35px;
        height: 35px;
        border: 1px solid #e8def2;
        border-radius: 10px;
        background: #f8f4fc;
        color: var(--sp-purple);
        cursor: pointer;
        font-size: 24px;
    }

    .sp-modal-box h2 {
        margin: 13px 40px 8px 0;
        color: var(--sp-purple-dark);
        font-size: 24px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .sp-modal-intro {
        margin: 0 0 21px;
        color: var(--sp-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .sp-modal-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .sp-modal-detail-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
        padding: 14px;
        border: 1px solid #eee6f5;
        border-radius: 10px;
        background: #fcfaff;
    }

    .sp-modal-detail-item.full-width {
        grid-column: 1 / -1;
    }

    .sp-modal-detail-item span {
        color: #9487a4;
        font-size: 10px;
        font-weight: 700;
    }

    .sp-modal-detail-item strong {
        color: var(--sp-purple-dark);
        font-size: 12px;
        line-height: 1.7;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    /* RESPONSIVE */
    @media (max-width: 1200px) {
        .sp-filter-grid,
        .sp-filter-grid.with-status {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .sp-reset-button {
            width: 100%;
        }
    }

    @media (max-width: 1050px) {
        .sp-prestasi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .sp-public-page {
            padding-top: 20px;
        }

        .sp-prestasi-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 620px) {
        .sp-hero {
            min-height: 220px;
            padding: 28px 20px;
            border-radius: 17px;
        }

        .sp-hero h1 {
            max-width: 300px;
            font-size: 34px;
        }

        .sp-hero p {
            max-width: 300px;
            font-size: 12px;
        }

        .sp-section-heading {
            align-items: flex-start;
        }

        .sp-section-heading h2 {
            font-size: 20px;
        }

        .sp-section-heading p {
            font-size: 11px;
        }

        .sp-count {
            flex-direction: column;
            gap: 3px;
            padding: 9px;
        }

        .sp-count span {
            font-size: 19px;
        }

        .sp-count small {
            font-size: 9px;
            text-align: center;
        }

        .sp-filter-panel {
            padding: 15px;
        }

        .sp-filter-grid,
        .sp-filter-grid.with-status {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .sp-prestasi-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .sp-prestasi-card {
            padding: 20px;
        }

        .sp-modal-box {
            padding: 26px 18px 20px;
        }

        .sp-modal-box h2 {
            font-size: 21px;
        }

        .sp-modal-details {
            grid-template-columns: 1fr;
        }

        .sp-modal-heading {
            align-items: flex-start;
            flex-direction: column;
            padding-right: 42px;
        }

        .sp-modal-evidence-list {
            grid-template-columns: 1fr;
        }
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
        const cards = [...document.querySelectorAll('.sp-prestasi-row')];
        const emptyState = document.getElementById('prestasiEmpty');
        const emptyTitle = document.getElementById('prestasiEmptyTitle');
        const emptyDescription = document.getElementById('prestasiEmptyDescription');
        const count = document.getElementById('prestasiCount');

        function applyFilters() {
            const search = (searchInput.value || '').trim().toLowerCase();
            const kategori = filterKategori.value;
            const tingkat = filterTingkat.value;
            const tahun = filterTahun.value;
            const status = filterStatus ? filterStatus.value : '';

            let visible = 0;

            cards.forEach((card) => {
                const matchesSearch =
                    (card.dataset.search || '').toLowerCase().includes(search);

                const matchesKategori =
                    !kategori || card.dataset.kategori === kategori;

                const matchesTingkat =
                    !tingkat || card.dataset.tingkat === tingkat;

                const matchesTahun =
                    !tahun || card.dataset.tahun === tahun;

                const matchesStatus =
                    !status || card.dataset.status === status;

                const show =
                    matchesSearch &&
                    matchesKategori &&
                    matchesTingkat &&
                    matchesTahun &&
                    matchesStatus;

                card.style.display = show ? '' : 'none';

                if (show) {
                    visible++;
                }
            });

            count.textContent = visible;

            if (visible === 0) {
                emptyState.style.display = 'flex';

                if (cards.length === 0) {
                    emptyTitle.textContent = @json($pesanKosong);

                    emptyDescription.textContent =
                        'Data prestasi yang tersedia akan ditampilkan di halaman ini.';
                } else {
                    emptyTitle.textContent = 'Prestasi tidak ditemukan';

                    emptyDescription.textContent =
                        'Coba ubah kata kunci atau pilihan filter.';
                }
            } else {
                emptyState.style.display = 'none';
            }
        }

        [searchInput, filterKategori, filterTingkat, filterTahun]
            .forEach((element) => {
                element.addEventListener('input', applyFilters);
                element.addEventListener('change', applyFilters);
            });

        if (filterStatus) {
            filterStatus.addEventListener('change', applyFilters);
        }

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

        document.getElementById('modalPenyelenggara').textContent =
            penyelenggara || '-';
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
