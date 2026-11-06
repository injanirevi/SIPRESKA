<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Prestasi;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Daftar pengajuan yang menunggu verifikasi admin.
     */
    public function index(Request $request)
    {
        abort_unless(
            $request->user() &&
            in_array($request->user()->role, ['admin', 'super_admin'], true),
            403,
            'Halaman ini hanya dapat diakses admin.'
        );

        $prestasis = Prestasi::with([
            'kategori',
            'tingkat',
            'anggota.sivitas',
            'bukti',
        ])
            ->where('status', 'menunggu_verifikasi')
            ->orderBy('created_at')
            ->get();

        return view('dashboard.verifikasi', compact('prestasis'));
    }

    /**
     * Simpan keputusan verifikasi admin.
     */
    public function update(Request $request, Prestasi $prestasi)
    {
        abort_unless(
            $request->user() &&
            in_array($request->user()->role, ['admin', 'super_admin'], true),
            403,
            'Hanya admin yang dapat memverifikasi prestasi.'
        );

        // Cari profil admin yang terhubung dengan akun login.
        $admin = Admin::where(
            'user_id',
            $request->user()->id
        )->first();

        abort_unless(
            $admin,
            403,
            'Akun admin belum terhubung dengan data admin.'
        );

        // Validasi keputusan dan catatan.
        $validated = $request->validate([
            'status' => [
                'required',
                'in:disetujui,ditolak',
            ],
            'catatan' => [
                'required_if:status,ditolak',
                'nullable',
                'string',
                'max:2000',
            ],
        ], [
            'catatan.required_if' =>
                'Catatan verifikasi wajib diisi jika menolak pengajuan prestasi.',
        ]);

        // Hanya pengajuan yang masih menunggu yang dapat diproses.
        if ($prestasi->status !== 'menunggu_verifikasi') {
            return redirect()
                ->route('admin.verifikasi.index')
                ->with('error', 'Pengajuan ini sudah diproses atau tidak lagi menunggu verifikasi.');
        }

        DB::transaction(function () use (
            $prestasi,
            $admin,
            $validated
        ) {
            // Perbarui status utama prestasi.
            $prestasi->update([
                'status' => $validated['status'],
            ]);

            // Simpan riwayat keputusan verifikasi.
            // Atribut ditetapkan satu per satu karena model
            // Verifikasi belum mendefinisikan $fillable.
            $verifikasi = new Verifikasi();

            $verifikasi->prestasi_id = $prestasi->id;
            $verifikasi->admin_id = $admin->id;
            $verifikasi->status = $validated['status'];
            $verifikasi->catatan = $validated['catatan'] ?? null;
            $verifikasi->tanggal_verifikasi = now();

            $verifikasi->save();
        });

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', 'Keputusan verifikasi berhasil disimpan.');
    }
}
