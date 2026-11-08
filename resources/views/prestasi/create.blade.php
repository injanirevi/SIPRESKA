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
        ? 'Lengkapi informasi prestasi yang Anda ajukan. Pengajuan akan diperiksa dan diverifikasi oleh tim administrator.'
        : 'Lengkapi rincian pencapaian dan lampirkan berkas bukti resmi agar pengajuan Anda dapat diverifikasi oleh administrator.';
@endphp

<div class="sp-form-page">

    {{-- HEADER FORM MODERN --}}
    <section class="sp-form-hero">
        <div class="sp-hero-content">
            <span class="sp-form-eyebrow">{{ $isEditing ? 'PERBAIKAN PENGAJUAN PRESTASI' : 'FORMULIR PENGAJUAN PRESTASI' }}</span>
            <h1>{{ $isEditing ? 'Perbaiki Pengajuan' : 'Ajukan Prestasi' }} <span>Baru</span></h1>
            <p>{{ $isEditing ? 'Data sebelumnya telah dimuat kembali. Silakan perbaiki bagian yang belum sesuai, lalu kirim ulang berkas pengajuan.' : $deskripsiForm }}</p>
        </div>
    </section>

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div class="sp-form-alert success" role="status">
            <div class="sp-alert-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <strong>Pengajuan Berhasil Diproses</strong>
            </div>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- CATATAN PERBAIKAN DARI VERIFIKATOR --}}
    @if ($isEditing && !empty($catatanPerbaikan))
        <div class="sp-form-alert note" role="note">
            <div class="sp-alert-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <strong>Catatan dari Verifikator Sistem</strong>
            </div>
            <p>{{ $catatanPerbaikan }}</p>
        </div>
    @endif

    {{-- NOTIFIKASI VALIDASI ERROR --}}
    @if ($errors->any())
        <div class="sp-form-alert error" role="alert">
            <div class="sp-alert-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong>Mohon periksa kembali formulir isian Anda</strong>
            </div>
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
                    <h2>Informasi Utama Prestasi</h2>
                    <p>
                        Isi nama kegiatan, kategori bidang, dan tingkat kejuaraan. Kolom dengan tanda
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
                        <option value="">Pilih kategori bidang</option>
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
                        <option value="">Pilih tingkat kompetisi</option>
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
                        Nama Prestasi / Kegiatan
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="nama_prestasi"
                        name="nama_prestasi"
                        value="{{ old('nama_prestasi', $prestasi?->nama_prestasi) }}"
                        maxlength="255"
                        placeholder="Contoh: Juara 1 Kompetisi Karya Tulis Ilmiah Nasional"
                        required
                    >

                    @error('nama_prestasi')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="jenis_prestasi">
                        Jenis Kepesertaan
                        <span class="sp-required">*</span>
                    </label>

                    <select name="jenis_prestasi" id="jenis_prestasi" required>
                        <option value="">Pilih jenis kepesertaan</option>
                        <option
                            value="individu"
                            @selected($jenisTerpilih === 'individu')
                        >
                            Individu (Perorangan)
                        </option>
                        <option
                            value="tim"
                            @selected($jenisTerpilih === 'tim')
                        >
                            Tim (Beregu / Kelompok)
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
                        placeholder="Contoh: {{ date('Y') }}"
                        required
                    >

                    @error('tahun')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- 02. ANGGOTA TIM (JIKA TIM) --}}
        <section
            class="sp-form-panel"
            id="bagianAnggotaTim"
            style="{{ $jenisTerpilih === 'tim' ? '' : 'display:none;' }}"
            aria-hidden="{{ $jenisTerpilih === 'tim' ? 'false' : 'true' }}"
        >
            <div class="sp-panel-heading">
                <span class="sp-panel-number">02</span>

                <div>
                    <h2>Anggota Tim Beregu</h2>
                    <p>
                        Isi nama dan NIM/NIP setiap anggota tim selain pengaju utama. Klik tombol tambah anggota untuk memasukkan anggota lainnya.
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
                            <button type="button" class="sp-remove-member" @if ($loop->first) hidden @endif>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <div class="sp-form-grid">
                            <div class="sp-form-field">
                                <label for="anggota_nama_{{ $i }}">Nama Anggota <span class="sp-required">*</span></label>
                                <input type="text" id="anggota_nama_{{ $i }}" name="anggota_tim[{{ $i }}][nama]" value="{{ $anggota['nama'] ?? '' }}" class="sp-team-name" maxlength="255" placeholder="Nama lengkap anggota tim" @if ($jenisTerpilih === 'tim') required @endif @if ($jenisTerpilih !== 'tim') disabled @endif>
                                @error("anggota_tim.$i.nama")<small class="sp-field-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="sp-form-field">
                                <label for="anggota_nim_{{ $i }}">NIM/NIP Anggota <span class="sp-required">*</span></label>
                                <input type="text" id="anggota_nim_{{ $i }}" name="anggota_tim[{{ $i }}][nim]" value="{{ $anggota['nim'] ?? '' }}" class="sp-team-nim" maxlength="50" placeholder="Nomor induk mahasiswa / pegawai" @if ($jenisTerpilih === 'tim') required @endif @if ($jenisTerpilih !== 'tim') disabled @endif>
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
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                <span>Tambah Anggota Tim</span>
            </button>
        </section>

        {{-- 03. DOSEN PEMBIMBING (HANYA UNTUK MAHASISWA) --}}
        @unless ($isDosen)
            <section class="sp-form-panel">
                <div class="sp-panel-heading">
                    <span class="sp-panel-number">03</span>

                    <div>
                        <h2>Dosen Pembimbing</h2>
                        <p>Lengkapi nama dan NIP dosen pembimbing kegiatan jika ada.</p>
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
                            placeholder="Nama dosen pembimbing kegiatan"
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
                            placeholder="Nomor induk pegawai dosen"
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
                    <h2>Detail Capaian & Deskripsi</h2>
                    <p>Lengkapi peringkat yang diraih, nama instansi penyelenggara, dan ringkasan kegiatan.</p>
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
                        placeholder="Contoh: Juara 1 / Medali Emas / Best Presenter"
                    >

                    @error('peringkat')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="penyelenggara">
                        Penyelenggara Kegiatan
                        <span class="sp-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="penyelenggara"
                        name="penyelenggara"
                        value="{{ old('penyelenggara', $prestasi?->penyelenggara) }}"
                        maxlength="255"
                        placeholder="Contoh: Kemendikbudristek / Universitas Indonesia"
                        required
                    >

                    @error('penyelenggara')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field sp-full-width">
                    <label for="deskripsi">Deskripsi Singkat Prestasi</label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        placeholder="Tuliskan gambaran ringkas mengenai perhelatan kegiatan atau karya yang diajukan..."
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
                    <h2>Berkas Bukti & Dokumentasi</h2>
                    <p>
                        Unggah berkas bukti digital resmi. Sertifikat dan dokumentasi wajib diunggah (format PDF, JPG, PNG; maksimal 2 MB).
                    </p>
                </div>
            </div>

            <div class="sp-form-grid">
                <div class="sp-form-field">
                    <label for="bukti_sertifikat">
                        Berkas Sertifikat
                        <span class="sp-required">*</span>
                    </label>

                    <div class="sp-file-upload-box">
                        <input
                            type="file"
                            id="bukti_sertifikat"
                            name="bukti_sertifikat"
                            accept=".pdf,.jpg,.jpeg,.png"
                            @if (!$isEditing || !$sertifikatLama) required @endif
                        >
                    </div>

                    @if ($sertifikatLama)
                        <small class="sp-field-hint">
                            Berkas saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($sertifikatLama->file_path) }}" target="_blank" rel="noopener">{{ $sertifikatLama->nama_file }}</a>. Kosongkan jika tidak ingin menggantinya.
                        </small>
                    @endif

                    <small class="sp-field-hint">
                        Format: PDF, JPG, JPEG, PNG (Maksimal 2 MB).
                    </small>

                    @error('bukti_sertifikat')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field">
                    <label for="bukti_dokumentasi">
                        Dokumentasi Kegiatan
                        <span class="sp-required">*</span>
                    </label>

                    <div class="sp-file-upload-box">
                        <input
                            type="file"
                            id="bukti_dokumentasi"
                            name="bukti_dokumentasi"
                            accept=".pdf,.jpg,.jpeg,.png"
                            @if (!$isEditing || !$dokumentasiLama) required @endif
                        >
                    </div>

                    @if ($dokumentasiLama)
                        <small class="sp-field-hint">
                            Berkas saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($dokumentasiLama->file_path) }}" target="_blank" rel="noopener">{{ $dokumentasiLama->nama_file }}</a>. Kosongkan jika tidak ingin menggantinya.
                        </small>
                    @endif

                    <small class="sp-field-hint">
                        Foto dokumentasi saat penerimaan piagam atau saat kegiatan berlangsung (Maksimal 2 MB).
                    </small>

                    @error('bukti_dokumentasi')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="sp-form-field sp-full-width">
                    <label for="bukti_sk">
                        Surat Keputusan / SK Tugas
                        <span class="sp-optional">(Opsional)</span>
                    </label>

                    <div class="sp-file-upload-box">
                        <input
                            type="file"
                            id="bukti_sk"
                            name="bukti_sk"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >
                    </div>

                    @if ($skLama)
                        <small class="sp-field-hint">
                            Berkas saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($skLama->file_path) }}" target="_blank" rel="noopener">{{ $skLama->nama_file }}</a>. Kosongkan jika tidak ingin menggantinya.
                        </small>
                    @endif

                    <small class="sp-field-hint">
                        Surat tugas resmi pendelegasian kompetisi kampus jika ada (Maksimal 2 MB).
                    </small>

                    @error('bukti_sk')
                        <small class="sp-field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- INFORMASI FORM PANDUAN --}}
        <div class="sp-form-information">
            <span class="sp-information-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            </span>

            <div>
                <strong>{{ $isEditing ? 'Data lama tetap tersimpan dengan aman.' : 'Periksa kelengkapan data sebelum dikirim.' }}</strong>
                <p>
                    @if ($isEditing)
                        Perbaiki kolom atau berkas bukti yang diperlukan. Berkas bukti lama tetap digunakan apabila Anda tidak mengunggah berkas pengganti.
                    @else
                        Kolom dengan tanda bintang (*) wajib diisi. Pastikan berkas pendukung jelas dan valid agar proses verifikasi berjalan lancar.
                        @if ($isDosen)
                            Sebagai akun Dosen, Anda tidak perlu mengisi kolom Dosen Pembimbing.
                        @else
                            Dosen Pembimbing dan SK Tugas bersifat opsional.
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
                <span class="sp-submit-label">{{ $isEditing ? 'Kirim Ulang Perbaikan' : 'Simpan & Ajukan Prestasi' }}</span>
                <span class="sp-submit-arrow" aria-hidden="true">&rarr;</span>
            </button>
        </div>
    </form>
</div>

<style>
    /* VARIABEL FORM MODERN */
    .sp-form-page {
        --form-purple: #5B3A8E;
        --form-dark: #432765;
        --form-lavender: #F4EFFB;
        --form-gold: #C9A227;
        --form-text: #342847;
        --form-muted: #80758F;
        --form-border: #E7DFF0;

        width: 100%;
        max-width: 1100px;
        margin: 0 auto 40px;
        color: var(--form-text);
        font-family: inherit;
    }

    .sp-form-page *,
    .sp-form-page *::before,
    .sp-form-page *::after {
        box-sizing: border-box;
    }

    /* HEADER BANNER FORM */
    .sp-form-hero {
        position: relative;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(246, 239, 253, 0.95) 100%);
        border: 1px solid #E4D8F0;
        border-left: 5px solid var(--form-gold);
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 6px 20px rgba(67, 39, 101, 0.04);
    }

    .sp-hero-content {
        max-width: 760px;
    }

    .sp-form-eyebrow {
        display: inline-block;
        padding: 4px 10px;
        border: 1px solid #DFD2ED;
        border-radius: 20px;
        background: #FAF7FD;
        color: var(--form-purple);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .sp-form-hero h1 {
        margin: 8px 0 10px;
        font-family: 'Poppins', sans-serif;
        color: #2D1A47;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .sp-form-hero h1 span {
        color: var(--form-purple);
    }

    .sp-form-hero p {
        margin: 0;
        color: #6C5E7F;
        font-size: 13.5px;
        line-height: 1.6;
    }

    /* NOTIFIKASI */
    .sp-form-alert {
        margin-bottom: 20px;
        padding: 16px 20px;
        border-radius: 14px;
        font-size: 13px;
        line-height: 1.6;
        border: 1px solid;
    }

    .sp-alert-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .sp-form-alert p {
        margin: 0;
    }

    .sp-form-alert ul {
        margin: 6px 0 0;
        padding-left: 20px;
    }

    .sp-form-alert.success {
        border-color: #A7F3D0;
        background: #ECFDF5;
        color: #065F46;
    }

    .sp-form-alert.note {
        border-color: #FDE68A;
        background: #FFFBEB;
        color: #92400E;
        border-left: 4px solid #D97706;
    }

    .sp-form-alert.error {
        border-color: #FECACA;
        background: #FEF2F2;
        color: #991B1B;
    }

    /* FORM GRID & PANELS */
    .sp-prestasi-form {
        display: grid;
        gap: 20px;
    }

    .sp-form-panel {
        padding: 26px 30px;
        border: 1px solid var(--form-border);
        border-radius: 16px;
        background: #FFFFFF;
        box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
    }

    .sp-panel-heading {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #F1EBF7;
    }

    .sp-panel-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #DFD2ED;
        border-radius: 12px;
        background: #F4EFFB;
        color: var(--form-purple);
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .sp-panel-heading h2 {
        margin: 0 0 4px;
        font-family: 'Poppins', sans-serif;
        color: #241638;
        font-size: 17px;
        font-weight: 700;
    }

    .sp-panel-heading p {
        margin: 0;
        color: #7A6F8C;
        font-size: 12.5px;
        line-height: 1.5;
    }

    .sp-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 20px;
    }

    @media (max-width: 768px) {
        .sp-form-grid {
            grid-template-columns: 1fr;
        }
    }

    .sp-form-field {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 7px;
    }

    .sp-full-width {
        grid-column: 1 / -1;
    }

    .sp-form-field label {
        color: #4C3C63;
        font-size: 12.5px;
        font-weight: 700;
    }

    .sp-required {
        color: #DC2626;
        font-weight: 800;
    }

    .sp-optional {
        color: #8C809E;
        font-size: 11px;
        font-weight: 500;
    }

    .sp-form-field input:not([type="file"]),
    .sp-form-field select,
    .sp-form-field textarea {
        width: 100%;
        min-width: 0;
        border: 1px solid #E2D7ED;
        border-radius: 10px;
        outline: none;
        background: #FFFFFF;
        color: var(--form-text);
        font: inherit;
        font-size: 13px;
        transition: all .2s ease;
    }

    .sp-form-field input:not([type="file"]),
    .sp-form-field select {
        min-height: 46px;
        padding: 0 14px;
    }

    .sp-form-field textarea {
        min-height: 110px;
        padding: 12px 14px;
        line-height: 1.6;
        resize: vertical;
    }

    .sp-form-field input:focus,
    .sp-form-field select:focus,
    .sp-form-field textarea:focus {
        border-color: var(--form-purple);
        box-shadow: 0 0 0 3px rgba(91, 58, 142, 0.12);
        background: #FFFFFF;
    }

    .sp-form-field input::placeholder,
    .sp-form-field textarea::placeholder {
        color: #A396B2;
    }

    .sp-file-upload-box {
        border: 1.5px dashed #D4C3E8;
        border-radius: 10px;
        background: #FAF7FD;
        padding: 10px 14px;
        transition: all 0.2s ease;
    }

    .sp-file-upload-box:hover {
        border-color: var(--form-purple);
        background: #F4EEFB;
    }

    .sp-form-field input[type="file"] {
        width: 100%;
        color: #655874;
        font-size: 12px;
        outline: none;
    }

    .sp-form-field input[type="file"]::file-selector-button {
        margin-right: 12px;
        padding: 6px 14px;
        border: 1px solid #DFD2ED;
        border-radius: 7px;
        background: #FFFFFF;
        color: var(--form-purple);
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        transition: all 0.15s ease;
    }

    .sp-form-field input[type="file"]::file-selector-button:hover {
        background: var(--form-purple);
        color: #FFFFFF;
        border-color: var(--form-purple);
    }

    .sp-field-hint {
        color: #8C809E;
        font-size: 11.5px;
        line-height: 1.5;
    }

    .sp-field-hint a {
        color: var(--form-purple);
        font-weight: 700;
        text-decoration: underline;
    }

    .sp-field-error {
        color: #DC2626;
        font-size: 11.5px;
        font-weight: 600;
    }

    /* ANGGOTA TIM */
    .sp-team-list {
        display: grid;
        gap: 14px;
    }

    .sp-team-row {
        padding: 18px 20px;
        border: 1px solid #ECE4F4;
        border-radius: 12px;
        background: #FAF8FD;
    }

    .sp-team-row-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .sp-team-number {
        color: #2D1A47;
        font-size: 13px;
        font-weight: 700;
    }

    .sp-remove-member {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border: 1px solid #FCA5A5;
        border-radius: 7px;
        background: #FEF2F2;
        color: #B91C1C;
        cursor: pointer;
        font-size: 11.5px;
        font-weight: 700;
        transition: all 0.15s ease;
    }

    .sp-remove-member:hover {
        background: #FEE2E2;
        border-color: #F87171;
    }

    .sp-add-member {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 14px;
        padding: 9px 18px;
        border: 1px solid #DFD2ED;
        border-radius: 10px;
        background: #FAF7FD;
        color: var(--form-purple);
        cursor: pointer;
        font-size: 12.5px;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .sp-add-member:hover {
        background: #EDE4F8;
        border-color: var(--form-purple);
        transform: translateY(-1px);
    }

    /* INFORMASI HELPER */
    .sp-form-information {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 20px;
        border: 1px solid #E6DCF0;
        border-radius: 14px;
        background: #FBF9FD;
    }

    .sp-information-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #EDE4F8;
        color: var(--form-purple);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .sp-form-information strong {
        display: block;
        color: #26163B;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .sp-form-information p {
        margin: 0;
        color: #716484;
        font-size: 12.5px;
        line-height: 1.6;
    }

    /* TOMBOL AKSI */
    .sp-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 14px;
        margin-top: 8px;
    }

    .sp-button-cancel {
        display: inline-flex;
        align-items: center;
        padding: 11px 22px;
        border: 1px solid #DFD2ED;
        border-radius: 10px;
        background: #FFFFFF;
        color: #655874;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.15s ease;
    }

    .sp-button-cancel:hover {
        background: #F8F4FC;
        color: var(--form-purple);
        border-color: var(--form-purple);
    }

    .sp-button-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 26px;
        border: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, #5B3A8E 0%, #432765 100%);
        color: #FFFFFF;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(91, 58, 142, 0.25);
        transition: all 0.2s ease;
    }

    .sp-button-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(91, 58, 142, 0.35);
    }

    .sp-button-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

        /* MODERN FORM DIALOG (CONFIRM & ALERT) */
        .sp-dialog-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(36, 27, 49, 0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .sp-dialog-backdrop.active {
            display: flex;
            animation: spFadeIn .2s ease-out;
        }

        @keyframes spFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes spPopIn {
            from { opacity: 0; transform: scale(0.92) translateY(8px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .sp-dialog-card {
            background: #FFFFFF;
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            padding: 30px 26px 26px;
            box-shadow: 0 25px 50px -12px rgba(45, 27, 78, 0.35), 0 0 0 1px rgba(138, 99, 210, 0.15);
            text-align: center;
            animation: spPopIn .25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .sp-dialog-icon-wrap {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sp-dialog-icon-wrap.confirm {
            background: #F4EEFB;
            color: #8A63D2;
            box-shadow: 0 0 0 8px #FAF7FD;
        }

        .sp-dialog-icon-wrap.warning {
            background: #FFFBEB;
            color: #F59E0B;
            box-shadow: 0 0 0 8px #FEF3C7;
        }

        .sp-dialog-title {
            font-size: 19px;
            font-weight: 800;
            color: #2D1B4E;
            margin: 0 0 8px;
            letter-spacing: -0.3px;
        }

        .sp-dialog-message {
            font-size: 13.5px;
            color: #64748B;
            line-height: 1.55;
            margin: 0 0 22px;
        }

        .sp-dialog-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sp-btn-cancel {
            flex: 1;
            padding: 12px 18px;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s ease;
        }

        .sp-btn-cancel:hover {
            background: #E2E8F0;
            color: #1E293B;
        }

        .sp-btn-confirm {
            flex: 1.2;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-size: 13px;
            font-weight: 700;
            color: #FFFFFF;
            cursor: pointer;
            transition: all .15s ease;
            background: linear-gradient(135deg, #8A63D2, #6F42C1);
            box-shadow: 0 4px 14px rgba(111, 66, 193, 0.35);
        }

        .sp-btn-confirm:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .sp-btn-confirm.warning {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
        }
    </style>

{{-- CUSTOM FORM CONFIRM & ALERT MODAL --}}
<div class="sp-dialog-backdrop" id="spFormDialog" aria-hidden="true" style="display:none;">
    <div class="sp-dialog-card" role="alertdialog" aria-modal="true" aria-labelledby="spDialogTitle">
        <div class="sp-dialog-icon-wrap" id="spDialogIconWrap"></div>
        <div class="sp-dialog-content">
            <h4 class="sp-dialog-title" id="spDialogTitle">Konfirmasi</h4>
            <p class="sp-dialog-message" id="spDialogMessage">Pesan konfirmasi</p>
        </div>
        <div class="sp-dialog-actions" id="spDialogActions">
            <button type="button" class="sp-btn-cancel" id="spDialogBtnCancel" onclick="closeSpDialog()">Periksa Kembali</button>
            <button type="button" class="sp-btn-confirm" id="spDialogBtnConfirm">Lanjutkan</button>
        </div>
    </div>
</div>

<script>
(() => {
    const jenisPrestasi = document.getElementById('jenis_prestasi');
    const bagianTim = document.getElementById('bagianAnggotaTim');
    const daftarTim = document.getElementById('daftarAnggotaTim');
    const tambahAnggota = document.getElementById('tambahAnggotaTim');
    const form = document.getElementById('formPengajuanPrestasi');
    const tombolSubmit = document.getElementById('submitPengajuan');
    const sedangEdit = @json($isEditing);
    let sedangMengirim = false;

    function aturNomorAnggota() {
        daftarTim.querySelectorAll('.sp-team-row').forEach((row, index) => {
            const title = row.querySelector('.sp-team-number');
            const removeButton = row.querySelector('.sp-remove-member');
            if (title) title.textContent = 'Anggota ' + (index + 1);
            if (removeButton) removeButton.hidden = index === 0;
        });
    }

    function buatFieldAnggota(labelText, key, index, className, placeholder, maxLength) {
        const wrapper = document.createElement('div');
        wrapper.className = 'sp-form-field';
        const label = document.createElement('label');
        label.htmlFor = 'anggota_' + key + '_' + index;
        label.innerHTML = labelText + ' <span class="sp-required">*</span>';
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
        removeButton.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> <span>Hapus</span>';
        removeButton.addEventListener('click', () => {
            row.remove();
            rapikanNamaInput();
            aturNomorAnggota();
        });
        heading.append(title, removeButton);
        const grid = document.createElement('div');
        grid.className = 'sp-form-grid';
        grid.append(
            buatFieldAnggota('Nama Anggota', 'nama', index, 'sp-team-name', 'Nama lengkap anggota tim', 255),
            buatFieldAnggota('NIM/NIP Anggota', 'nim', index, 'sp-team-nim', 'Nomor induk mahasiswa / pegawai', 50)
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

    // DIALOG MODAL CONTROLLERS (NO NATIVE BROWSER POPUPS)
    const spDialog = document.getElementById('spFormDialog');
    const spIconWrap = document.getElementById('spDialogIconWrap');
    const spTitle = document.getElementById('spDialogTitle');
    const spMessage = document.getElementById('spDialogMessage');
    const spBtnCancel = document.getElementById('spDialogBtnCancel');
    const spBtnConfirm = document.getElementById('spDialogBtnConfirm');
    let spConfirmCallback = null;

    window.closeSpDialog = function() {
        if (!spDialog) return;
        spDialog.classList.remove('active');
        spDialog.style.display = 'none';
        spDialog.setAttribute('aria-hidden', 'true');
        spConfirmCallback = null;
    };

    if (spBtnConfirm) {
        spBtnConfirm.addEventListener('click', () => {
            if (typeof spConfirmCallback === 'function') {
                const cb = spConfirmCallback;
                closeSpDialog();
                cb();
            } else {
                closeSpDialog();
            }
        });
    }

    if (spDialog) {
        spDialog.addEventListener('click', (e) => {
            if (e.target === spDialog) closeSpDialog();
        });
    }

    function showFormAlert({ title, message, buttonText }) {
        if (!spDialog) return;
        spConfirmCallback = null;
        spIconWrap.className = 'sp-dialog-icon-wrap warning';
        spBtnConfirm.className = 'sp-btn-confirm warning';
        spBtnCancel.style.display = 'none';
        spIconWrap.innerHTML = '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
        spTitle.textContent = title;
        spMessage.textContent = message;
        spBtnConfirm.textContent = buttonText || 'Mengerti';
        spDialog.style.display = 'flex';
        void spDialog.offsetWidth;
        spDialog.classList.add('active');
        spDialog.setAttribute('aria-hidden', 'false');
    }

    function showFormConfirm({ title, message, confirmText, onConfirm }) {
        if (!spDialog) return;
        spConfirmCallback = onConfirm;
        spIconWrap.className = 'sp-dialog-icon-wrap confirm';
        spBtnConfirm.className = 'sp-btn-confirm';
        spBtnCancel.style.display = 'inline-block';
        spIconWrap.innerHTML = '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
        spTitle.textContent = title;
        spMessage.textContent = message;
        spBtnConfirm.textContent = confirmText || 'Ya, Kirim Sekarang';
        spDialog.style.display = 'flex';
        void spDialog.offsetWidth;
        spDialog.classList.add('active');
        spDialog.setAttribute('aria-hidden', 'false');
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
                        showFormAlert({
                            title: 'Ukuran Berkas Melebihi Batas',
                            message: `Berkas "${file.name}" berukuran ${sizeMb} MB. Batas maksimal yang diizinkan sistem adalah 2.00 MB. Silakan kompres atau pilih berkas lainnya.`,
                            buttonText: 'Mengerti & Pilih Ulang'
                        });
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

    let bypassConfirm = false;
    form.addEventListener('submit', (event) => {
        if (bypassConfirm) return;

        if (sedangMengirim) {
            event.preventDefault();
            return;
        }

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        event.preventDefault();

        const dialogTitleText = sedangEdit ? 'Perbarui Pengajuan Prestasi?' : 'Kirim Pengajuan Prestasi?';
        const dialogMsgText = sedangEdit
            ? 'Pastikan seluruh perubahan data dan berkas bukti prestasi sudah lengkap. Pengajuan yang diperbarui akan masuk kembali ke antrean verifikasi tim reviewer.'
            : 'Pastikan data kompetisi dan berkas lampiran bukti prestasi sudah sesuai. Setelah dikirim, pengajuan akan langsung masuk ke antrean verifikasi.';

        showFormConfirm({
            title: dialogTitleText,
            message: dialogMsgText,
            confirmText: sedangEdit ? 'Ya, Perbarui Sekarang' : 'Ya, Kirim Sekarang',
            onConfirm: () => {
                sedangMengirim = true;
                bypassConfirm = true;
                tombolSubmit.disabled = true;
                tombolSubmit.querySelector('.sp-submit-label').textContent = 'Mengirim pengajuan...';
                tombolSubmit.querySelector('.sp-submit-arrow').textContent = '→';
                form.submit();
            }
        });
    });
    rapikanNamaInput();
    aturNomorAnggota();
    aturBagianTim();
})();
</script>
@endsection
