@extends('layouts.landing')

@section('title', $prestasi->nama_prestasi . ' - SIPRESKA')

@section('content')
@php
    $statusLabel = match ($prestasi->status) {
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'disetujui' => 'Disetujui',
        'perlu_perbaikan' => 'Perlu Perbaikan',
        'ditolak' => 'Ditolak',
        default => 'Dalam Proses',
    };
    $statusColor = match ($prestasi->status) {
        'disetujui' => ['bg' => '#D1FAE5', 'text' => '#065F46', 'border' => '#A7F3D0', 'dot' => '#059669'],
        'ditolak' => ['bg' => '#FEE2E2', 'text' => '#991B1B', 'border' => '#FECACA', 'dot' => '#DC2626'],
        'perlu_perbaikan' => ['bg' => '#FEF9C3', 'text' => '#854D0E', 'border' => '#FEF08A', 'dot' => '#CA8A04'],
        default => ['bg' => '#FEF3C7', 'text' => '#92400E', 'border' => '#FDE68A', 'dot' => '#D97706'],
    };
    $catatanTerbaru = $prestasi->verifikasi?->sortByDesc('tanggal_verifikasi')->first()?->catatan;
    $user = auth()->user();
    $canEdit = $user && in_array($user->role, ['mahasiswa', 'dosen'], true) && in_array($prestasi->status, ['ditolak', 'perlu_perbaikan'], true);
@endphp

<section class="section section-soft catalog-section public-profile-section achievement-detail-section">
    <div class="achievement-detail-shell">
        <a href="{{ $backUrl }}" class="public-profile-back">&larr; Kembali</a>

        <div class="achievement-detail-card">
            <header class="achievement-detail-header" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <span class="eyebrow dark">RINCIAN PENCAPAIAN</span>
                    <h1 style="margin: 8px 0 6px;">{{ $prestasi->nama_prestasi }}</h1>
                    <p style="margin: 0; color: #6B7280; font-size: 14px;">{{ $prestasi->penyelenggara ?: 'Informasi pencapaian sivitas akademika' }}</p>
                </div>
                <div style="flex-shrink: 0; padding-top: 4px;">
                    <span style="display: inline-flex; align-items: center; gap: 7px; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }}; border: 1px solid {{ $statusColor['border'] }}; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $statusColor['dot'] }};"></span>
                        {{ $statusLabel }}
                    </span>
                </div>
            </header>

            @if (!empty($catatanTerbaru) || $canEdit)
                <div style="margin: 16px 0 24px;">
                    @if (!empty($catatanTerbaru))
                        <div style="margin-bottom: 12px; padding: 14px 18px; border-radius: 12px; background: #FFFBEB; border: 1px solid #FDE68A; border-left: 4px solid #D97706;">
                            <strong style="display: block; font-size: 13px; color: #92400E; margin-bottom: 4px;">Catatan dari Verifikator Sistem</strong>
                            <p style="margin: 0; font-size: 13px; color: #78350F; line-height: 1.5;">{{ $catatanTerbaru }}</p>
                        </div>
                    @endif

                    @if ($canEdit)
                        <div>
                            <a href="{{ route('prestasi.edit', $prestasi) }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 10px; background: linear-gradient(135deg, #5B3A8E 0%, #432765 100%); color: #FFFFFF; text-decoration: none; font-size: 13px; font-weight: 700; box-shadow: 0 4px 12px rgba(91, 58, 142, 0.25);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                <span>Perbaiki & Ajukan Kembali</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <div class="achievement-detail-layout">
            <div class="achievement-detail-main">
                <section class="achievement-detail-block">
                    <div class="achievement-detail-block-heading"><div><h2>Informasi prestasi</h2><p>Ringkasan capaian yang tercatat di SIPRESKA.</p></div></div>
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
                    <div class="achievement-detail-block-heading"><div><h2>Peserta</h2><p>{{ $prestasi->anggota->count() }} sivitas terlibat dalam pencapaian ini.</p></div></div>
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
                        <div class="achievement-detail-block-heading"><div><h2>Tentang pencapaian</h2><p>Deskripsi singkat kegiatan atau hasil yang diraih.</p></div></div>
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