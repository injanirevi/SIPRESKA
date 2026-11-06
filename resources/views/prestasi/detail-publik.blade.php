@extends('layouts.landing')

@section('title', ($profil?->nama ?? $anggotaProfil?->nama ?? $prestasi->nama_prestasi) . ' - SIPRESKA')

@section('content')
<section class="section section-soft catalog-section public-profile-section">
    <div class="public-profile-heading">
        <a href="{{ $backUrl ?? route('prestasi.publik') }}" class="public-profile-back">&larr; Kembali ke daftar</a>

        <div class="public-profile-card">
            <div class="public-profile-avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($profil?->nama ?? $anggotaProfil?->nama ?? $prestasi->nama_prestasi, 0, 1)) }}</div>
            <div class="public-profile-identity">
                <span class="eyebrow dark">PROFIL {{ strtoupper($profil?->jenis_sivitas ?? 'SIVITAS AKADEMIKA') }}</span>
                <h1>{{ $profil?->nama ?? $anggotaProfil?->nama ?? 'Peserta Prestasi' }}</h1>
                <div class="public-profile-meta">
                    @if ($nimNip ?? false) <span>{{ $nimNip }}</span> @endif
                    @if ($profil?->program_studi && strtolower($profil->program_studi) !== 'belum diisi') <span>{{ $profil->program_studi }}</span> @endif
                    @if ($profil?->fakultas && strtolower($profil->fakultas) !== 'belum diisi') <span>{{ $profil->fakultas }}</span> @endif
                </div>
            </div>
            <div class="public-profile-count"><strong>{{ $riwayatPrestasi->count() }}</strong><span>Prestasi tercatat</span></div>
        </div>
    </div>

    <div class="public-achievement-section">
        <div class="public-achievement-heading">
            <div><span class="eyebrow dark">RIWAYAT PENCAPAIAN</span><h2>Prestasi</h2></div>
            <p>Pilih prestasi untuk melihat rincian dan dokumen pendukung.</p>
        </div>

        <div class="public-achievement-list public-profile-achievements">
            @forelse ($riwayatPrestasi as $item)
                <article class="profile-achievement-row">
                    <div class="profile-achievement-year">{{ $item->tahun ?: '—' }}</div>
                    <div class="profile-achievement-copy">
                        <h3>{{ $item->nama_prestasi }}</h3>
                        <p class="public-achievement-tags">
                            <span class="achievement-tag achievement-tag-level">
                                <svg viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="6.25"/><path d="M1.9 8h12.2M8 1.75c1.55 1.7 2.3 3.78 2.3 6.25S9.55 12.55 8 14.25C6.45 12.55 5.7 10.47 5.7 8S6.45 3.45 8 1.75Z"/></svg>
                                {{ $item->tingkat?->nama_tingkat ?? 'Tingkat belum diisi' }}
                            </span>
                            <span class="achievement-tag achievement-tag-category">
                                @if (str_contains(strtolower($item->kategori?->nama_kategori ?? ''), 'akademik') && !str_contains(strtolower($item->kategori?->nama_kategori ?? ''), 'non'))
                                    <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M2 3.2c2.25-.7 4.25-.35 6 1v9c-1.75-1.35-3.75-1.7-6-1V3.2Zm12 0c-2.25-.7-4.25-.35-6 1v9c1.75-1.35 3.75-1.7 6-1V3.2Z"/><path d="M4 5.4c1-.15 1.85.02 2.6.5M4 7.5c1-.15 1.85.02 2.6.5m5.4-2.6c-1-.15-1.85.02-2.6.5m2.6 1.6c-1-.15-1.85.02-2.6.5"/></svg>
                                @else
                                    <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m8 1.5 1.6 4.1 4.4.25-3.4 2.8 1.1 4.3L8 10.6l-3.7 2.35 1.1-4.3L2 5.85l4.4-.25L8 1.5Z"/></svg>
                                @endif
                                {{ $item->kategori?->nama_kategori ?? 'Kategori belum diisi' }}
                            </span>
                            @if ($item->peringkat)
                                <span class="achievement-tag achievement-tag-rank">
                                    <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M5 2h6v2.2a3 3 0 0 1-6 0V2Zm0 1H2.5v1.1A3 3 0 0 0 5.3 7M11 3h2.5v1.1A3 3 0 0 1 10.7 7M8 7.2v3.1m-2.3 3.2h4.6M6.2 10.3h3.6v3.2H6.2z"/></svg>
                                    {{ $item->peringkat }}
                                </span>
                            @endif
                        </p>
                        @if ($item->penyelenggara)<p class="public-achievement-organizer">{{ $item->penyelenggara }}</p>@endif
                    </div>
                    <a class="profile-achievement-action" href="{{ route('prestasi.publik.rincian', ['prestasi' => $item, 'kembali' => request()->getRequestUri()]) }}">Lihat detail <span aria-hidden="true">&rarr;</span></a>
                </article>
            @empty
                <div class="empty-state catalog-empty"><p>Belum ada prestasi yang disetujui untuk peserta ini.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
