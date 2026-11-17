@extends('layouts.landing')

@section('title', $judul . ' - Peserta SIPRESKA')

@section('content')
<section class="section section-soft catalog-section participant-directory-section">
    <div class="section-heading center">
        <span class="eyebrow dark">{{ $label }}</span>
        <h1>{{ $judul }}</h1>
        <p>{{ $deskripsi }}</p>
    </div>

    @if ($peserta->isNotEmpty())
        <div class="participant-directory">
            @foreach ($peserta as $item)
                @php($anggota = $item['anggota'])
                <article class="participant-card participant-card-with-rank">
                    <div class="participant-card-rank {{ $loop->iteration <= 3 ? 'rank-podium-' . $loop->iteration : '' }}" title="Peringkat ke-{{ $loop->iteration }}">
                        {{ $loop->iteration }}
                    </div>
                    <div class="participant-card-avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($item['nama'], 0, 1)) }}</div>
                    <div class="participant-card-main">
                        <span class="participant-card-role">{{ $item['jenis_sivitas'] ? ucfirst($item['jenis_sivitas']) : 'Sivitas Akademika' }}</span>
                        <h2>{{ $item['nama'] }}</h2>
                        <p class="participant-card-meta">
                            @if ($item['program_studi'] && strtolower($item['program_studi']) !== 'belum diisi') <span>{{ $item['program_studi'] }}</span> @endif
                            @if ($item['fakultas'] && strtolower($item['fakultas']) !== 'belum diisi') <span>{{ $item['fakultas'] }}</span> @endif
                            @if (!$item['program_studi'] && !$item['fakultas']) <span>Informasi program studi belum tersedia</span> @endif
                        </p>
                    </div>
                    <div class="participant-card-side">
                        <strong>{{ $item['prestasis']->count() }}</strong>
                        <span>prestasi</span>
                        <a class="catalog-detail-link" href="{{ route('prestasi.peserta.profil', ['anggota' => $anggota, 'kembali' => request()->getRequestUri()]) }}">Lihat profil</a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="empty-state catalog-empty"><p>Belum ada peserta dengan prestasi pada kategori ini.</p></div>
    @endif

    <div class="section-heading center catalog-back">
        <a href="{{ $backRoute }}" class="btn btn-secondary">Kembali</a>
    </div>
</section>

<style>
.participant-card-with-rank {
    display: grid !important;
    grid-template-columns: 42px 48px minmax(0, 1fr) minmax(140px, auto) !important;
    align-items: center !important;
    gap: 16px !important;
}

.participant-card-rank {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: 800;
    color: #5B3A8E;
    background: #F3EDF9;
    border: 1.5px solid #E4D7F5;
    flex-shrink: 0;
    transition: transform 0.2s ease;
}

.participant-card:hover .participant-card-rank {
    transform: scale(1.06);
}

.participant-card-rank.rank-podium-1 {
    background: linear-gradient(135deg, #FFDF00 0%, #E6A100 100%) !important;
    color: #4A3300 !important;
    border-color: #D49B00 !important;
    box-shadow: 0 4px 14px rgba(230, 161, 0, 0.4) !important;
}

.participant-card-rank.rank-podium-2 {
    background: linear-gradient(135deg, #F1F5F9 0%, #CBD5E1 100%) !important;
    color: #1E293B !important;
    border-color: #94A3B8 !important;
    box-shadow: 0 4px 14px rgba(148, 163, 184, 0.35) !important;
}

.participant-card-rank.rank-podium-3 {
    background: linear-gradient(135deg, #FFEDD5 0%, #FB923C 100%) !important;
    color: #7C2D12 !important;
    border-color: #EA580C !important;
    box-shadow: 0 4px 14px rgba(234, 88, 12, 0.35) !important;
}

@media (max-width: 760px) {
    .participant-card-with-rank {
        grid-template-columns: 34px 42px minmax(0, 1fr) !important;
        gap: 10px !important;
    }
    .participant-card-rank {
        width: 34px;
        height: 34px;
        font-size: 13px;
        border-radius: 9px;
    }
}
</style>
@endsection
