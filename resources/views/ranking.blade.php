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
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <h3 id="ranking-fakultas-title" style="margin: 0;">Ranking Fakultas</h3>
                <span style="font-size: 11.5px; color: #8A63D2; font-weight: 600;">Klik untuk rincian</span>
            </div>
            <ol class="ranking-list">
                @forelse ($rankingFakultas as $item)
                    <li class="ranking-interactive-item"
                        onclick="openRankingModal(this)"
                        onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openRankingModal(this);}"
                        tabindex="0"
                        role="button"
                        aria-haspopup="dialog"
                        data-nama="{{ $item['nama'] }}"
                        data-jenis="Fakultas"
                        data-sub="UIN Siber Syekh Nurjati Cirebon"
                        data-total="{{ $item['total'] }}"
                        data-prestasi="{{ json_encode($item['prestasi'] ?? []) }}"
                        title="Klik untuk melihat daftar prestasi {{ $item['nama'] }}"
                    >
                        <span class="ranking-position {{ $loop->iteration <= 3 ? 'rank-top' : '' }}">{{ $loop->iteration }}</span>
                        <span class="ranking-name">
                            <strong>{{ $item['nama'] }}</strong>
                            <span class="ranking-click-guide">Buka daftar capaian &rarr;</span>
                        </span>
                        <div class="ranking-total-badge">
                            <span class="ranking-total">{{ $item['total'] }} prestasi</span>
                            <svg class="ranking-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </li>
                @empty
                    <li class="ranking-empty">{{ $kataKunci !== '' ? 'Fakultas tidak ditemukan.' : 'Belum ada data fakultas untuk ditampilkan.' }}</li>
                @endforelse
            </ol>
        </section>

        <section class="ranking-panel" aria-labelledby="ranking-prodi-title">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <h3 id="ranking-prodi-title" style="margin: 0;">Ranking Program Studi</h3>
                <span style="font-size: 11.5px; color: #8A63D2; font-weight: 600;">Klik untuk rincian</span>
            </div>
            <ol class="ranking-list">
                @forelse ($rankingProgramStudi as $item)
                    <li class="ranking-interactive-item"
                        onclick="openRankingModal(this)"
                        onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openRankingModal(this);}"
                        tabindex="0"
                        role="button"
                        aria-haspopup="dialog"
                        data-nama="{{ $item['nama'] }}"
                        data-jenis="Program Studi"
                        data-sub="{{ $item['fakultas'] }}"
                        data-total="{{ $item['total'] }}"
                        data-prestasi="{{ json_encode($item['prestasi'] ?? []) }}"
                        title="Klik untuk melihat daftar prestasi {{ $item['nama'] }}"
                    >
                        <span class="ranking-position {{ $loop->iteration <= 3 ? 'rank-top' : '' }}">{{ $loop->iteration }}</span>
                        <span class="ranking-name">
                            <strong>{{ $item['nama'] }}</strong>
                            <small>{{ $item['fakultas'] }}</small>
                            <span class="ranking-click-guide">Buka daftar capaian &rarr;</span>
                        </span>
                        <div class="ranking-total-badge">
                            <span class="ranking-total">{{ $item['total'] }} prestasi</span>
                            <svg class="ranking-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </li>
                @empty
                    <li class="ranking-empty">{{ $kataKunci !== '' ? 'Program studi tidak ditemukan.' : 'Belum ada data program studi untuk ditampilkan.' }}</li>
                @endforelse
            </ol>
        </section>
    </div>
</section>

<!-- MODAL POPUP DAFTAR PRESTASI RANKING -->
<div id="rankingModal" class="ranking-modal-backdrop" onclick="handleRankingBackdropClick(event)" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="ranking-modal-dialog">
        <header class="ranking-modal-header">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <span id="rankingModalJenis" class="ranking-modal-badge-type">Fakultas</span>
                    <span id="rankingModalTotal" class="ranking-modal-badge-count">0 Prestasi Disetujui</span>
                </div>
                <h3 id="rankingModalTitle" class="ranking-modal-title">Nama Fakultas/Prodi</h3>
                <p id="rankingModalSub" class="ranking-modal-sub">Sub Keterangan</p>
            </div>
            <button type="button" class="ranking-modal-close" onclick="closeRankingModal()" aria-label="Tutup dialog">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </header>

        <div id="rankingModalBody" class="ranking-modal-body">
            <!-- Items rendered via JavaScript -->
        </div>

        <footer class="ranking-modal-footer">
            <span style="font-size: 12px; color: #6B7280;">Menampilkan data capaian terverifikasi resmi</span>
            <button type="button" class="ranking-modal-btn-close" onclick="closeRankingModal()">Tutup</button>
        </footer>
    </div>
</div>

<style>
/* Ranking Interactive Items */
.ranking-interactive-item {
    cursor: pointer !important;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative;
    user-select: none;
}
.ranking-interactive-item:hover,
.ranking-interactive-item:focus-visible {
    border-color: #8A63D2 !important;
    background: #FAF7FD !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(91, 58, 142, 0.12) !important;
    outline: none;
}
.ranking-position.rank-top {
    background: linear-gradient(135deg, #5B3A8E 0%, #2D1B4E 100%) !important;
    color: #FFFFFF !important;
    font-weight: 800 !important;
    box-shadow: 0 2px 6px rgba(45, 27, 78, 0.2);
}
.ranking-click-guide {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #8A63D2;
    margin-top: 3px;
    opacity: 0.85;
}
.ranking-total-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-left: auto;
    flex-shrink: 0;
}
.ranking-chevron {
    color: #8A63D2;
    transition: transform 0.2s ease;
}
.ranking-interactive-item:hover .ranking-chevron {
    transform: translateX(3px);
    color: #5B3A8E;
}

/* Modal Backdrop */
.ranking-modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    opacity: 0;
    transition: opacity 0.22s ease;
}
.ranking-modal-backdrop.is-open {
    display: flex;
    opacity: 1;
}

/* Modal Dialog */
.ranking-modal-dialog {
    width: 100%;
    max-width: 840px;
    max-height: 88vh;
    display: flex;
    flex-direction: column;
    background: #FFFFFF;
    border-radius: 20px;
    border: 1px solid rgba(138, 99, 210, 0.2);
    box-shadow: 0 25px 60px -15px rgba(45, 27, 78, 0.35);
    transform: scale(0.96) translateY(10px);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
}
.ranking-modal-backdrop.is-open .ranking-modal-dialog {
    transform: scale(1) translateY(0);
}

/* Modal Header */
.ranking-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 22px 24px;
    background: linear-gradient(135deg, #FAF7FD 0%, #FFFFFF 100%);
    border-bottom: 1px solid #EFE8F6;
}
.ranking-modal-badge-type {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #EEDFFC;
    color: #5B3A8E;
}
.ranking-modal-badge-count {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    background: #D1FAE5;
    color: #065F46;
}
.ranking-modal-title {
    margin: 0;
    font-size: 20px;
    font-weight: 800;
    color: #2D1B4E;
    line-height: 1.3;
}
.ranking-modal-sub {
    margin: 4px 0 0;
    font-size: 13px;
    color: #6B7280;
}
.ranking-modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid #E5E7EB;
    background: #FFFFFF;
    color: #6B7280;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.18s ease;
}
.ranking-modal-close:hover {
    background: #FEE2E2;
    color: #DC2626;
    border-color: #FECACA;
}

/* Modal Body */
.ranking-modal-body {
    padding: 20px 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
    flex: 1;
}

/* Achievement Item Card inside Modal */
.ranking-prestasi-card {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 16px 18px;
    border-radius: 14px;
    border: 1px solid #ECE4F4;
    background: #FCFAFF;
    transition: all 0.2s ease;
}
.ranking-prestasi-card:hover {
    border-color: #8A63D2;
    background: #FFFFFF;
    box-shadow: 0 4px 14px rgba(91, 58, 142, 0.08);
}
.ranking-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}
.ranking-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
    color: #2D1B4E;
    line-height: 1.4;
}
.ranking-card-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 4px;
}
.ranking-pill {
    display: inline-flex;
    align-items: center;
    padding: 2px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}
.ranking-pill.tingkat {
    background: #EFF6FF;
    color: #1D4ED8;
    border: 1px solid #DBEAFE;
}
.ranking-pill.peringkat {
    background: #FEF3C7;
    color: #92400E;
    border: 1px solid #FDE68A;
}
.ranking-pill.kategori {
    background: #F3E8FF;
    color: #6B21A8;
    border: 1px solid #E9D5FF;
}
.ranking-card-meta {
    font-size: 12.5px;
    color: #4B5563;
    display: flex;
    flex-direction: column;
    gap: 3px;
    line-height: 1.5;
}
.ranking-card-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 6px;
    align-self: flex-start;
    font-size: 12px;
    font-weight: 700;
    color: #5B3A8E;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 8px;
    background: #F3EAFD;
    transition: all 0.18s ease;
}
.ranking-card-action:hover {
    background: #5B3A8E;
    color: #FFFFFF;
}

/* Modal Footer */
.ranking-modal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 24px;
    border-top: 1px solid #EFE8F6;
    background: #FAF7FD;
}
.ranking-modal-btn-close {
    padding: 8px 18px;
    border-radius: 10px;
    border: 1px solid #D1D5DB;
    background: #FFFFFF;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.18s ease;
}
.ranking-modal-btn-close:hover {
    background: #F3F4F6;
    color: #111827;
}

/* Empty State in Modal */
.ranking-modal-empty {
    text-align: center;
    padding: 40px 20px;
    color: #6B7280;
}
</style>

<script>
function openRankingModal(el) {
    const nama = el.getAttribute('data-nama') || 'Institusi';
    const jenis = el.getAttribute('data-jenis') || 'Fakultas';
    const sub = el.getAttribute('data-sub') || '';
    const total = el.getAttribute('data-total') || '0';
    let prestasis = [];

    try {
        prestasis = JSON.parse(el.getAttribute('data-prestasi') || '[]');
    } catch (e) {
        prestasis = [];
    }

    document.getElementById('rankingModalTitle').textContent = nama;
    document.getElementById('rankingModalJenis').textContent = jenis;
    document.getElementById('rankingModalSub').textContent = sub;
    document.getElementById('rankingModalTotal').textContent = total + ' Prestasi Disetujui';

    const body = document.getElementById('rankingModalBody');
    body.innerHTML = '';

    if (!prestasis || prestasis.length === 0) {
        body.innerHTML = `
            <div class="ranking-modal-empty">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.6" style="margin-bottom: 10px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <p style="margin: 0; font-size: 14px;">Belum ada rincian prestasi terverifikasi yang tercatat untuk ${nama}.</p>
            </div>
        `;
    } else {
        prestasis.forEach((p, idx) => {
            const card = document.createElement('article');
            card.className = 'ranking-prestasi-card';
            card.innerHTML = `
                <div class="ranking-card-top">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 8px; background: #F3EAFD; color: #5B3A8E; font-size: 12px; font-weight: 800;">${idx + 1}</span>
                            <h4 class="ranking-card-title" style="font-size: 17px;">${escapeHtml(p.nama_prestasi)}</h4>
                        </div>
                        <div class="ranking-card-pills" style="margin-left: 36px;">
                            <span class="ranking-pill tingkat">${escapeHtml(p.tingkat)}</span>
                            <span class="ranking-pill peringkat">${escapeHtml(p.peringkat)}</span>
                            <span class="ranking-pill kategori">${escapeHtml(p.kategori)}</span>
                            <span class="ranking-pill" style="background:#F3F4F6; color:#4B5563;">Tahun ${escapeHtml(p.tahun)}</span>
                        </div>
                    </div>
                </div>
                <div class="ranking-card-meta" style="margin-left: 36px;">
                    <div><strong>Penyelenggara:</strong> ${escapeHtml(p.penyelenggara)}</div>
                    <div><strong>Peserta / Sivitas:</strong> ${escapeHtml(p.peserta || '—')}</div>
                </div>
            `;
            body.appendChild(card);
        });
    }

    const modal = document.getElementById('rankingModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeRankingModal() {
    const modal = document.getElementById('rankingModal');
    if (modal) {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
}

function handleRankingBackdropClick(e) {
    if (e.target.id === 'rankingModal') {
        closeRankingModal();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRankingModal();
    }
});

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>
@endsection
