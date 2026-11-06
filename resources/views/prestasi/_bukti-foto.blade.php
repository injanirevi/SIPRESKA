@php
    $fotoBukti = $prestasi->bukti->first(function ($bukti) {
        $extension = strtolower(
            pathinfo($bukti->file_path ?? '', PATHINFO_EXTENSION)
        );

        $jenisBukti = mb_strtolower(trim((string) ($bukti->jenis_bukti ?? '')));

        return $jenisBukti === 'dokumentasi'
            && in_array(
                $extension,
                ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'],
                true
            );
    });

    $fotoUrl = $fotoBukti
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($fotoBukti->file_path)
        : null;
@endphp

<div class="prestasi-photo">
    @if ($fotoUrl)
        <img
            src="{{ $fotoUrl }}"
            alt="Bukti foto {{ $prestasi->nama_prestasi }}"
            loading="lazy"
        >
    @else
        <div class="prestasi-photo-placeholder">
            <span aria-hidden="true">🏆</span>
            <small>Foto prestasi belum tersedia</small>
        </div>
    @endif
</div>
