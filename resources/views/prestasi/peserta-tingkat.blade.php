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
                <article class="participant-card">
                    <!-- AVATAR DENGAN PIN MEDALI PERINGKAT MENYATU -->
                    <div class="participant-avatar-badge-wrap">
                        <div class="participant-card-avatar" aria-hidden="true">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($item['nama'], 0, 1)) }}
                        </div>
                        <span class="participant-rank-pin {{ $loop->iteration <= 3 ? 'rank-podium-' . $loop->iteration : '' }}" title="Peringkat {{ $loop->iteration }}">
                            {{ $loop->iteration }}
                        </span>
                    </div>

                    <div class="participant-card-main">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                            <span class="participant-card-role">{{ $item['jenis_sivitas'] ? ucfirst($item['jenis_sivitas']) : 'Sivitas Akademika' }}</span>
                            <span class="participant-rank-tag {{ $loop->iteration <= 3 ? 'tag-podium-' . $loop->iteration : '' }}">
                                #{{ $loop->iteration }}
                            </span>
                        </div>
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
/* Grid participant-card kembali ke 3 kolom asli yang proporsional dan leluasa */
.participant-directory {
    padding: 12px 24px !important;
}

.participant-card {
    display: grid !important;
    grid-template-columns: 56px minmax(0, 1fr) minmax(140px, auto) !important;
    align-items: center !important;
    gap: 20px !important;
    padding: 18px 24px !important;
}

/* Wrapper avatar & pin peringkat yang menyatu */
.participant-avatar-badge-wrap {
    position: relative;
    width: 52px;
    height: 52px;
    flex-shrink: 0;
}

.participant-card-avatar {
    width: 52px !important;
    height: 52px !important;
    border-radius: 14px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 20px !important;
    font-weight: 800 !important;
    background: linear-gradient(145deg, #FAF7FD, #F3EDF9) !important;
    border: 1.5px solid #E4D8F3 !important;
    color: #5B3A8E !important;
}

/* Pin medali di pojok avatar */
.participant-rank-pin {
    position: absolute;
    top: -7px;
    left: -7px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11.5px;
    font-weight: 800;
    color: #FFFFFF;
    background: #5B3A8E;
    border: 2px solid #FFFFFF;
    box-shadow: 0 3px 8px rgba(91, 58, 142, 0.25);
    z-index: 2;
}

.participant-rank-pin.rank-podium-1 {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%) !important;
    color: #4A3300 !important;
    border-color: #FFFFFF !important;
    box-shadow: 0 3px 10px rgba(230, 161, 0, 0.45) !important;
}

.participant-rank-pin.rank-podium-2 {
    background: linear-gradient(135deg, #E2E8F0 0%, #94A3B8 100%) !important;
    color: #1E293B !important;
    border-color: #FFFFFF !important;
    box-shadow: 0 3px 10px rgba(148, 163, 184, 0.4) !important;
}

.participant-rank-pin.rank-podium-3 {
    background: linear-gradient(135deg, #FFEDD5 0%, #FB923C 100%) !important;
    color: #7C2D12 !important;
    border-color: #FFFFFF !important;
    box-shadow: 0 3px 10px rgba(234, 88, 12, 0.4) !important;
}

/* Tag nomor kecil di samping tulisan MAHASISWA / DOSEN */
.participant-rank-tag {
    display: inline-flex;
    align-items: center;
    padding: 1px 7px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    color: #5B3A8E;
    background: #F3EDF9;
    border: 1px solid #E4D7F5;
}

.participant-rank-tag.tag-podium-1 {
    background: #FEF9C3;
    color: #854D0E;
    border-color: #FDE047;
}

.participant-rank-tag.tag-podium-2 {
    background: #F1F5F9;
    color: #334155;
    border-color: #CBD5E1;
}

.participant-rank-tag.tag-podium-3 {
    background: #FFEDD5;
    color: #9A3412;
    border-color: #FDBA74;
}

@media (max-width: 760px) {
    .participant-card {
        grid-template-columns: 46px minmax(0, 1fr) !important;
        padding: 14px 16px !important;
        gap: 14px !important;
    }
    .participant-avatar-badge-wrap {
        width: 44px;
        height: 44px;
    }
    .participant-card-avatar {
        width: 44px !important;
        height: 44px !important;
        font-size: 17px !important;
    }
    .participant-rank-pin {
        width: 21px;
        height: 21px;
        font-size: 10px;
        top: -5px;
        left: -5px;
    }
}
</style>
@endsection
