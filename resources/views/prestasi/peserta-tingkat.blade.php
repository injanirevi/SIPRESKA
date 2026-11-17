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
                    <!-- NOMOR BIASA TANPA KOTAK (1, 2, 3, dst) -->
                    <span class="participant-rank-plain {{ $loop->iteration <= 3 ? 'rank-podium-' . $loop->iteration : '' }}">
                        {{ $loop->iteration }}
                    </span>

                    <!-- AVATAR ASLI SEMULA -->
                    <div class="participant-card-avatar" aria-hidden="true">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($item['nama'], 0, 1)) }}
                    </div>

                    <!-- DATA MAHASISWA / DOSEN -->
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

                    <!-- JUMLAH PRESTASI -->
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
/* Kembalikan ukuran kontainer tabel seperti semula dari CSS asli (tidak mengecil) */
.participant-card.participant-card-ranked {
    display: grid !important;
    grid-template-columns: 28px 48px minmax(0, 1fr) minmax(130px, auto) !important;
    align-items: center !important;
    gap: 16px !important;
    padding: 16px 20px !important;
}

/* Nomor biasa polos tanpa kotak, bersih & elegan */
.participant-rank-plain {
    font-size: 21px;
    font-weight: 800;
    color: #5B3A8E;
    text-align: center;
    line-height: 1;
    display: block;
    user-select: none;
}

.participant-rank-plain.rank-podium-1 {
    color: #D97706 !important;
}

.participant-rank-plain.rank-podium-2 {
    color: #475569 !important;
}

.participant-rank-plain.rank-podium-3 {
    color: #B45309 !important;
}

@media (max-width: 760px) {
    .participant-card.participant-card-ranked {
        grid-template-columns: 24px 42px minmax(0, 1fr) !important;
        gap: 12px !important;
        padding: 14px 10px !important;
    }
    .participant-rank-plain {
        font-size: 17px;
    }
}
</style>
@endsection
