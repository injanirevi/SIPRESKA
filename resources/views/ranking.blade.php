@extends('layouts.landing')

@section('title', 'Ranking Fakultas dan Program Studi - SIPRESKA')

@section('content')
<section class="section section-soft">
    <div class="section-heading center">
        <span class="eyebrow dark">RANKING SIPRESKA</span>
        <h2>Prestasi Fakultas dan Program Studi</h2>
        <p>Peringkat dihitung dari jumlah prestasi mahasiswa yang telah disetujui dan tercatat di SIPRESKA.</p>
    </div>

    <form class="ranking-search" action="{{ route('ranking') }}" method="GET" role="search">
        <label class="sr-only" for="ranking-search-input">Cari fakultas atau program studi</label>
        <input
            id="ranking-search-input"
            type="search"
            name="q"
            value="{{ $kataKunci }}"
            placeholder="Cari nama fakultas atau program studi..."
        >
        <button type="submit">Cari</button>
        @if ($kataKunci !== '')
            <a class="ranking-search-reset" href="{{ route('ranking') }}">Reset</a>
        @endif
    </form>

    <div class="ranking-grid">
        <section class="ranking-panel" aria-labelledby="ranking-fakultas-title">
            <h3 id="ranking-fakultas-title">Ranking Fakultas</h3>
            <ol class="ranking-list">
                @forelse ($rankingFakultas as $item)
                    <li>
                        <span class="ranking-position">{{ $loop->iteration }}</span>
                        <span class="ranking-name">{{ $item['nama'] }}</span>
                        <span class="ranking-total">{{ $item['total'] }} prestasi</span>
                    </li>
                @empty
                    <li class="ranking-empty">{{ $kataKunci !== '' ? 'Fakultas tidak ditemukan.' : 'Belum ada data fakultas untuk ditampilkan.' }}</li>
                @endforelse
            </ol>
        </section>

        <section class="ranking-panel" aria-labelledby="ranking-prodi-title">
            <h3 id="ranking-prodi-title">Ranking Program Studi</h3>
            <ol class="ranking-list">
                @forelse ($rankingProgramStudi as $item)
                    <li>
                        <span class="ranking-position">{{ $loop->iteration }}</span>
                        <span class="ranking-name">
                            {{ $item['nama'] }}
                            <small>{{ $item['fakultas'] }}</small>
                        </span>
                        <span class="ranking-total">{{ $item['total'] }} prestasi</span>
                    </li>
                @empty
                    <li class="ranking-empty">{{ $kataKunci !== '' ? 'Program studi tidak ditemukan.' : 'Belum ada data program studi untuk ditampilkan.' }}</li>
                @endforelse
            </ol>
        </section>
    </div>
</section>
@endsection
