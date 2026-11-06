@extends('layouts.landing')

@section('title', 'Tingkat Kompetisi - SIPRESKA')

@section('content')
<section class="section section-soft level-directory-section">
    <div class="level-directory-heading">
        <span class="eyebrow dark">TINGKAT KOMPETISI</span>
        <h1>Prestasi di setiap panggung</h1>
        <p>Pilih cakupan kompetisi untuk melihat sivitas yang berprestasi dan riwayat pencapaiannya.</p>
    </div>

    <div class="level-directory-grid">
        @forelse ($tingkats as $tingkat)
            <a href="{{ route('tingkat-kompetisi.detail', $tingkat) }}" class="level-directory-card">
                <span class="level-directory-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="level-directory-mark" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($tingkat->nama_tingkat, 0, 1)) }}</span>
                <span class="level-directory-content">
                    <small>TINGKAT {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</small>
                    <strong>{{ $tingkat->nama_tingkat }}</strong>
                    <span>{{ $tingkat->deskripsi ?: 'Lihat sivitas dan prestasi pada tingkat ini.' }}</span>
                    <em>{{ number_format($tingkat->total_prestasi, 0, ',', '.') }} prestasi <b aria-hidden="true">→</b></em>
                </span>
            </a>
        @empty
            <div class="empty-state">Belum ada tingkat kompetisi yang terdaftar.</div>
        @endforelse
    </div>
</section>
@endsection