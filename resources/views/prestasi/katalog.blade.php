
@extends('layouts.landing')

@section('title', $judul . ' - SIPRESKA')

@section('content')

<section class="section section-soft catalog-section">
    <div class="section-heading center">
        <span class="eyebrow dark">SIPRESKA</span>
        <h2>{{ $judul }}</h2>
        <p>{{ $deskripsi }}</p>
    </div>

    @if ($prestasis->isNotEmpty())
        <div class="catalog-table-wrap">
            <table class="catalog-table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Prestasi</th>
                        <th scope="col">Peserta</th>
                        <th scope="col">Tingkat</th>
                        <th scope="col">Kelompok</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestasis as $prestasi)
                        <tr>
                            <td class="catalog-number">{{ $loop->iteration }}</td>
                            <td class="catalog-name">{{ $prestasi->nama_prestasi }}</td>
                            <td>
                                @forelse ($prestasi->anggota as $anggota)
                                    {{ $anggota->nama ?? $anggota->sivitas?->nama ?? 'Nama belum tersedia' }}@if (!$loop->last), @endif
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>{{ $prestasi->tingkat?->nama_tingkat ?? '—' }}</td>
                            <td>{{ $prestasi->kategori?->nama_kategori ?? '—' }}</td>
                            <td>{{ $prestasi->tahun ?: '—' }}</td>
                            <td>
                                <a class="catalog-detail-link" href="{{ route('prestasi.publik.rincian', ['prestasi' => $prestasi, 'kembali' => request()->getRequestUri()]) }}">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state catalog-empty">
            <p>Belum ada data prestasi yang tersedia untuk halaman ini.</p>
        </div>
    @endif

    <div class="section-heading center catalog-back">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            Kembali ke Beranda
        </a>
    </div>
</section>

@endsection
