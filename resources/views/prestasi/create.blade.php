@extends('layouts.app')

@section('title', 'Pengajuan Prestasi - SIPRESKA')

@section('content')
@php
    $prestasi = $prestasi ?? null;
    $isDosen = auth()->user()?->role === 'dosen';
    $isEditing = isset($prestasi);
    $jenisTerpilih = old('jenis_prestasi', $prestasi?->jenis_prestasi);
    $anggotaTersimpan = $prestasi?->anggota
        ->where('peran', 'anggota')
        ->map(fn ($anggota) => [
            'nama' => $anggota->nama,
            'nim' => $anggota->nim_nip,
        ])
        ->values()
        ->all() ?? [];
    $anggotaLama = old('anggota_tim', $anggotaTersimpan ?: [['nama' => '', 'nim' => '']]);
    $dosenPembimbingLama = $prestasi?->anggota->firstWhere('peran', 'dosen_pembimbing');
    $sertifikatLama = $prestasi?->bukti->firstWhere('jenis_bukti', 'Sertifikat');
    $dokumentasiLama = $prestasi?->bukti->firstWhere('jenis_bukti', 'Dokumentasi');
    $skLama = $prestasi?->bukti->firstWhere('jenis_bukti', 'SK Tugas') ?? $prestasi?->bukti->firstWhere('jenis_bukti', 'Surat Keputusan (SK)');

    $deskripsiForm = $isDosen
        ? 'Lengkapi informasi prestasi yang Anda ajukan. Pengajuan akan diperiksa oleh administrator.'
        : 'Lengkapi informasi pencapaian dengan benar agar pengajuanmu dapat diperiksa oleh administrator.';
@endphp

<div class="sp-form-page">

    {{-- HEADER FORM --}}
    <section class="sp-form-hero">
        <span class="sp-form-eyebrow">{{ $isEditing ? 'PERBAIKAN PENGAJUAN' : 'FORMULIR PENGAJUAN' }}</span>

        <h1>{{ $isEditing ? 'Perbaiki' : 'Ajukan' }} <span>Prestasi</span></h1>

        <p>{{ $isEditing ? 'Data sebelumnya sudah diisikan kembali. Ubah bagian yang perlu diperbaiki, lalu kirim ulang.' : $deskripsiForm }}</p>
    </section>

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div class="sp-form-alert success" role="status">
            <strong>✓ Pengajuan berhasil</strong>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($isEditing && !empty($catatanPerbaikan))
        <div class="sp-form-alert error" role="note">
            <strong>Catatan dari verifikator</strong>
            <p>{{ $catatanPerbaikan }}</p>
        </div>
    @endif

    {{-- NOTIFIKASI VALIDASI --}}
    @if ($errors->any())
        <div class="sp-form-alert error" role="alert">
            <strong>Periksa kembali data pengajuan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM PENGAJUAN --}}
    <form
        id="formPengajuanPrestasi"
        action="{{ $isEditing ? route('prestasi.update', $prestasi) : route('prestasi.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="sp-prestasi-form"
    >
        @csrf
        @if ($isEditing)
            @method('PUT')
        @endif

        <input
            type="hidden"
            name="submission_token"
            value="{{ $submissionToken }}"
        >

        {{-- 01. INFORMASI PRESTASI --}}
        <section class="sp-form-panel">
            <div class="sp-panel-heading">
                <span class="sp-panel-number">01</span>

                <div>
                    <h2>Informasi Prestasi</h2>
                    <p>
                        Kolom dengan tanda
                        <span class="sp-required">*</span>
                        wajib diisi.
                    </p>
                </div>
            </div>

            <div class="sp-form-grid">
                <div class="sp-form-field">
                    <label for="kategori_id">
                        Kategori Prestasi
                        <span class="sp-required">*</span>
                    </label>

                    <select name="kategori_id" id="kategori_id" required>
                        <option value="">Pilih kategori</option>

                        @foreach ($kategoris as $kategori)
                            <option
                                value="{{ $kategori->id }}"
                                @selected(old('kategori_id', $prestasi?->kategori_id) == $kategori->id)
                            >
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('kategori_id')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="tingkat_id">
                        Tingkat Prestasi
                        <span class="sp-required">*</span>
                    </label>

                    <select name="tingkat_id" id="tingkat_id" required>
                        <option value="">Pilih tingkat</option>

                        @foreach ($tingkats as $tingkat)
                            <option
                                value="{{ $tingkat->id }}"
                                @selected(old('tingkat_id', $prestasi?->tingkat_id) == $tingkat->id)
                            >
                                {{ $tingkat->nama_tingkat }}
                            </option>
                        @endforeach
                    </select>

                    @error('tingkat_id')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field sp-full-width">
                    <label for="nama_prestasi">
                        Nama Prestasi
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="nama_prestasi"
                        name="nama_prestasi"
                        value="{{ old('nama_prestasi', $prestasi?->nama_prestasi) }}"
                        maxlength="255"
                        placeholder="Contoh: Juara 1 Kompetisi Karya Tulis"
                        required
                    >

                    @error('nama_prestasi')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="jenis_prestasi">
                        Jenis Prestasi
                        <span class="sp-required">*</span>
                    </label>

                    <select name="jenis_prestasi" id="jenis_prestasi" required>
                        <option value="">Pilih jenis prestasi</option>

                        <option
                            value="individu"
                            @selected($jenisTerpilih === 'individu')
                        >
                            Individu
                        </option>

                        <option
                            value="tim"
                            @selected($jenisTerpilih === 'tim')
                        >
                            Tim
                        </option>
                    </select>

                    @error('jenis_prestasi')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="tahun">
                        Tahun Perolehan
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="number"
                        id="tahun"
                        name="tahun"
                        value="{{ old('tahun', $prestasi?->tahun) }}"
                        min="2000"
                        max="2100"
                        placeholder="Contoh: 2026"
                        required
                    >

                    @error('tahun')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- 02. ANGGOTA TIM --}}
        <section
            class="sp-form-panel"
            id="bagianAnggotaTim"
            style="{{ $jenisTerpilih === 'tim' ? '' : 'display:none;' }}"
            aria-hidden="{{ $jenisTerpilih === 'tim' ? 'false' : 'true' }}"
        >
            <div class="sp-panel-heading">
                <span class="sp-panel-number">02</span>

                <div>
                    <h2>Anggota Tim</h2>
                    <p>
                        Isi nama dan NIM setiap anggota selain dirimu sendiri. Tambahkan baris sesuai jumlah anggota; data akan disimpan bersama pengajuan.
                    </p>
                </div>
            </div>

            <div id="daftarAnggotaTim" class="sp-team-list">
                @php
                    if (!is_array($anggotaLama) || count($anggotaLama) === 0) {
                        $anggotaLama = [['nama' => '', 'nim' => '']];
                    }
                @endphp

                @foreach ($anggotaLama as $i => $anggota)
                    <div class="sp-team-row">
                        <div class="sp-team-row-heading">
                            <strong class="sp-team-number">Anggota {{ $loop->iteration }}</strong>
                            <button type="button" class="sp-remove-member" @if ($loop->first) hidden @endif>Hapus</button>
                        </div>
                        <div class="sp-form-grid">
                            <div class="sp-form-field">
                                <label for="anggota_nama_{{ $i }}">Nama Anggota <span class="sp-required">*</span></label>
                                <input type="text" id="anggota_nama_{{ $i }}" name="anggota_tim[{{ $i }}][nama]" value="{{ $anggota['nama'] ?? '' }}" class="sp-team-name" maxlength="255" placeholder="Nama lengkap anggota" @if ($jenisTerpilih === 'tim') required @endif @if ($jenisTerpilih !== 'tim') disabled @endif>
                                @error("anggota_tim.$i.nama")<small class="sp-field-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="sp-form-field">
                                <label for="anggota_nim_{{ $i }}">NIM Anggota <span class="sp-required">*</span></label>
                                <input type="text" id="anggota_nim_{{ $i }}" name="anggota_tim[{{ $i }}][nim]" value="{{ $anggota['nim'] ?? '' }}" class="sp-team-nim" maxlength="50" placeholder="Nomor induk mahasiswa" @if ($jenisTerpilih === 'tim') required @endif @if ($jenisTerpilih !== 'tim') disabled @endif>
                                @error("anggota_tim.$i.nim")<small class="sp-field-error">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @error('anggota_tim')
                <small class="sp-field-error">{{ $message }}</small>
            @enderror

            <button
                type="button"
                id="tambahAnggotaTim"
                class="sp-add-member"
            >
                <span aria-hidden="true">＋</span>
                Tambah Anggota
            </button>
        </section>

        {{-- 03. DOSEN PEMBIMBING HANYA UNTUK MAHASISWA --}}
        @unless ($isDosen)
            <section class="sp-form-panel">
                <div class="sp-panel-heading">
                    <span class="sp-panel-number">03</span>

                    <div>
                        <h2>Dosen Pembimbing</h2>
                        <p>Isi jika prestasi memiliki dosen pembimbing.</p>
                    </div>
                </div>

                <div class="sp-form-grid">
                    <div class="sp-form-field">
                        <label for="dosen_pembimbing_nama">
                            Nama Dosen Pembimbing
                            <span class="sp-optional">(Opsional)</span>
                        </label>

                        <input
                            type="text"
                            id="dosen_pembimbing_nama"
                            name="dosen_pembimbing_nama"
                            value="{{ old('dosen_pembimbing_nama', $dosenPembimbingLama?->nama ?: $dosenPembimbingLama?->sivitas?->nama) }}"
                            maxlength="255"
                            placeholder="Nama dosen pembimbing"
                        >

                        @error('dosen_pembimbing_nama')
                            <small class="sp-field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sp-form-field">
                        <label for="dosen_pembimbing_nip">
                            NIP Dosen Pembimbing
                            <span class="sp-optional">(Opsional)</span>
                        </label>

                        <input
                            type="text"
                            id="dosen_pembimbing_nip"
                            name="dosen_pembimbing_nip"
                            value="{{ old('dosen_pembimbing_nip', $dosenPembimbingLama?->nim_nip ?: $dosenPembimbingLama?->sivitas?->user?->nim_nip) }}"
                            maxlength="50"
                            placeholder="NIP dosen pembimbing"
                        >

                        @error('dosen_pembimbing_nip')
                            <small class="sp-field-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        @endunless

        {{-- 04. DETAIL PENCAPAIAN --}}
        <section class="sp-form-panel">
            <div class="sp-panel-heading">
                <span class="sp-panel-number">{{ $isDosen ? '03' : '04' }}</span>

                <div>
                    <h2>Detail Pencapaian</h2>
                    <p>Lengkapi peringkat dan penyelenggara kegiatan.</p>
                </div>
            </div>

            <div class="sp-form-grid">
                <div class="sp-form-field">
                    <label for="peringkat">Peringkat atau Capaian</label>

                    <input
                        type="text"
                        id="peringkat"
                        name="peringkat"
                        value="{{ old('peringkat', $prestasi?->peringkat) }}"
                        maxlength="100"
                        placeholder="Contoh: Juara 1"
                    >

                    @error('peringkat')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="penyelenggara">
                        Penyelenggara
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="penyelenggara"
                        name="penyelenggara"
                        value="{{ old('penyelenggara', $prestasi?->penyelenggara) }}"
                        maxlength="255"
                        placeholder="Nama instansi penyelenggara"
                        required
                    >

                    @error('penyelenggara')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field sp-full-width">
                    <label for="deskripsi">Deskripsi Prestasi</label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="5"
                        placeholder="Jelaskan kegiatan atau keterangan tambahan..."
                    >{{ old('deskripsi', $prestasi?->deskripsi) }}</textarea>

                    @error('deskripsi')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- 05. BUKTI PRESTASI --}}
        <section class="sp-form-panel">
            <div class="sp-panel-heading">
                <span class="sp-panel-number">{{ $isDosen ? '04' : '05' }}</span>

                <div>
                    <h2>Bukti Prestasi</h2>
                    <p>
                        Sertifikat dan dokumentasi wajib diunggah.
                        SK Tugas bersifat opsional.
                    </p>
                </div>
            </div>

            <div class="sp-form-grid">
                <div class="sp-form-field">
                    <label for="bukti_sertifikat">
                        Sertifikat
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="file"
                        id="bukti_sertifikat"
                        name="bukti_sertifikat"
                        accept=".pdf,.jpg,.jpeg,.png"
                        @if (!$isEditing || !$sertifikatLama) required @endif
                    >

                    @if ($sertifikatLama)
                        <small class="sp-field-hint">
                            Sertifikat saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($sertifikatLama->file_path) }}" target="_blank" rel="noopener">{{ $sertifikatLama->nama_file }}</a>. Kosongkan jika tidak ingin menggantinya.
                        </small>
                    @endif

                    <small class="sp-field-hint">
                        PDF, JPG, JPEG, atau PNG; maksimal 2 MB.
                    </small>

                    @error('bukti_sertifikat')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="bukti_dokumentasi">
                        Dokumentasi Prestasi
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="file"
                        id="bukti_dokumentasi"
                        name="bukti_dokumentasi"
                        accept=".pdf,.jpg,.jpeg,.png"
                        @if (!$isEditing || !$dokumentasiLama) required @endif
                    >

                    @if ($dokumentasiLama)
                        <small class="sp-field-hint">
                            Dokumentasi saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($dokumentasiLama->file_path) }}" target="_blank" rel="noopener">{{ $dokumentasiLama->nama_file }}</a>. Kosongkan jika tidak ingin menggantinya.
                        </small>
                    @endif

                    <small class="sp-field-hint">
                        Unggah foto kegiatan (bukan sertifikat atau SK) agar dapat ditampilkan pada kartu prestasi. PDF, JPG, JPEG, atau PNG; maksimal 2 MB.
                    </small>

                    @error('bukti_dokumentasi')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field sp-full-width">
                    <label for="bukti_sk">
                        SK Tugas (Surat Keputusan)
                        <span class="sp-optional">(Opsional)</span>
                    </label>

                    <input
                        type="file"
                        id="bukti_sk"
                        name="bukti_sk"
                        accept=".pdf,.jpg,.jpeg,.png"
                    >

                    @if ($skLama)
                        <small class="sp-field-hint">
                            SK Tugas saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($skLama->file_path) }}" target="_blank" rel="noopener">{{ $skLama->nama_file }}</a>. Kosongkan jika tidak ingin menggantinya.
                        </small>
                    @endif

                    <small class="sp-field-hint">
                        PDF, JPG, JPEG, atau PNG; maksimal 2 MB.
                    </small>

                    @error('bukti_sk')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- INFORMASI FORM --}}
        <div class="sp-form-information">
            <span class="sp-information-icon">i</span>

            <div>
                <strong>{{ $isEditing ? 'Data lama tetap tersimpan.' : 'Periksa data sebelum dikirim.' }}</strong>

                <p>
                    @if ($isEditing)
                        Ubah bagian yang perlu diperbaiki. Bukti lama tetap digunakan jika tidak diganti.
                    @else
                    Tanda bintang (*) berarti wajib diisi.
                    Nama dan NIM anggota hanya diperlukan untuk prestasi tim.
                    @if ($isDosen)
                        Sebagai Dosen, Anda tidak perlu mengisi Dosen Pembimbing.
                    @else
                        Dosen Pembimbing dan SK bersifat opsional.
                    @endif
                    @endif
                </p>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="sp-form-actions">
            <a
                href="{{ $isDosen ? route('dosen.prestasi.index') : route('prestasi') }}"
                class="sp-button-cancel"
            >
                Batal
            </a>

            <button
                type="submit"
                id="submitPengajuan"
                class="sp-button-submit"
            >
                <span class="sp-submit-label">{{ $isEditing ? 'Kirim Ulang Perbaikan' : 'Simpan Pengajuan' }}</span>
                <span class="sp-submit-arrow" aria-hidden="true">→</span>
            </button>
        </div>
    </form>
</div>

<style>
    .sp-form-page {
        --form-purple: #65458e;
        --form-dark: #432765;
        --form-lavender: #f5effb;
        --form-gold: #c9a227;
        --form-text: #392c4a;
        --form-muted: #857991;
        --form-border: #e8e0ef;

        width: 100%;
        max-width: 1360px;
        margin: 30px auto 60px;
        color: var(--form-text);
    }

    .sp-form-page *,
    .sp-form-page *::before,
    .sp-form-page *::after {
        box-sizing: border-box;
    }

    .sp-form-hero {
        position: relative;
        overflow: hidden;
        padding: 37px clamp(22px, 5vw, 50px);
        border: 1px solid #e8ddf2;
        border-radius: 22px;
        background:
            radial-gradient(circle at 93% 15%, rgba(201,162,39,.16), transparent 25%),
            linear-gradient(120deg, #faf7fd, #eee4f7);
    }

    .sp-form-eyebrow {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #dfd0ee;
        border-radius: 30px;
        background: rgba(255,255,255,.75);
        color: var(--form-purple);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.7px;
    }

    .sp-form-hero h1 {
        margin: 18px 0 10px;
        color: var(--form-dark);
        font-size: clamp(31px, 4vw, 45px);
        line-height: 1.2;
        letter-spacing: -1px;
    }

    .sp-form-hero h1 span {
        color: var(--form-purple);
    }

    .sp-form-hero p {
        max-width: 570px;
        margin: 0;
        color: #786c88;
        font-size: 13px;
        line-height: 1.9;
    }

    .sp-form-alert {
        margin-top: 20px;
        padding: 16px 19px;
        border: 1px solid;
        border-radius: 12px;
        font-size: 12px;
        line-height: 1.8;
    }

    .sp-form-alert p {
        margin: 5px 0 0;
    }

    .sp-form-alert ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }

    .sp-form-alert.success {
        border-color: #cde8d3;
        background: #f0faf2;
        color: #28633d;
    }

    .sp-form-alert.error {
        border-color: #f1ccd2;
        background: #fff5f6;
        color: #8c3443;
    }

    .sp-prestasi-form {
        display: grid;
        gap: 22px;
        margin-top: 24px;
    }

    .sp-form-panel {
        padding: clamp(20px, 3vw, 30px);
        border: 1px solid var(--form-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 7px 26px rgba(67,39,101,.045);
    }

    .sp-panel-heading {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0eaf5;
    }

    .sp-panel-number {
        display: grid;
        place-items: center;
        flex: 0 0 43px;
        width: 43px;
        height: 43px;
        border: 1px solid #e4d6f1;
        border-radius: 13px;
        background: var(--form-lavender);
        color: var(--form-purple);
        font-size: 12px;
        font-weight: 800;
    }

    .sp-panel-heading h2 {
        margin: 1px 0 7px;
        color: var(--form-dark);
        font-size: 18px;
        font-weight: 800;
    }

    .sp-panel-heading p {
        margin: 0;
        color: var(--form-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .sp-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px 20px;
    }

    .sp-form-field {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 8px;
    }

    .sp-full-width {
        grid-column: 1 / -1;
    }

    .sp-form-field label {
        color: #534362;
        font-size: 13px;
        font-weight: 800;
    }

    .sp-required {
        color: #bd3d52;
        font-weight: 900;
    }

    .sp-optional {
        color: #9588a4;
        font-size: 10px;
        font-weight: 500;
    }

    .sp-form-field input:not([type="file"]),
    .sp-form-field select,
    .sp-form-field textarea {
        width: 100%;
        min-width: 0;
        border: 1px solid #e4dcec;
        border-radius: 10px;
        outline: none;
        background: #fdfbff;
        color: var(--form-text);
        font: inherit;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .sp-form-field input:not([type="file"]),
    .sp-form-field select {
        min-height: 56px;
        padding: 0 16px;
    }

    .sp-form-field textarea {
        min-height: 125px;
        padding: 13px;
        line-height: 1.8;
        resize: vertical;
    }

    .sp-form-field input:focus,
    .sp-form-field select:focus,
    .sp-form-field textarea:focus {
        border-color: var(--form-purple);
        box-shadow: 0 0 0 3px rgba(101,69,142,.09);
    }

    .sp-form-field input::placeholder,
    .sp-form-field textarea::placeholder {
        color: #a69bb3;
    }

    .sp-form-field input[type="file"] {
        width: 100%;
        min-width: 0;
        padding: 10px;
        border: 1px dashed #d7c5e7;
        border-radius: 10px;
        background: #faf7fd;
        color: #756585;
        font: inherit;
        font-size: 11px;
    }

    .sp-form-field input[type="file"]::file-selector-button {
        margin-right: 10px;
        padding: 8px 10px;
        border: 1px solid #e1d4ee;
        border-radius: 7px;
        background: #eee5f7;
        color: var(--form-purple);
        cursor: pointer;
        font: inherit;
        font-size: 10px;
        font-weight: 800;
    }

    .sp-field-hint {
        color: #968ba2;
        font-size: 10px;
        line-height: 1.7;
    }

    .sp-field-error {
        color: #b43c51;
        font-size: 11px;
        line-height: 1.6;
    }

    .sp-team-list {
        display: grid;
        gap: 15px;
    }

    .sp-team-row {
        padding: 16px;
        border: 1px solid #e9e0f1;
        border-radius: 12px;
        background: #fcfaff;
    }

    .sp-team-row-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .sp-team-number {
        color: var(--form-dark);
        font-size: 12px;
    }

    .sp-remove-member {
        padding: 6px 10px;
        border: 1px solid #f0d6da;
        border-radius: 7px;
        background: #fff5f6;
        color: #a83b4c;
        cursor: pointer;
        font: inherit;
        font-size: 10px;
        font-weight: 800;
    }

    .sp-add-member {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        margin-top: 16px;
        padding: 0 13px;
        border: 1px solid #dfd1ed;
        border-radius: 9px;
        background: #f7f2fc;
        color: var(--form-purple);
        cursor: pointer;
        font: inherit;
        font-size: 11px;
        font-weight: 800;
    }

    .sp-add-member span {
        color: var(--form-gold);
        font-size: 17px;
    }

    .sp-form-information {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 19px 21px;
        border: 1px solid #e3d5f0;
        border-left: 4px solid var(--form-gold);
        border-radius: 13px;
        background: linear-gradient(120deg,#faf7fd,#fffdf8);
    }

    .sp-information-icon {
        display: grid;
        place-items: center;
        flex: 0 0 27px;
        width: 27px;
        height: 27px;
        border-radius: 50%;
        background: #eee5f7;
        color: var(--form-purple);
        font-family: Georgia, serif;
        font-size: 16px;
        font-weight: 800;
    }

    .sp-form-information strong {
        display: block;
        margin-bottom: 6px;
        color: var(--form-dark);
        font-size: 12px;
    }

    .sp-form-information p {
        margin: 0;
        color: var(--form-muted);
        font-size: 11px;
        line-height: 1.9;
    }

    .sp-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }

    .sp-button-cancel,
    .sp-button-submit {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 14px;
        min-height: 47px;
        padding: 0 22px;
        border: 1px solid;
        border-radius: 10px;
        font: inherit;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .sp-button-cancel {
        border-color: #ded2e9;
        background: #fff;
        color: var(--form-purple);
    }

    .sp-button-cancel:hover {
        background: var(--form-lavender);
    }

    .sp-button-submit {
        border-color: var(--form-purple);
        background: linear-gradient(135deg,#72539a,#4b2f70);
        color: #fff;
        box-shadow: 0 5px 13px rgba(75,47,112,.17);
    }

    .sp-submit-arrow {
        color: #f1d889;
        font-size: 18px;
    }

    .sp-button-submit:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(75,47,112,.23);
    }

    .sp-button-submit:disabled {
        opacity: .7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    @media (max-width: 640px) {
        .sp-form-page {
            margin-top: 20px;
        }

        .sp-form-hero {
            padding: 27px 20px;
            border-radius: 17px;
        }

        .sp-form-hero h1 {
            font-size: 33px;
        }

        .sp-form-panel {
            padding: 20px 16px;
            border-radius: 15px;
        }

        .sp-panel-heading {
            gap: 11px;
        }

        .sp-panel-heading h2 {
            font-size: 16px;
        }

        .sp-form-grid {
            grid-template-columns: 1fr;
        }

        .sp-full-width {
            grid-column: auto;
        }

        .sp-form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .sp-button-cancel,
        .sp-button-submit {
            width: 100%;
        }

        .sp-form-information {
            padding: 16px;
        }
    }
</style>

<script>
(() => {
    const form = document.getElementById('formPengajuanPrestasi');
    const jenisPrestasi = document.getElementById('jenis_prestasi');
    const bagianTim = document.getElementById('bagianAnggotaTim');
    const daftarTim = document.getElementById('daftarAnggotaTim');
    const tambahAnggota = document.getElementById('tambahAnggotaTim');
    const tombolSubmit = document.getElementById('submitPengajuan');
    const sedangEdit = @json($isEditing);
    let sedangMengirim = false;

    function aturNomorAnggota() {
        const rows = Array.from(daftarTim.querySelectorAll('.sp-team-row'));
        rows.forEach((row, index) => {
            row.querySelector('.sp-team-number').textContent = 'Anggota ' + (index + 1);
            row.querySelector('.sp-remove-member').hidden = rows.length === 1;
        });
    }

    function buatFieldAnggota(judul, key, index, className, placeholder, maxLength) {
        const wrapper = document.createElement('div');
        wrapper.className = 'sp-form-field';
        const label = document.createElement('label');
        label.htmlFor = 'anggota_' + key + '_' + index;
        label.append(document.createTextNode(judul + ' '));
        const tandaWajib = document.createElement('span');
        tandaWajib.className = 'sp-required';
        tandaWajib.textContent = '*';
        label.appendChild(tandaWajib);
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'anggota_tim[' + index + '][' + key + ']';
        input.id = 'anggota_' + key + '_' + index;
        input.className = className;
        input.placeholder = placeholder;
        input.maxLength = maxLength;
        input.required = jenisPrestasi.value === 'tim';
        input.disabled = jenisPrestasi.value !== 'tim';
        wrapper.append(label, input);
        return wrapper;
    }

    function rapikanNamaInput() {
        Array.from(daftarTim.querySelectorAll('.sp-team-row')).forEach((row, index) => {
            ['nama', 'nim'].forEach((key) => {
                const input = row.querySelector('.sp-team-' + key);
                input.name = 'anggota_tim[' + index + '][' + key + ']';
                input.id = 'anggota_' + key + '_' + index;
                input.closest('.sp-form-field').querySelector('label').htmlFor = input.id;
            });
        });
    }

    function tambahBarisAnggota() {
        const index = daftarTim.querySelectorAll('.sp-team-row').length;
        const row = document.createElement('div');
        row.className = 'sp-team-row';
        const heading = document.createElement('div');
        heading.className = 'sp-team-row-heading';
        const title = document.createElement('strong');
        title.className = 'sp-team-number';
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'sp-remove-member';
        removeButton.textContent = 'Hapus';
        removeButton.addEventListener('click', () => {
            row.remove();
            rapikanNamaInput();
            aturNomorAnggota();
        });
        heading.append(title, removeButton);
        const grid = document.createElement('div');
        grid.className = 'sp-form-grid';
        grid.append(
            buatFieldAnggota('Nama Anggota', 'nama', index, 'sp-team-name', 'Nama lengkap anggota', 255),
            buatFieldAnggota('NIM Anggota', 'nim', index, 'sp-team-nim', 'Nomor induk mahasiswa', 50)
        );
        row.append(heading, grid);
        daftarTim.appendChild(row);
        aturNomorAnggota();
    }

    function aturBagianTim() {
        const adalahTim = jenisPrestasi.value === 'tim';
        bagianTim.style.display = adalahTim ? '' : 'none';
        bagianTim.setAttribute('aria-hidden', adalahTim ? 'false' : 'true');
        daftarTim.querySelectorAll('.sp-team-name, .sp-team-nim').forEach((input) => {
            input.required = adalahTim;
            input.disabled = !adalahTim;
        });
        if (adalahTim && daftarTim.querySelectorAll('.sp-team-row').length === 0) {
            tambahBarisAnggota();
        }
        let nomor = 1;
        document.querySelectorAll('.sp-prestasi-form > .sp-form-panel .sp-panel-number').forEach((element) => {
            const panel = element.closest('.sp-form-panel');
            if (panel === bagianTim && !adalahTim) {
                element.textContent = '';
            } else {
                element.textContent = String(nomor++).padStart(2, '0');
            }
        });
    }

    // Validasi ukuran file bukti maksimal 2 MB (2 * 1024 * 1024 bytes)
    const MAX_FILE_SIZE = 2 * 1024 * 1024;
    ['bukti_sertifikat', 'bukti_dokumentasi', 'bukti_sk'].forEach((id) => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    if (file.size > MAX_FILE_SIZE) {
                        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                        alert(`Ukuran file "${file.name}" (${sizeMb} MB) melebihi batas maksimal 2 MB. Silakan unggah dokumen dengan ukuran maksimal 2 MB.`);
                        this.value = '';
                    }
                }
            });
        }
    });

    tambahAnggota.addEventListener('click', tambahBarisAnggota);
    jenisPrestasi.addEventListener('change', aturBagianTim);
    daftarTim.querySelectorAll('.sp-remove-member').forEach((button) => {
        button.addEventListener('click', () => {
            button.closest('.sp-team-row').remove();
            rapikanNamaInput();
            aturNomorAnggota();
        });
    });
    form.addEventListener('submit', (event) => {
        if (sedangMengirim) {
            event.preventDefault();
            return;
        }
        const pesanKonfirmasi = sedangEdit
            ? 'Yakin perubahan data dan bukti prestasi sudah benar? Setelah dikirim, pengajuan akan masuk kembali ke antrean verifikasi.'
            : 'Yakin data pengajuan dan bukti prestasi sudah benar serta sesuai persyaratan?';
        if (!window.confirm(pesanKonfirmasi)) {
            event.preventDefault();
            return;
        }
        sedangMengirim = true;
        tombolSubmit.disabled = true;
        tombolSubmit.querySelector('.sp-submit-label').textContent = 'Mengirim pengajuan...';
        tombolSubmit.querySelector('.sp-submit-arrow').textContent = '✓';
    });
    rapikanNamaInput();
    aturNomorAnggota();
    aturBagianTim();
})();
</script>
@endsection
