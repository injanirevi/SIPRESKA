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
                        <span>{{ $item['prestasis']->count() === 1 ? 'prestasi' : 'prestasi' }}</span>
                        <a class="catalog-detail-link" href="{{ route('prestasi.peserta.profil', ['anggota' => $anggota, 'kembali' => request()->getRequestUri()]) }}">Lihat profil</a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="empty-state catalog-empty"><p>Belum ada peserta dengan prestasi pada tingkat ini.</p></div>
    @endif

    <div class="section-heading center catalog-back">
        <a href="{{ $backRoute }}" class="btn btn-secondary">Kembali</a>
    </div>
</section>
@endsection