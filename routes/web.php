<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\AdminExportController;
use App\Http\Controllers\SuperAdminController;
use App\Models\Prestasi;
use App\Models\User;
use App\Models\Sivitas;
use App\Models\TingkatPrestasi;
use App\Models\KategoriPrestasi;

/*
|--------------------------------------------------------------------------
| PUBLIC - LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $prestasiDisetujui = Prestasi::with([
        'kategori',
        'tingkat',
        'anggota.sivitas.user',
        'bukti',
    ])
        ->where('status', 'disetujui')
        ->orderByDesc('tahun')
        ->orderByDesc('created_at')
        ->get();

    $totalPrestasi = $prestasiDisetujui->count();

    $totalPrestasiMahasiswa = $prestasiDisetujui->filter(function ($prestasi) {
        return $prestasi->anggota->contains(function ($anggota) {
            return data_get($anggota, 'sivitas.user.role') === 'mahasiswa';
        });
    })->count();

    $totalPrestasiDosen = $prestasiDisetujui->filter(function ($prestasi) {
        return $prestasi->anggota->contains(function ($anggota) {
            return data_get($anggota, 'sivitas.user.role') === 'dosen';
        });
    })->count();




    $urutanTingkat = [
        'internasional' => 0,
        'nasional' => 1,
        'universitas' => 2,
        'regional/lokal' => 3,
        'regional' => 3,
    ];

    $statistikTingkat = $prestasiDisetujui
        ->groupBy(fn ($prestasi) => $prestasi->tingkat_id ?: 0)
        ->map(function ($items, $tingkatId) {
            $tingkat = $items->first()->tingkat;

            return [
                'id' => (int) $tingkatId ?: null,
                'nama' => $tingkat?->nama_tingkat ?: 'Belum ditentukan',
                'total' => $items->count(),
            ];
        })
        ->sortBy(fn ($item) => $urutanTingkat[mb_strtolower(trim($item['nama']))] ?? 4)
        ->values();

    $kategoriKompetisi = KategoriPrestasi::whereIn('nama_kategori', ['Akademik', 'Non Akademik'])
        ->withCount(['prestasis as total_prestasi' => fn ($query) => $query->where('status', 'disetujui')])
        ->orderBy('nama_kategori')
        ->get();

    $trenPrestasi = $prestasiDisetujui
        ->filter(function ($prestasi) {
            return !empty($prestasi->tahun);
        })
        ->groupBy('tahun')
        ->map(function ($items, $tahun) {
            return [
                'tahun' => $tahun,
                'total' => $items->count(),
            ];
        })
        ->sortBy('tahun')
        ->values();

    $jumlahMaksimalPrestasi = max(
        1,
        (int) ($trenPrestasi->max('total') ?? 0)
    );

    $prestasiUnggulan = $prestasiDisetujui
        ->take(6)
        ->values();

    $prestasiDosen = $prestasiDisetujui
        ->filter(function ($prestasi) {
            return $prestasi->anggota->contains(function ($anggota) {
                return data_get($anggota, 'sivitas.user.role') === 'dosen';
            });
        })
        ->take(6)
        ->values();

    $prestasiMahasiswa = $prestasiDisetujui
        ->filter(function ($prestasi) {
            return $prestasi->anggota->contains(function ($anggota) {
                return data_get($anggota, 'sivitas.user.role') === 'mahasiswa';
            });
        })
        ->take(6)
        ->values();

    return view('landing', compact(
        'totalPrestasi',
        'totalPrestasiMahasiswa',
        'totalPrestasiDosen',
        'statistikTingkat',
        'kategoriKompetisi',
        'trenPrestasi',
        'jumlahMaksimalPrestasi',
        'prestasiUnggulan',
        'prestasiDosen',
        'prestasiMahasiswa'
    ));

})->name('home');


/*
|--------------------------------------------------------------------------
| DAFTAR PRESTASI PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/prestasi', [
    PrestasiController::class,
    'index',
])->name('prestasi');

Route::get('/katalog-prestasi', [
    PrestasiController::class,
    'katalogPublik',
])->name('prestasi.publik');

Route::get('/katalog-prestasi/{prestasi}', [
    PrestasiController::class,
    'detailPublik',
])->name('prestasi.publik.detail');

Route::get('/profil-sivitas/{anggota}', [
    PrestasiController::class,
    'profilPesertaPublik',
])->name('prestasi.peserta.profil');
Route::get('/detail-prestasi/{prestasi}', [
    PrestasiController::class,
    'detailSatuPrestasiPublik',
])->name('prestasi.publik.rincian');


/*
|--------------------------------------------------------------------------
| ROUTE KHUSUS DOSEN
|--------------------------------------------------------------------------
| Dosen memiliki URL tersendiri untuk daftar dan pengajuan prestasi.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Katalog prestasi mahasiswa disetujui, sama seperti halaman mahasiswa.
    Route::get('/dosen/daftar-prestasi', function () {
        abort_unless(
            auth()->user()->role === 'dosen',
            403,
            'Halaman ini hanya dapat diakses oleh dosen.'
        );

        return app(PrestasiController::class)->index();

    })->name('dosen.prestasi.index');


    // Form pengajuan khusus Dosen.
    Route::get('/dosen/pengajuan-prestasi', function () {
        abort_unless(
            auth()->user()->role === 'dosen',
            403,
            'Halaman ini hanya dapat diakses oleh dosen.'
        );

        return app(PrestasiController::class)->create();

    })->name('dosen.prestasi.create');

});


/*
|--------------------------------------------------------------------------
| TINGKAT KOMPETISI
|--------------------------------------------------------------------------
*/

Route::get('/tingkat-kompetisi', [
    PrestasiController::class,
    'tingkatKompetisi',
])->name('tingkat-kompetisi');

Route::get('/tingkat-kompetisi/{tingkat}', [
    PrestasiController::class,
    'detailTingkat',
])->name('tingkat-kompetisi.detail');


/*
|--------------------------------------------------------------------------
| KELOMPOK KOMPETISI
|--------------------------------------------------------------------------
*/

Route::get('/kelompok-kompetisi', [
    PrestasiController::class,
    'kelompokKompetisi',
])->name('kelompok-kompetisi');

Route::get('/kelompok-kompetisi/{kategori}', [
    PrestasiController::class,
    'detailKelompok',
])->name('kelompok-kompetisi.detail');


/*
|--------------------------------------------------------------------------
| PRESTASI SIVITAS
|--------------------------------------------------------------------------
*/

Route::get('/dosen-berprestasi', [
    PrestasiController::class,
    'dosenBerprestasi',
])->name('dosen-berprestasi');

Route::get('/mahasiswa-berprestasi', [
    PrestasiController::class,
    'mahasiswaBerprestasi',
])->name('mahasiswa-berprestasi');

Route::get('/ranking', function () {
    $prestasiDisetujui = Prestasi::with([
        'tingkat',
        'kategori',
        'bukti',
        'anggota.sivitas.user',
    ])
    ->where('status', 'disetujui')
    ->get();

    $jumlahPrestasiFakultas = [];
    $jumlahPrestasiProgramStudi = [];

    foreach ($prestasiDisetujui as $prestasi) {
        $fakultasPadaPrestasi = [];
        $programStudiPadaPrestasi = [];

        foreach ($prestasi->anggota as $anggota) {
            $role = data_get($anggota, 'sivitas.user.role');
            $sivitas = $anggota->sivitas;

            if (! $sivitas || ! (
                $role === 'mahasiswa'
                || ($role === null && $anggota->peran === 'anggota')
            )) {
                continue;
            }

            $fakultas = trim((string) $sivitas->fakultas);
            $programStudi = trim((string) $sivitas->program_studi);
            $fakultasValid = $fakultas !== '' && mb_strtolower($fakultas) !== 'belum diisi';
            $programStudiValid = $programStudi !== '' && mb_strtolower($programStudi) !== 'belum diisi';

            if ($fakultasValid) {
                $fakultasPadaPrestasi[mb_strtolower($fakultas)] = $fakultas;
            }

            if ($fakultasValid && $programStudiValid) {
                $key = mb_strtolower($fakultas . '|' . $programStudi);
                $programStudiPadaPrestasi[$key] = [
                    'nama' => $programStudi,
                    'fakultas' => $fakultas,
                ];
            }
        }

        $prestasiItem = [
            'id' => $prestasi->id,
            'nama_prestasi' => $prestasi->nama_prestasi,
            'peringkat' => $prestasi->peringkat ?: 'Tidak dicantumkan',
            'tingkat' => $prestasi->tingkat?->nama_tingkat ?? 'Umum',
            'kategori' => $prestasi->kategori?->nama_kategori ?? 'Umum',
            'tahun' => $prestasi->tahun ?: '—',
            'penyelenggara' => $prestasi->penyelenggara ?: '—',
            'peserta' => $prestasi->anggota->map(fn ($a) => $a->nama ?? $a->sivitas?->nama)->filter()->unique()->values()->join(', '),
            'url' => route('prestasi.publik.rincian', $prestasi->id) . '?kembali=' . urlencode(request()->fullUrl()),
        ];

        foreach ($fakultasPadaPrestasi as $key => $namaFakultas) {
            $jumlahPrestasiFakultas[$key] ??= [
                'nama' => $namaFakultas,
                'total' => 0,
                'prestasi' => [],
            ];
            $jumlahPrestasiFakultas[$key]['total']++;
            $jumlahPrestasiFakultas[$key]['prestasi'][] = $prestasiItem;
        }

        foreach ($programStudiPadaPrestasi as $key => $programStudi) {
            $jumlahPrestasiProgramStudi[$key] ??= [
                'nama' => $programStudi['nama'],
                'fakultas' => $programStudi['fakultas'],
                'total' => 0,
                'prestasi' => [],
            ];
            $jumlahPrestasiProgramStudi[$key]['total']++;
            $jumlahPrestasiProgramStudi[$key]['prestasi'][] = $prestasiItem;
        }
    }

    $rankingFakultas = collect(array_values($jumlahPrestasiFakultas))
        ->sort(fn ($a, $b) => ($b['total'] <=> $a['total']) ?: strcasecmp($a['nama'], $b['nama']))
        ->values();

    $rankingProgramStudi = collect(array_values($jumlahPrestasiProgramStudi))
        ->sort(fn ($a, $b) => ($b['total'] <=> $a['total']) ?: strcasecmp($a['nama'], $b['nama']))
        ->values();

    $kataKunci = trim((string) request('q', ''));

    if ($kataKunci !== '') {
        $cari = mb_strtolower($kataKunci);
        $rankingFakultas = $rankingFakultas->filter(
            fn ($item) => str_contains(mb_strtolower($item['nama']), $cari)
        )->values();
        $rankingProgramStudi = $rankingProgramStudi->filter(
            fn ($item) => str_contains(mb_strtolower($item['nama'] . ' ' . $item['fakultas']), $cari)
        )->values();
    }

    return view('ranking', compact('rankingFakultas', 'rankingProgramStudi', 'kataKunci'));
})->name('ranking');


/*
|--------------------------------------------------------------------------
| TENTANG
|--------------------------------------------------------------------------
*/

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');


/*
|--------------------------------------------------------------------------
| PANDUAN PENGGUNAAN
|--------------------------------------------------------------------------
*/

Route::view('/panduan', 'panduan')->name('panduan');


/*
|--------------------------------------------------------------------------
| LOGIN DAN LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    AuthController::class,
    'showLogin',
])->middleware('guest')->name('login');

Route::post('/login', [
    AuthController::class,
    'login',
])->middleware('guest')->name('login.process');

Route::post('/logout', [
    AuthController::class,
    'logout',
])->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD SESUAI ROLE
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MAHASISWA
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'mahasiswa') {

        $prestasiMahasiswa = Prestasi::whereHas(
            'anggota',
            function ($query) use ($user) {
                $query->where(function ($sub) use ($user) {
                    $sub->whereHas('sivitas', function ($sivitasQuery) use ($user) {
                        $sivitasQuery->where('user_id', $user->id);
                    });
                    if ($user->nim_nip) {
                        $sub->orWhere('nim_nip', $user->nim_nip);
                    }
                });
            }
        );

        $prestasiTerbaru = (clone $prestasiMahasiswa)
            ->with([
                'kategori',
                'tingkat',
                'anggota.sivitas.user',
                'bukti',
                'verifikasi',
            ])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('dashboard.mahasiswa', [
            'totalPrestasiMahasiswa' => (clone $prestasiMahasiswa)
                ->count(),

            'pengajuanMenunggu' => (clone $prestasiMahasiswa)
                ->where('status', 'menunggu_verifikasi')
                ->count(),

            'prestasiDisetujui' => (clone $prestasiMahasiswa)
                ->where('status', 'disetujui')
                ->count(),

            'prestasiDitolak' => (clone $prestasiMahasiswa)
                ->where('status', 'ditolak')
                ->count(),

            'prestasiTerbaru' => $prestasiTerbaru,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD DOSEN
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'dosen') {

        $prestasiDosen = Prestasi::whereHas(
            'anggota',
            function ($query) use ($user) {
                $query->where('peran', 'pengaju')
                    ->whereHas(
                        'sivitas',
                        function ($sivitasQuery) use ($user) {
                            $sivitasQuery->where('user_id', $user->id);
                        }
                    );
            }
        );

        $totalPrestasi = (clone $prestasiDosen)->count();

        $menungguVerifikasi = (clone $prestasiDosen)
            ->where('status', 'menunggu_verifikasi')
            ->count();

        $prestasiDisetujui = (clone $prestasiDosen)
            ->where('status', 'disetujui')
            ->count();

        $prestasiDitolak = (clone $prestasiDosen)
            ->where('status', 'ditolak')
            ->count();

        $prestasiTerbaru = (clone $prestasiDosen)
            ->with([
                'kategori',
                'tingkat',
                'anggota.sivitas.user',
                'bukti',
                'verifikasi',
            ])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('dashboard.dosen', [
            'totalPrestasi' => $totalPrestasi,
            'menungguVerifikasi' => $menungguVerifikasi,
            'prestasiDisetujui' => $prestasiDisetujui,
            'prestasiDitolak' => $prestasiDitolak,
            'prestasiTerbaru' => $prestasiTerbaru,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    if (in_array($user->role, ['admin', 'super_admin'], true)) {

        $trenPrestasi = Prestasi::query()
            ->where('status', 'disetujui')
            ->whereNotNull('tahun')
            ->select('tahun')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $distribusiTingkatRaw = TingkatPrestasi::query()
            ->withCount(['prestasis as total' => function ($query) {
                $query->where('status', 'disetujui');
            }])
            ->get();

        $totalPrestasiDisetujuiTingkat = (int) $distribusiTingkatRaw->sum('total');

        if ($totalPrestasiDisetujuiTingkat === 0) {
            $distribusiTingkatRaw = TingkatPrestasi::query()
                ->withCount(['prestasis as total'])
                ->get();
            $totalPrestasiDisetujuiTingkat = (int) $distribusiTingkatRaw->sum('total');
        }

        $warnaPaletTingkat = ['#5B3A8E', '#C9A227', '#27834A', '#3A7BD5', '#E67E22', '#8E44AD', '#34495E'];

        $distribusiTingkat = $distribusiTingkatRaw
            ->filter(fn ($item) => (int) $item->total > 0)
            ->sortByDesc('total')
            ->values()
            ->map(function ($item, $index) use ($warnaPaletTingkat, $totalPrestasiDisetujuiTingkat) {
                $persen = $totalPrestasiDisetujuiTingkat > 0
                    ? round(($item->total / $totalPrestasiDisetujuiTingkat) * 100, 1)
                    : 0;
                $warna = $warnaPaletTingkat[$index % count($warnaPaletTingkat)];
                return [
                    'nama' => $item->nama_tingkat,
                    'total' => (int) $item->total,
                    'persen' => $persen,
                    'warna' => $warna,
                ];
            });

        $jumlahMaksimalPrestasi = max(
            1,
            (int) ($trenPrestasi->max('total') ?? 0)
        );

        return view('dashboard.admin', [
            'totalMahasiswa' => User::where('role', 'mahasiswa')
                ->count(),

            'totalDosen' => User::where('role', 'dosen')
                ->count(),

            'totalPrestasi' => Prestasi::count(),

            'pengajuanHariIni' => Prestasi::whereDate(
                'created_at',
                today()
            )->count(),

            'totalMenunggu' => Prestasi::where('status', 'menunggu_verifikasi')->count(),
            'totalDisetujui' => Prestasi::where('status', 'disetujui')->count(),
            'totalPerluPerbaikan' => Prestasi::where('status', 'perlu_perbaikan')->count(),
            'totalDitolak' => Prestasi::where('status', 'ditolak')->count(),

            'trenPrestasi' => $trenPrestasi,
            'jumlahMaksimalPrestasi' => $jumlahMaksimalPrestasi,
            'distribusiTingkat' => $distribusiTingkat,
            'totalPrestasiDisetujuiTingkat' => $totalPrestasiDisetujuiTingkat,
            'prestasis' => Prestasi::with(['kategori', 'tingkat', 'anggota.sivitas.user', 'bukti'])->orderByDesc('created_at')->orderByDesc('id')->get(),
            'tingkats' => TingkatPrestasi::orderBy('nama_tingkat')->get(),
            'kategoris' => KategoriPrestasi::orderBy('nama_kategori')->get(),
        ]);
    }

    abort(403, 'Role pengguna tidak dikenali.');

})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFIL
|--------------------------------------------------------------------------
*/

Route::get('/profil', function () {
    return redirect()->route('dashboard');
})->middleware('auth')->name('profil');


/*
|--------------------------------------------------------------------------
| PENGAJUAN PRESTASI
|--------------------------------------------------------------------------
| Route POST tetap digunakan bersama oleh Mahasiswa dan Dosen.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/prestasi/create', [
        PrestasiController::class,
        'create',
    ])->name('prestasi.create');

    Route::post('/prestasi', [
        PrestasiController::class,
        'store',
    ])->name('prestasi.store');

    Route::get('/prestasi/{prestasi}/edit', [
        PrestasiController::class,
        'edit',
    ])->name('prestasi.edit');

    Route::put('/prestasi/{prestasi}', [
        PrestasiController::class,
        'update',
    ])->name('prestasi.update');

    Route::get('/pengajuan', function () {
        return redirect()->route('prestasi.create');
    })->name('pengajuan');

});


/*
|--------------------------------------------------------------------------
| HALAMAN ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DAFTAR PRESTASI KHUSUS ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/prestasi', function () {

            abort_unless(
                in_array(auth()->user()->role, ['admin', 'super_admin'], true),
                403,
                'Halaman ini hanya dapat diakses oleh admin.'
            );

            $prestasis = Prestasi::with([
                'kategori',
                'tingkat',
                'anggota.sivitas.user',
                'bukti',
            ])
                ->orderByDesc('created_at')
                ->get();

            $tingkats = TingkatPrestasi::orderBy('nama_tingkat')->get();
            $kategoris = KategoriPrestasi::orderBy('nama_kategori')->get();

            return view('dashboard.prestasi', compact(
                'prestasis',
                'tingkats', 'kategoris'
            ));

        })->name('prestasi.index');

        Route::get('/export/{type?}', [AdminExportController::class, 'export'])->name('export');
/*
        |--------------------------------------------------------------------------
        | PANDUAN PENGGUNAAN ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/panduan', function () {

            abort_unless(
                in_array(auth()->user()->role, ['admin', 'super_admin'], true),
                403,
                'Halaman ini hanya dapat diakses oleh admin.'
            );

            return view('dashboard.panduan');

        })->name('panduan');


        /*
        |--------------------------------------------------------------------------
        | DAFTAR PENGAJUAN UNTUK VERIFIKASI
        |--------------------------------------------------------------------------
        */

        Route::get('/verifikasi', [
            VerifikasiController::class,
            'index',
        ])->name('verifikasi.index');


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KEPUTUSAN VERIFIKASI
        |--------------------------------------------------------------------------
        */

        Route::patch('/verifikasi/{prestasi}', [
            VerifikasiController::class,
            'update',
        ])->name('verifikasi.update');

    });
/*
|--------------------------------------------------------------------------
| FITUR SUPER ADMIN (MANAJEMEN AKUN & USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/users', [SuperAdminController::class, 'index'])->name('users.index');
        Route::post('/users', [SuperAdminController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [SuperAdminController::class, 'update'])->name('users.update');
        Route::put('/users/{user}/password', [SuperAdminController::class, 'updatePassword'])->name('users.password');
        Route::delete('/users/{user}', [SuperAdminController::class, 'destroy'])->name('users.destroy');
    });
