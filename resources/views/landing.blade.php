@extends('layouts.landing')

@section('title', 'Beranda - SIPRESKA')

@section('content')

{{-- HERO SLIDER --}}
<section class="hero-slider">

    <div class="slide active">
        <img
            src="{{ asset('images/slider/slide1.png') }}"
            alt="Tiga mahasiswa UIN Siber Syekh Nurjati Cirebon menunjukkan medali Kejuaraan Kungfu Tradisional Indonesia 2026"
            fetchpriority="high"
            loading="eager"
        >
        <div class="slide-overlay">
            <div class="slide-content">
                <span class="eyebrow">SIPRESKA · UIN SIBER SYEKH NURJATI CIREBON</span>
                <h1>Prestasi Sivitas Akademika</h1>
                <p>Portal informasi dan dokumentasi prestasi mahasiswa serta dosen dalam satu sistem.</p>
                <a href="{{ route('prestasi.publik') }}" class="btn btn-primary">Lihat Prestasi</a>
            </div>
        </div>
    </div>

    <div class="slide">
        <img
            src="{{ asset('images/slider/slide2.jpg') }}"
            alt="Rezky Kurniawan meraih Juara 1 ganda putra di Piala Komandan Pussenif"
            loading="lazy"
        >
        <div class="slide-overlay">
            <div class="slide-content">
                <span class="eyebrow">APRESIASI PENCAPAIAN</span>
                <h1>Apresiasi Setiap Pencapaian</h1>
                <p>Jelajahi prestasi mahasiswa dan dosen yang telah tercatat di SIPRESKA.</p>
                <a href="{{ route('prestasi.publik') }}" class="btn btn-primary">Jelajahi Prestasi</a>
            </div>
        </div>
    </div>

    <div class="slide">
        <img
            src="{{ asset('images/slider/slide3.png') }}"
            alt="Syifa Nurlatifah menerima penghargaan dalam Perempuan Indonesia Creative Award 2026"
            loading="lazy"
        >
        <div class="slide-overlay">
            <div class="slide-content">
                <span class="eyebrow">DATA PRESTASI TERPUSAT</span>
                <h1>Bangga dengan Pencapaian Kampus</h1>
                <p>Informasi prestasi tersusun rapi untuk mendukung dokumentasi dan apresiasi sivitas akademika.</p>
                <a href="#statistik" class="btn btn-primary">Lihat Statistik</a>
            </div>
        </div>
    </div>

    <button class="slider-btn prev" type="button" onclick="changeSlide(-1)" aria-label="Slide sebelumnya">‹</button>
    <button class="slider-btn next" type="button" onclick="changeSlide(1)" aria-label="Slide berikutnya">›</button>
    <div id="sliderDots" class="slider-dots"></div>
</section>

{{-- STATISTIK --}}
<section class="section" id="statistik">

    <div class="section-heading center">
        <span class="eyebrow dark">STATISTIK SIPRESKA</span>
        <h2>Statistik Prestasi Sivitas Akademika</h2>
        <p>
            Statistik diperbarui berdasarkan data yang tercatat
            di dalam sistem.
        </p>
    </div>

    <div class="stats-grid">

        <div class="stat-box">
            <div class="stat-label">Total Prestasi</div>
            <div class="stat-value">
                {{ number_format($totalPrestasi ?? 0, 0, ',', '.') }}
            </div>
            <p class="stat-caption">Pencapaian yang tercatat di SIPRESKA</p>
        </div>

        <div class="stat-box">
            <div class="stat-label">Mahasiswa Berprestasi</div>
            <div class="stat-value">
                {{ number_format($totalPrestasiMahasiswa ?? 0, 0, ',', '.') }}
            </div>
            <p class="stat-caption">Prestasi yang melibatkan mahasiswa.</p>
        </div>

        <div class="stat-box">
            <div class="stat-label">Dosen Berprestasi</div>
            <div class="stat-value">
                {{ number_format($totalPrestasiDosen ?? 0, 0, ',', '.') }}
            </div>
            <p class="stat-caption">Prestasi yang melibatkan dosen.</p>
        </div>

    </div>
</section>


{{-- TINGKAT KOMPETISI --}}
<section class="section section-soft" id="tingkat-kompetisi">

    <div class="section-heading center">
        <span class="eyebrow dark">TINGKAT KOMPETISI</span>
        <h2>Prestasi Berdasarkan Tingkat</h2>
        <p>
            Jumlah pencapaian yang tercatat pada setiap
            tingkat kompetisi.
        </p>
    </div>

    <div class="competition-grid">

        @forelse ($statistikTingkat as $tingkat)

            <a href="{{ $tingkat['id'] ? route('tingkat-kompetisi.detail', $tingkat['id']) : route('tingkat-kompetisi') }}" class="competition-card">

                <div class="competition-body">
                    <h3>{{ $tingkat['nama'] }}</h3>

                    <p>
                        Pencapaian yang tercatat pada tingkat ini.
                    </p>

                    <strong>
                        {{ number_format($tingkat['total'], 0, ',', '.') }}
                        Prestasi
                    </strong>
                </div>

            </a>

        @empty

            <div class="empty-state">
                <p>
                    Belum ada pencapaian pada tingkat ini
                    untuk ditampilkan berdasarkan tingkat kompetisi.
                </p>
            </div>

        @endforelse

    </div>
</section>


{{-- KELOMPOK PRESTASI --}}
<section class="section group-showcase-section" id="kelompok-prestasi">
    <div class="group-showcase-heading">
        <div><span class="eyebrow dark">RAGAM PENCAPAIAN</span><h2>Jelajahi berdasarkan kelompok</h2></div>
    </div>
    <div class="group-showcase-grid">
        @foreach ($kategoriKompetisi as $kategori)
            <a class="group-showcase-card {{ (mb_strtolower($kategori->nama_kategori) === 'akademik' ? 'group-showcase-academic' : 'group-showcase-nonacademic') }}" href="{{ route('kelompok-kompetisi.detail', $kategori) }}">
                <span class="group-showcase-index">{{ mb_strtolower($kategori->nama_kategori) === 'akademik' ? '01' : '02' }}</span>
                <span class="group-showcase-copy">
                    <small>{{ mb_strtolower($kategori->nama_kategori) === 'akademik' ? 'RISET · ILMU · INOVASI' : 'SENI · OLAHRAGA · ORGANISASI' }}</small>
                    <strong>{{ $kategori->nama_kategori }}</strong>
                    <span>{{ number_format($kategori->total_prestasi, 0, ',', '.') }} prestasi tercatat <b aria-hidden="true">↗</b></span>
                </span>
            </a>
        @endforeach
    </div>
</section>
{{-- DOSEN BERPRESTASI --}}
<section class="section" id="dosen-berprestasi">

    <div class="section-heading center">
        <span class="eyebrow dark">APRESIASI DOSEN</span>
        <h2>Dosen Berprestasi</h2>
        <p>
            Daftar prestasi yang melibatkan dosen dan telah
            tercatat di SIPRESKA.
        </p>
    </div>

    <div class="recent-grid recent-grid-compact">

        @forelse ($prestasiDosen as $prestasi)

            @php
                $anggotaDosen = $prestasi->anggota->filter(function ($anggota) {
                    return data_get(
                        $anggota,
                        'sivitas.user.role'
                    ) === 'dosen';
                });
            @endphp

            <a href="{{ route('prestasi.publik.rincian', ['prestasi' => $prestasi, 'kembali' => request()->getRequestUri()]) }}" class="recent-card recent-card-link">
                @include('prestasi._bukti-foto', ['prestasi' => $prestasi])

                <span class="mini-badge">
                    {{ $prestasi->tingkat?->nama_tingkat
                        ?? $prestasi->tingkat?->nama
                        ?? $prestasi->tingkat?->tingkat
                        ?? 'Tingkat belum diisi' }}
                </span>

                <h3>{{ $prestasi->nama_prestasi }}</h3>

                <p>
                    @forelse ($anggotaDosen as $anggota)
                        {{ $anggota->nama ?? $anggota->sivitas?->nama ?? 'Nama dosen belum tersedia' }}@if (!$loop->last), @endif
                    @empty
                        Data dosen belum tersedia.
                    @endforelse
                </p>

                <small>
                    {{ $prestasi->kategori?->nama_kategori
                        ?? $prestasi->kategori?->nama
                        ?? 'Kategori belum diisi' }}
                    &bull;
                    Tahun {{ $prestasi->tahun ?: 'belum diisi' }}
                </small>

                @if ($prestasi->penyelenggara)
                    <p class="recent-organizer">
                        Penyelenggara: {{ $prestasi->penyelenggara }}
                    </p>
                @endif

                            <span class="recent-card-action">Lihat rincian <span aria-hidden="true">→</span></span>
            </a>

        @empty

            <div class="empty-state">
                <p>
                    Belum ada prestasi dosen yang tercatat
                    yang dapat ditampilkan.
                </p>
            </div>

        @endforelse

    </div>

    <div class="section-heading center recent-cta">
        <a href="{{ route('dosen-berprestasi') }}" class="btn btn-secondary">
            Lihat Semua Prestasi
        </a>
    </div>

</section>


{{-- MAHASISWA BERPRESTASI --}}
<section class="section section-soft" id="mahasiswa-berprestasi">

    <div class="section-heading center">
        <span class="eyebrow dark">APRESIASI MAHASISWA</span>
        <h2>Mahasiswa Berprestasi</h2>
        <p>
            Daftar prestasi yang melibatkan mahasiswa dan telah
            tercatat di SIPRESKA.
        </p>
    </div>

    <div class="recent-grid recent-grid-compact">

        @forelse ($prestasiMahasiswa as $prestasi)

            @php
                $anggotaMahasiswa = $prestasi->anggota->filter(function ($anggota) {
                    return data_get(
                        $anggota,
                        'sivitas.user.role'
                    ) === 'mahasiswa' || $anggota->peran === 'anggota';
                });
            @endphp

            <a href="{{ route('prestasi.publik.rincian', ['prestasi' => $prestasi, 'kembali' => request()->getRequestUri()]) }}" class="recent-card recent-card-link">
                @include('prestasi._bukti-foto', ['prestasi' => $prestasi])

                <span class="mini-badge">
                    {{ $prestasi->tingkat?->nama_tingkat
                        ?? $prestasi->tingkat?->nama
                        ?? $prestasi->tingkat?->tingkat
                        ?? 'Tingkat belum diisi' }}
                </span>

                <h3>{{ $prestasi->nama_prestasi }}</h3>

                <p>
                    @forelse ($anggotaMahasiswa as $anggota)
                        {{ $anggota->nama ?? $anggota->sivitas?->nama ?? 'Nama mahasiswa belum tersedia' }}@if (!$loop->last), @endif
                    @empty
                        Data mahasiswa belum tersedia.
                    @endforelse
                </p>

                <small>
                    {{ $prestasi->kategori?->nama_kategori
                        ?? $prestasi->kategori?->nama
                        ?? 'Kategori belum diisi' }}
                    &bull;
                    Tahun {{ $prestasi->tahun ?: 'belum diisi' }}
                </small>

                @if ($prestasi->penyelenggara)
                    <p class="recent-organizer">
                        Penyelenggara: {{ $prestasi->penyelenggara }}
                    </p>
                @endif

                            <span class="recent-card-action">Lihat rincian <span aria-hidden="true">→</span></span>
            </a>

        @empty

            <div class="empty-state">
                <p>
                    Belum ada prestasi mahasiswa yang tercatat
                    yang dapat ditampilkan.
                </p>
            </div>

        @endforelse

    </div>

    <div class="section-heading center recent-cta">
        <a href="{{ route('mahasiswa-berprestasi') }}" class="btn btn-secondary">
            Lihat Semua Prestasi
        </a>
    </div>

</section>


{{-- GRAFIK TAHUNAN --}}
<section class="section">

    <div class="section-heading center">
        <span class="eyebrow dark">GRAFIK PRESTASI</span>
        <h2>Perkembangan Prestasi</h2>
        <p>
            Perbandingan jumlah pencapaian yang tercatat berdasarkan tahun.
        </p>
    </div>

    <div class="chart-card">

        <div class="chart-legend">
            <span>
                <i class="legend-box nasional"></i>
                Jumlah Prestasi
            </span>
        </div>

        @if ($trenPrestasi->isNotEmpty())

            <div class="bar-chart">

            @php
                $maxRaw = max(1, (int) $jumlahMaksimalPrestasi);
                $step = (int) max(1, ceil($maxRaw / 4));
                $yAxisMax = $step * 4;
                $y4 = $yAxisMax;
                $y3 = $step * 3;
                $y2 = $step * 2;
                $y1 = $step * 1;
                $y0 = 0;
            @endphp
                <div class="chart-y-axis" title="Jumlah Prestasi">
                    <span>{{ $y4 }}</span>
                    <span>{{ $y3 }}</span>
                    <span>{{ $y2 }}</span>
                    <span>{{ $y1 }}</span>
                    <span>{{ $y0 }}</span>
                </div>

                <div class="chart-area">

                    <div class="chart-grid-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="bar-groups">

                        @foreach ($trenPrestasi as $item)

                            @php
                                $tinggiBar = min(100, max(6, ($item['total'] / $yAxisMax) * 100));
                            @endphp

                            <div class="bar-group">

                                <div
                                    class="bars"
                                    title="{{ $item['total'] }} prestasi pada tahun {{ $item['tahun'] }}"
                                >
                                    <div
                                        class="bar nasional"
                                        style="height: {{ max(5, $tinggiBar) }}%"
                                    ></div>
                                </div>

                                <span>{{ $item['tahun'] }}</span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <p class="chart-caption">
                Batang yang lebih tinggi menunjukkan lebih banyak pencapaian
                yang tercatat pada tahun tersebut.
            </p>

        @else

            <div class="empty-state">
                <p>
                    Grafik akan muncul setelah tersedia data pencapaian
                    dengan tahun perolehan.
                </p>
            </div>

        @endif

    </div>
</section>


{{-- PRESTASI TERBARU --}}
<section class="section section-soft">

    <div class="split-heading">

        <div class="section-heading">
            <span class="eyebrow dark">PRESTASI TERBARU</span>
            <h2>Pencapaian Sivitas Akademika</h2>
            <p>
                Pencapaian terbaru mahasiswa dan dosen yang tercatat
                di SIPRESKA.
            </p>
        </div>

        <a href="{{ route('prestasi.publik') }}" class="text-link">
            Lihat semua →
        </a>

    </div>

    <div class="recent-grid">

        @forelse ($prestasiUnggulan as $prestasi)

            <a href="{{ route('prestasi.publik.rincian', ['prestasi' => $prestasi, 'kembali' => request()->getRequestUri()]) }}" class="recent-card recent-card-link">
                @include('prestasi._bukti-foto', ['prestasi' => $prestasi])

                <span class="mini-badge">
                    {{ $prestasi->tingkat?->nama_tingkat
                        ?? $prestasi->tingkat?->nama
                        ?? $prestasi->tingkat?->tingkat
                        ?? 'Tingkat belum diisi' }}
                </span>

                <h3>{{ $prestasi->nama_prestasi }}</h3>

                <p>
                    @forelse ($prestasi->anggota as $anggota)
                        {{ $anggota->nama ?? $anggota->sivitas?->nama ?? 'Nama peserta belum tersedia' }}@if (!$loop->last), @endif
                    @empty
                        Data peserta belum tersedia.
                    @endforelse
                </p>

                <small>
                    {{ $prestasi->kategori?->nama_kategori
                        ?? $prestasi->kategori?->nama
                        ?? 'Kategori belum diisi' }}
                    &bull;
                    Tahun {{ $prestasi->tahun ?: 'belum diisi' }}
                </small>

                @if ($prestasi->penyelenggara)
                    <p class="recent-organizer">
                        Penyelenggara: {{ $prestasi->penyelenggara }}
                    </p>
                @endif

                            <span class="recent-card-action">Lihat rincian <span aria-hidden="true">→</span></span>
            </a>

        @empty

            <div class="empty-state">
                <p>
                    Belum ada prestasi yang tercatat.
                    Prestasi akan ditampilkan di sini setelah
                    tersedia di database.
                </p>

                <a href="{{ route('prestasi.publik') }}" class="btn btn-primary">
                    Buka Daftar Prestasi
                </a>
            </div>

        @endforelse

    </div>
</section>


@endsection
