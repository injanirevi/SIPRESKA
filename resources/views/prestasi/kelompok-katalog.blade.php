@extends('layouts.landing')

@section('title', $judul . ' - SIPRESKA')

@section('content')
<section class="section section-soft group-results-section">
    <div class="group-results-hero">
        <a href="{{ $backRoute ?? url('/') }}" class="public-profile-back">&larr; Kembali</a>
        <span class="eyebrow dark">{{ $label ?? 'KELOMPOK PRESTASI' }}</span>
        <div class="group-results-title-row"><div class="group-results-title-copy"><h1>
            @if (($label ?? '') === 'TINGKAT KOMPETISI')
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>
            @elseif (\Illuminate\Support\Str::contains(\Illuminate\Support\Str::lower($judul), 'akademik') && !\Illuminate\Support\Str::contains(\Illuminate\Support\Str::lower($judul), 'non'))
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 7 9-4 9 4-9 4-9-4Z"/><path d="M5 9v6c4 3 10 3 14 0V9M21 7v7"/></svg>
            @else
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"/></svg>
            @endif
            {{ $judul }}
        </h1><p>{{ $deskripsi }}</p></div><div class="group-results-total"><strong>{{ $prestasis->count() }}</strong><span>prestasi tercatat</span></div></div>
    </div>

    @if ($prestasis->isNotEmpty())
        <div class="group-results-search">
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/></svg>
            <input id="groupResultSearch" type="search" placeholder="Cari nama prestasi atau peserta..." aria-label="Cari nama prestasi atau peserta" autocomplete="off">
        </div>
        <div class="group-results-list">
            @foreach ($prestasis as $prestasi)
                <a class="group-result-row" href="{{ route('prestasi.publik.rincian', ['prestasi' => $prestasi, 'kembali' => request()->getRequestUri()]) }}">
                    <span class="group-result-year">{{ $prestasi->tahun ?: '—' }}</span>
                    <span class="group-result-copy"><strong>{{ $prestasi->nama_prestasi }}</strong><span>
                        @forelse ($prestasi->anggota as $anggota)
                            {{ $anggota->nama ?? $anggota->sivitas?->nama ?? 'Nama belum tersedia' }}@if (!$loop->last), @endif
                        @empty
                            Peserta belum dicantumkan
                        @endforelse
                    </span></span>
                    <span class="group-result-tags">
                        <i class="group-result-tag-level"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>{{ $prestasi->tingkat?->nama_tingkat ?? 'Tingkat belum diisi' }}</i>
                        @if ($prestasi->peringkat)<i class="group-result-tag-rank"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"/><path d="M8 6H5v2a4 4 0 0 0 4 4M16 6h3v2a4 4 0 0 1-4 4M12 13v4m-4 3h8m-7 0v-3h6v3"/></svg>{{ $prestasi->peringkat }}</i>@endif
                    </span>
                    <span class="group-result-open">Lihat detail <b aria-hidden="true">↗</b></span>
                </a>
            @endforeach
        </div>
        <p class="group-results-no-match" id="groupResultNoMatch" hidden>Tidak ada prestasi yang cocok dengan pencarian.</p>
    @else
        <div class="empty-state group-results-empty"><p>{{ $emptyMessage ?? 'Belum ada prestasi yang disetujui pada kelompok ini.' }}</p></div>
    @endif
</section>

@if ($prestasis->isNotEmpty())
<script>
    (() => {
        const input = document.getElementById('groupResultSearch');
        const rows = [...document.querySelectorAll('.group-result-row')];
        const emptyMessage = document.getElementById('groupResultNoMatch');

        input?.addEventListener('input', () => {
            const query = input.value.trim().toLocaleLowerCase('id');
            let visibleRows = 0;

            rows.forEach((row) => {
                const matches = row.textContent.toLocaleLowerCase('id').includes(query);
                row.hidden = !matches;
                if (matches) visibleRows += 1;
            });

            emptyMessage.hidden = visibleRows > 0;
        });
    })();
</script>
@endif
@endsection
