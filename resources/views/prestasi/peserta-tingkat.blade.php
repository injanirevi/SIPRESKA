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
                <article class="participant-card participant-card-ranked">
                    <!-- NOMOR PERINGKAT DI PINGGIR KIRI (ALA SS KE-2) -->
                    <div class="participant-rank-box {{ $loop->iteration <= 3 ? 'rank-podium-' . $loop->iteration : '' }}" title="Peringkat {{ $loop->iteration }}">
                        {{ $loop->iteration }}
                    </div>

                    <!-- AVATAR INISIAL BERSIH -->
                    <div class="participant-card-avatar" aria-hidden="true">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($item['nama'], 0, 1)) }}
                    </div>

                    <!-- INFORMASI PESERTA -->
                    <div class="participant-card-main">
                        <span class="participant-card-role">{{ $item['jenis_sivitas'] ? ucfirst($item['jenis_sivitas']) : 'Sivitas Akademika' }}</span>
                        <h2>{{ $item['nama'] }}</h2>
                        <p class="participant-card-meta">
                            @if (!empty($item['nim'])) <span><strong>NIM/NIP:</strong> {{ $item['nim'] }}</span> @endif
                            @if ($item['program_studi'] && strtolower($item['program_studi']) !== 'belum diisi') <span>{{ $item['program_studi'] }}</span> @endif
                            @if ($item['fakultas'] && strtolower($item['fakultas']) !== 'belum diisi') <span>{{ $item['fakultas'] }}</span> @endif
                            @if (!$item['program_studi'] && !$item['fakultas']) <span>Informasi program studi belum tersedia</span> @endif
                        </p>
                    </div>

                    <!-- JUMLAH PRESTASI & LINK PROFIL -->
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
/* Kontainer direktori dengan padding dalam yang lega */
.participant-directory {
    width: min(92%, 1160px) !important;
    margin-inline: auto !important;
    padding: 12px 24px !important;
    border-radius: 20px !important;
}

/* Kartu baris peserta dengan 4 kolom proporsional (Nomor | Avatar | Info | Aksi) */
.participant-card.participant-card-ranked {
    display: grid !important;
    grid-template-columns: 46px 48px minmax(0, 1fr) minmax(130px, auto) !important;
    align-items: center !important;
    gap: 18px !important;
    padding: 16px 20px !important;
}

/* Kotak nomor peringkat di pinggir kiri (ala SS ke-2 tapi proporsional dan tidak mepet) */
.participant-rank-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
    color: #5B3A8E;
    background: #F3EDF9;
    border: 1.5px solid #E4D7F5;
    flex-shrink: 0;
    transition: transform 0.18s ease;
}

.participant-card:hover .participant-rank-box {
    transform: scale(1.05);
}

/* Warna podium 1, 2, 3 yang cerah dan elegan */
.participant-rank-box.rank-podium-1 {
    background: linear-gradient(135deg, #FFDF00 0%, #F59E0B 100%) !important;
    color: #452200 !important;
    border-color: #D97706 !important;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35) !important;
}

.participant-rank-box.rank-podium-2 {
    background: linear-gradient(135deg, #F1F5F9 0%, #CBD5E1 100%) !important;
    color: #1E293B !important;
    border-color: #94A3B8 !important;
    box-shadow: 0 4px 12px rgba(148, 163, 184, 0.3) !important;
}

.participant-rank-box.rank-podium-3 {
    background: linear-gradient(135deg, #FFEDD5 0%, #FB923C 100%) !important;
    color: #7C2D12 !important;
    border-color: #EA580C !important;
    box-shadow: 0 4px 12px rgba(251, 146, 60, 0.3) !important;
}

/* Avatar inisial */
.participant-card-avatar {
    width: 48px !important;
    height: 48px !important;
    border-radius: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 18px !important;
    font-weight: 750 !important;
    background: linear-gradient(145deg, #FAF7FD, #F3EDF9) !important;
    border: 1px solid #E6D8EF !important;
    color: #5B3A8E !important;
    flex-shrink: 0 !important;
}

.participant-card-role {
    display: inline-block;
    color: var(--muted);
    font-size: 11px;
    font-weight: 750;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.participant-card-main h2 {
    margin: 3px 0 5px;
    color: var(--purple-dark);
    font-size: 18px;
}

.participant-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin: 0;
    color: var(--muted);
    font-size: 13px;
}

.participant-card-meta span + span::before {
    content: '·';
    margin-right: 7px;
    color: #C8B8DA;
}

@media (max-width: 760px) {
    .participant-directory {
        padding: 8px 12px !important;
    }
    .participant-card.participant-card-ranked {
        grid-template-columns: 36px 42px minmax(0, 1fr) !important;
        gap: 12px !important;
        padding: 14px 10px !important;
    }
    .participant-rank-box {
        width: 36px;
        height: 36px;
        font-size: 14px;
        border-radius: 10px;
    }
    .participant-card-avatar {
        width: 40px !important;
        height: 40px !important;
        font-size: 16px !important;
    }
}
</style>
@endsection
