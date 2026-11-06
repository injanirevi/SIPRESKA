@extends('layouts.landing')

@section('title', 'Kelompok Kompetisi - SIPRESKA')

@section('content')
<section class="section section-soft group-page-section">
    <div class="group-page-hero">
        <span class="eyebrow dark">KOMPETISI & PENCAPAIAN</span>
        <h1>Prestasi berdasarkan kelompok</h1>
        <p>Temukan pencapaian akademik dan nonakademik sivitas UIN Siber Syekh Nurjati Cirebon.</p>
    </div>

    <div class="group-category-grid">
        @forelse ($kategoris as $kategori)
            @php($isAkademik = mb_strtolower($kategori->nama_kategori) === 'akademik')
            <a class="group-category-card {{ $isAkademik ? 'group-category-academic' : 'group-category-nonacademic' }}" href="{{ route('kelompok-kompetisi.detail', $kategori) }}">
                <div class="group-category-topline"><span>{{ $isAkademik ? '01 / AKADEMIK' : '02 / NONAKADEMIK' }}</span><span aria-hidden="true">↗</span></div>
                <div class="group-category-copy">
                    <span>{{ $isAkademik ? 'Pengetahuan dan karya ilmiah' : 'Kreativitas dan kontribusi' }}</span>
                    <h2>{{ $kategori->nama_kategori }}</h2>
                    <p>{{ $kategori->deskripsi ?: ($isAkademik ? 'Riset, inovasi, publikasi, dan capaian pembelajaran.' : 'Seni, olahraga, organisasi, dan kontribusi kemasyarakatan.') }}</p>
                    <strong>{{ number_format($kategori->total_prestasi, 0, ',', '.') }} <small>prestasi tercatat</small></strong>
                </div>
                <span class="group-category-link">Jelajahi kelompok <b aria-hidden="true">→</b></span>
            </a>
        @empty
            <div class="empty-state">Kategori prestasi belum tersedia.</div>
        @endforelse
    </div>
</section>
@endsection
