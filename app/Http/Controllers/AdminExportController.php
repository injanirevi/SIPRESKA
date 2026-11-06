<?php

namespace App\Http\Controllers;

use App\Models\KategoriPrestasi;
use App\Models\Prestasi;
use App\Models\Sivitas;
use App\Models\TingkatPrestasi;
use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminExportController extends Controller
{
    /**
     * Ekspor data sistem ke format CSV (UTF-8 BOM untuk kompatibilitas Excel).
     */
    public function export(Request $request, string $type = 'prestasi'): StreamedResponse
    {
        abort_unless(
            $request->user() && in_array($request->user()->role, ['admin', 'super_admin'], true),
            403,
            'Halaman ekspor data hanya dapat diakses oleh administrator.'
        );

        $type = strtolower(trim($type));
        $timestamp = date('Ymd_His');

        return match ($type) {
            'prestasi-disetujui' => $this->exportPrestasi('disetujui', "sipreska_prestasi_disetujui_{$timestamp}.csv"),
            'prestasi-menunggu' => $this->exportPrestasi('menunggu_verifikasi', "sipreska_prestasi_menunggu_{$timestamp}.csv"),
            'prestasi-ditolak' => $this->exportPrestasi('ditolak', "sipreska_prestasi_ditolak_{$timestamp}.csv"),
            'mahasiswa' => $this->exportMahasiswa("sipreska_data_mahasiswa_{$timestamp}.csv"),
            'dosen' => $this->exportDosen("sipreska_data_dosen_{$timestamp}.csv"),
            'verifikasi' => $this->exportVerifikasi("sipreska_riwayat_verifikasi_{$timestamp}.csv"),
            'tren', 'tren-tahunan', 'statistik' => $this->exportTren("sipreska_rekap_tahunan_{$timestamp}.csv"),
            default => $this->exportPrestasi(null, "sipreska_semua_prestasi_{$timestamp}.csv"),
        };
    }

    /**
     * Ekspor data prestasi (semua atau berdasarkan status tertentu).
     */
    private function exportPrestasi(?string $filterStatus, string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->streamDownload(function () use ($filterStatus) {
            $handle = fopen('php://output', 'w');
            // Tulis UTF-8 BOM agar terbaca sempurna di Microsoft Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'ID Prestasi',
                'Nama Prestasi',
                'Kategori',
                'Tingkat',
                'Jenis Prestasi',
                'Peringkat / Capaian',
                'Tahun',
                'Penyelenggara',
                'Status Verifikasi',
                'Nama Pengaju / Ketua',
                'NIM / NIP Pengaju',
                'Role Sivitas Pengaju',
                'Fakultas',
                'Program Studi',
                'Daftar Anggota Tim',
                'Jumlah Bukti',
                'Deskripsi',
                'Tanggal Pengajuan',
            ]);

            $query = Prestasi::with([
                'kategori',
                'tingkat',
                'anggota.sivitas.user',
                'bukti',
            ])->orderByDesc('created_at')->orderByDesc('id');

            if ($filterStatus !== null) {
                $query->where('status', $filterStatus);
            }

            $no = 1;
            $query->chunk(100, function ($prestasis) use ($handle, &$no) {
                foreach ($prestasis as $prestasi) {
                    $pengaju = $prestasi->anggota->first(fn ($a) => $a->peran === 'pengaju')
                        ?? $prestasi->anggota->first();

                    $namaPengaju = $pengaju?->nama
                        ?? $pengaju?->sivitas?->nama
                        ?? '—';

                    $nimNipPengaju = $pengaju?->nim_nip
                        ?? $pengaju?->sivitas?->user?->nim_nip
                        ?? '—';

                    $rolePengaju = ucfirst($pengaju?->sivitas?->user?->role ?? $pengaju?->sivitas?->jenis_sivitas ?? '—');
                    $fakultas = $pengaju?->sivitas?->fakultas ?? '—';
                    $prodi = $pengaju?->sivitas?->program_studi ?? '—';

                    $daftarAnggota = $prestasi->anggota->map(function ($a) {
                        $nama = $a->nama ?? $a->sivitas?->nama ?? 'Tanpa Nama';
                        $identitas = $a->nim_nip ?? $a->sivitas?->user?->nim_nip;
                        $peran = $a->peran ? "({$a->peran})" : '';
                        return $identitas ? "{$nama} [{$identitas}] {$peran}" : "{$nama} {$peran}";
                    })->implode('; ');

                    $statusLabel = match ($prestasi->status) {
                        'disetujui' => 'Disetujui',
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'ditolak' => 'Ditolak',
                        'perlu_perbaikan' => 'Perlu Perbaikan',
                        default => ucfirst((string) $prestasi->status),
                    };

                    fputcsv($handle, [
                        $no++,
                        $prestasi->id,
                        $prestasi->nama_prestasi,
                        $prestasi->kategori?->nama_kategori ?? '—',
                        $prestasi->tingkat?->nama_tingkat ?? '—',
                        ucfirst((string) ($prestasi->jenis_prestasi ?? 'individu')),
                        $prestasi->peringkat ?: '—',
                        $prestasi->tahun ?: '—',
                        $prestasi->penyelenggara ?: '—',
                        $statusLabel,
                        $namaPengaju,
                        $nimNipPengaju,
                        $rolePengaju,
                        $fakultas,
                        $prodi,
                        $daftarAnggota ?: '—',
                        $prestasi->bukti->count(),
                        $prestasi->deskripsi ?: '—',
                        $prestasi->created_at ? $prestasi->created_at->format('Y-m-d H:i:s') : '—',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Ekspor data direktori mahasiswa.
     */
    private function exportMahasiswa(string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'NIM',
                'Nama Mahasiswa',
                'Fakultas',
                'Program Studi',
                'Email',
                'No Handphone',
                'Status Akun',
                'Total Prestasi Diajukan/Terlibat',
                'Total Prestasi Disetujui',
                'Tanggal Terdaftar',
            ]);

            $mahasiswas = Sivitas::with(['user', 'anggotaPrestasi.prestasi'])
                ->where('jenis_sivitas', 'mahasiswa')
                ->orWhereHas('user', fn ($q) => $q->where('role', 'mahasiswa'))
                ->orderBy('nama')
                ->get();

            $no = 1;
            foreach ($mahasiswas as $mhs) {
                $totalPrestasi = $mhs->anggotaPrestasi->count();
                $totalDisetujui = $mhs->anggotaPrestasi->filter(function ($a) {
                    return $a->prestasi && $a->prestasi->status === 'disetujui';
                })->count();

                fputcsv($handle, [
                    $no++,
                    $mhs->user?->nim_nip ?? '—',
                    $mhs->nama,
                    $mhs->fakultas ?: '—',
                    $mhs->program_studi ?: '—',
                    $mhs->email ?: '—',
                    $mhs->no_hp ?: '—',
                    ucfirst((string) ($mhs->status ?? 'aktif')),
                    $totalPrestasi,
                    $totalDisetujui,
                    $mhs->created_at ? $mhs->created_at->format('Y-m-d H:i:s') : '—',
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Ekspor data direktori dosen.
     */
    private function exportDosen(string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'NIP',
                'Nama Dosen',
                'Fakultas',
                'Program Studi',
                'Email',
                'No Handphone',
                'Status Akun',
                'Total Prestasi Diajukan/Terlibat',
                'Total Prestasi Disetujui',
                'Tanggal Terdaftar',
            ]);

            $dosens = Sivitas::with(['user', 'anggotaPrestasi.prestasi'])
                ->where('jenis_sivitas', 'dosen')
                ->orWhereHas('user', fn ($q) => $q->where('role', 'dosen'))
                ->orderBy('nama')
                ->get();

            $no = 1;
            foreach ($dosens as $dsn) {
                $totalPrestasi = $dsn->anggotaPrestasi->count();
                $totalDisetujui = $dsn->anggotaPrestasi->filter(function ($a) {
                    return $a->prestasi && $a->prestasi->status === 'disetujui';
                })->count();

                fputcsv($handle, [
                    $no++,
                    $dsn->user?->nim_nip ?? '—',
                    $dsn->nama,
                    $dsn->fakultas ?: '—',
                    $dsn->program_studi ?: '—',
                    $dsn->email ?: '—',
                    $dsn->no_hp ?: '—',
                    ucfirst((string) ($dsn->status ?? 'aktif')),
                    $totalPrestasi,
                    $totalDisetujui,
                    $dsn->created_at ? $dsn->created_at->format('Y-m-d H:i:s') : '—',
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Ekspor riwayat verifikasi prestasi.
     */
    private function exportVerifikasi(string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'ID Verifikasi',
                'ID Prestasi',
                'Nama Prestasi',
                'Tingkat',
                'Kategori',
                'Nama Pengaju',
                'NIM / NIP Pengaju',
                'Keputusan Verifikasi',
                'Catatan / Alasan Penolakan',
                'Admin Verifikator',
                'Tanggal & Waktu Verifikasi',
            ]);

            $verifikasis = Verifikasi::with([
                'prestasi.kategori',
                'prestasi.tingkat',
                'prestasi.anggota.sivitas.user',
                'admin',
            ])->orderByDesc('tanggal_verifikasi')->orderByDesc('id')->get();

            $no = 1;
            foreach ($verifikasis as $v) {
                $prestasi = $v->prestasi;
                $pengaju = $prestasi?->anggota->first(fn ($a) => $a->peran === 'pengaju')
                    ?? $prestasi?->anggota->first();

                $namaPengaju = $pengaju?->nama ?? $pengaju?->sivitas?->nama ?? '—';
                $identitas = $pengaju?->nim_nip ?? $pengaju?->sivitas?->user?->nim_nip ?? '—';

                $keputusanLabel = match ($v->status) {
                    'disetujui' => 'Disetujui',
                    'ditolak' => 'Ditolak',
                    default => ucfirst((string) $v->status),
                };

                fputcsv($handle, [
                    $no++,
                    $v->id,
                    $prestasi?->id ?? '—',
                    $prestasi?->nama_prestasi ?? 'Prestasi Dihapus / Tidak Ditemukan',
                    $prestasi?->tingkat?->nama_tingkat ?? '—',
                    $prestasi?->kategori?->nama_kategori ?? '—',
                    $namaPengaju,
                    $identitas,
                    $keputusanLabel,
                    $v->catatan ?: '—',
                    $v->admin?->nama ?? 'Admin',
                    $v->tanggal_verifikasi ?: ($v->created_at ? $v->created_at->format('Y-m-d H:i:s') : '—'),
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Ekspor rekap perkembangan tahunan prestasi.
     */
    private function exportTren(string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'Tahun Perolehan',
                'Prestasi Disetujui',
                'Menunggu Verifikasi',
                'Prestasi Ditolak',
                'Total Pengajuan',
            ]);

            $rekap = Prestasi::query()
                ->whereNotNull('tahun')
                ->where('tahun', '!=', '')
                ->selectRaw('tahun,
                    SUM(CASE WHEN status = "disetujui" THEN 1 ELSE 0 END) as disetujui,
                    SUM(CASE WHEN status = "menunggu_verifikasi" THEN 1 ELSE 0 END) as menunggu,
                    SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as ditolak,
                    COUNT(*) as total')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get();

            $no = 1;
            foreach ($rekap as $row) {
                fputcsv($handle, [
                    $no++,
                    $row->tahun,
                    $row->disetujui,
                    $row->menunggu,
                    $row->ditolak,
                    $row->total,
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }
}

