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
            <span aria-hidden="true" style="display:flex; justify-content:center; align-items:center; margin-bottom:4px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color:#A494B8;"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
            </span>
            <small>Foto prestasi belum tersedia</small>
        </div>
    @endif
</div>
