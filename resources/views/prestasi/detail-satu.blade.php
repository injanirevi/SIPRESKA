@extends('layouts.landing')

@section('title', $prestasi->nama_prestasi . ' - SIPRESKA')

@section('content')
<section class="section section-soft catalog-section public-profile-section achievement-detail-section">
    <div class="achievement-detail-shell">
        <a href="{{ $backUrl }}" class="public-profile-back">&larr; Kembali</a>

        <div class="achievement-detail-card">
            <header class="achievement-detail-header">
                <div>
                    <span class="eyebrow dark">RINCIAN PENCAPAIAN</span>
                    <h1>{{ $prestasi->nama_prestasi }}</h1>
                    <p>{{ $prestasi->penyelenggara ?: 'Informasi pencapaian sivitas akademika' }}</p>
                </div>
            </header>

            <div class="achievement-detail-layout">
            <div class="achievement-detail-main">
                <section class="achievement-detail-block">
                    <div class="achievement-detail-block-heading"><span>01</span><div><h2>Informasi prestasi</h2><p>Ringkasan capaian yang tercatat di SIPRESKA.</p></div></div>
                    <dl class="achievement-detail-facts">
                        <div><dt>Tahun perolehan</dt><dd>{{ $prestasi->tahun ?: '—' }}</dd></div>
                        <div><dt>Tingkat kompetisi</dt><dd>{{ $prestasi->tingkat?->nama_tingkat ?? 'Belum diisi' }}</dd></div>
                        <div><dt>Kelompok</dt><dd>{{ $prestasi->kategori?->nama_kategori ?? 'Belum diisi' }}</dd></div>
                        <div><dt>Peringkat</dt><dd>{{ $prestasi->peringkat ?: 'Tidak dicantumkan' }}</dd></div>
                        <div><dt>Jenis keikutsertaan</dt><dd>{{ $prestasi->jenis_prestasi === 'tim' ? 'Tim' : 'Individu' }}</dd></div>
                        <div class="achievement-detail-fact-wide"><dt>Penyelenggara</dt><dd>{{ $prestasi->penyelenggara ?: 'Belum dicantumkan' }}</dd></div>
                    </dl>
                </section>

                <section class="achievement-detail-block">
                    <div class="achievement-detail-block-heading"><span>02</span><div><h2>Peserta</h2><p>{{ $prestasi->anggota->count() }} sivitas terlibat dalam pencapaian ini.</p></div></div>
                    <div class="achievement-participant-list">
                        @forelse ($prestasi->anggota as $anggota)
                            <div class="achievement-participant"><span class="achievement-participant-avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($anggota->nama ?? $anggota->sivitas?->nama ?? '?', 0, 1)) }}</span><div><strong>{{ $anggota->nama ?? $anggota->sivitas?->nama ?? 'Nama belum tersedia' }}</strong><span>{{ $anggota->peran === 'pengaju' ? 'Pengaju' : ($anggota->peran ?: 'Peserta') }}</span></div></div>
                        @empty
                            <p class="achievement-detail-empty">Informasi peserta belum tersedia.</p>
                        @endforelse
                    </div>
                </section>

                @if ($prestasi->deskripsi)
                    <section class="achievement-detail-block achievement-description-block">
                        <div class="achievement-detail-block-heading"><span>03</span><div><h2>Tentang pencapaian</h2><p>Deskripsi singkat kegiatan atau hasil yang diraih.</p></div></div>
                        <p>{{ $prestasi->deskripsi }}</p>
                    </section>
                @endif
            </div>

            <aside class="achievement-evidence-panel">
                <div class="achievement-evidence-heading"><span class="eyebrow dark">DOKUMEN PENDUKUNG</span><h2>Bukti prestasi</h2><p>Dokumen yang diunggah sebagai pendukung pencapaian.</p></div>
                @if ($prestasi->bukti->isNotEmpty())
                    <div class="achievement-evidence-grid">
                        @foreach ($prestasi->bukti as $bukti)
                            @php
                                $extension = strtolower(pathinfo($bukti->file_path, PATHINFO_EXTENSION));
                                $fileUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($bukti->file_path);
                            @endphp
                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif']))
                                <a class="achievement-evidence-image" href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"><img src="{{ $fileUrl }}" alt="Bukti {{ $bukti->nama_file ?: $prestasi->nama_prestasi }}" loading="lazy"><span>{{ $bukti->nama_file ?: 'Lihat gambar' }}</span></a>
                            @else
                                <a class="achievement-evidence-file" href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"><span class="achievement-file-icon">{{ strtoupper($extension ?: 'FILE') }}</span><span><strong>{{ $bukti->nama_file ?: 'Dokumen pendukung' }}</strong><small>Buka dokumen</small></span><b aria-hidden="true">↗</b></a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="achievement-evidence-empty"><span aria-hidden="true">＋</span><p>Belum ada dokumen pendukung yang diunggah.</p></div>
                @endif
            </aside>
            </div>
        </div>
    </div>
</section>
@endsection
