<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\KategoriPrestasi;
use App\Models\TingkatPrestasi;
use App\Models\Sivitas;
use App\Models\AnggotaPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PrestasiController extends Controller
{
    private function buildPesertaDirectory($prestasis, ?string $role = null)
    {
        $peserta = [];
        foreach ($prestasis as $prestasi) {
            $anggotaList = $prestasi->anggota;
            if ($role === 'dosen') {
                $anggotaList = $anggotaList->filter(fn ($anggota) => data_get($anggota, 'sivitas.user.role') === 'dosen');
            } elseif ($role === 'mahasiswa') {
                $anggotaList = $anggotaList->filter(fn ($anggota) => data_get($anggota, 'sivitas.user.role') === 'mahasiswa' || $anggota->peran === 'anggota');
            }

            foreach ($anggotaList as $anggota) {
                $nomor = mb_strtolower(trim((string) ($anggota->nim_nip ?: $anggota->sivitas?->user?->nim_nip)));
                $key = $anggota->sivitas_id
                    ? 'sivitas:' . $anggota->sivitas_id
                    : ($nomor !== '' ? 'nomor:' . $nomor : 'nama:' . mb_strtolower(trim((string) ($anggota->nama ?: $anggota->sivitas?->nama))));

                if (!isset($peserta[$key])) {
                    $peserta[$key] = [
                        'anggota' => $anggota,
                        'nama' => $anggota->nama ?: $anggota->sivitas?->nama ?: 'Nama belum tersedia',
                        'jenis_sivitas' => $anggota->sivitas?->jenis_sivitas ?: $role,
                        'program_studi' => $anggota->sivitas?->program_studi,
                        'fakultas' => $anggota->sivitas?->fakultas,
                        'prestasis' => collect(),
                    ];
                }
                if (!$peserta[$key]['prestasis']->contains('id', $prestasi->id)) {
                    $peserta[$key]['prestasis']->push($prestasi);
                }
            }
        }

        return collect($peserta)->sortBy(fn ($item) => mb_strtolower($item['nama']))->values();
    }

    private function tampilkanDirektoriPeserta(string $judul, string $deskripsi, ?string $role = null)
    {
        $prestasis = Prestasi::with([
            'kategori', 'tingkat', 'anggota.sivitas.user', 'bukti',
        ])
            ->where('status', 'disetujui')
            ->when($role, fn ($query) => $query->whereHas('anggota.sivitas.user', fn ($sivitas) => $sivitas->where('role', $role)))
            ->orderByDesc('tahun')
            ->orderByDesc('created_at')
            ->get();

        return view('prestasi.peserta-tingkat', [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'peserta' => $this->buildPesertaDirectory($prestasis, $role),
            'label' => $role === 'mahasiswa' ? 'MAHASISWA BERPRESTASI' : ($role === 'dosen' ? 'DOSEN BERPRESTASI' : 'SIVITAS AKADEMIKA'),
            'backRoute' => route('home'),
        ]);
    }

    public function katalogPublik()
    {
        return $this->tampilkanDirektoriPeserta(
            'Semua Sivitas Berprestasi',
            'Jelajahi profil sivitas dan riwayat pencapaian yang telah disetujui di SIPRESKA.'
        );
    }
    public function detailPublik(Prestasi $prestasi)
    {
        abort_unless($prestasi->status === 'disetujui', 404);

        $prestasi->load([
            'kategori',
            'tingkat',
            'anggota.sivitas.user',
            'bukti',
        ]);

        // The public detail page is presented as a participant profile. Keep
        // the clicked achievement visible even when it has no linked profile.
        $anggotaProfil = $prestasi->anggota->first(fn ($anggota) => $anggota->sivitas !== null)
            ?? $prestasi->anggota->first();
        $profil = $anggotaProfil?->sivitas;
        $nimNip = $anggotaProfil?->nim_nip ?: $profil?->user?->nim_nip;
        $backUrl = route('prestasi.publik');

        $riwayatPrestasi = Prestasi::with([
            'kategori',
            'tingkat',
            'anggota.sivitas.user',
            'bukti',
        ])
            ->where('status', 'disetujui')
            ->whereHas('anggota', function ($query) use ($profil, $nimNip) {
                if ($profil) {
                    $query->where('sivitas_id', $profil->id);
                } elseif ($nimNip) {
                    $query->where('nim_nip', $nimNip);
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->orderByDesc('tahun')
            ->orderByDesc('created_at')
            ->get();

        if (!$riwayatPrestasi->contains('id', $prestasi->id)) {
            $riwayatPrestasi->prepend($prestasi);
        }

        return view('prestasi.detail-publik', compact(
            'prestasi', 'anggotaProfil', 'profil', 'riwayatPrestasi', 'nimNip', 'backUrl'
        ));
    }

    public function profilPesertaPublik(AnggotaPrestasi $anggota)
    {
        $anggota->load('sivitas.user', 'prestasi');
        $profil = $anggota->sivitas;
        $nimNip = trim((string) ($anggota->nim_nip ?: $profil?->user?->nim_nip));
        $nama = mb_strtolower(trim((string) ($anggota->nama ?: $profil?->nama)));

        $riwayatPrestasi = Prestasi::with([
            'kategori', 'tingkat', 'anggota.sivitas.user', 'bukti',
        ])
            ->where('status', 'disetujui')
            ->whereHas('anggota', function ($query) use ($profil, $nimNip, $nama) {
                if ($profil) {
                    $query->where('sivitas_id', $profil->id);
                } elseif ($nimNip !== '') {
                    $query->whereRaw('LOWER(TRIM(nim_nip)) = ?', [mb_strtolower($nimNip)]);
                } else {
                    $query->whereRaw('LOWER(TRIM(nama)) = ?', [$nama]);
                }
            })
            ->orderByDesc('tahun')
            ->orderByDesc('created_at')
            ->get();

        $prestasi = $riwayatPrestasi->first() ?? $anggota->prestasi;
        abort_unless($prestasi, 404);
        $anggotaProfil = $anggota;
        $nimNip = $anggota->nim_nip ?: $profil?->user?->nim_nip;
        $kembali = request()->query('kembali');
        $backUrl = is_string($kembali) && str_starts_with($kembali, '/') && !str_starts_with($kembali, '//') && !str_contains($kembali, '\\')
            ? url($kembali)
            : route('prestasi.publik');

        return view('prestasi.detail-publik', compact(
            'prestasi', 'anggotaProfil', 'profil', 'riwayatPrestasi', 'nimNip', 'backUrl'
        ));
    }
    public function detailSatuPrestasiPublik(Request $request, Prestasi $prestasi)
    {
        abort_unless($prestasi->status === 'disetujui', 404);

        $prestasi->load([
            'kategori',
            'tingkat',
            'anggota.sivitas.user',
            'bukti',
        ]);

        $kembali = $request->query('kembali');
        $backUrl = is_string($kembali)
            && str_starts_with($kembali, '/')
            && ! str_starts_with($kembali, '//')
            && ! str_contains($kembali, '\\')
                ? url($kembali)
                : route('prestasi.publik');

        return view('prestasi.detail-satu', compact('prestasi', 'backUrl'));
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR PRESTASI
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        $query = Prestasi::with([
            'kategori',
            'tingkat',
            'anggota.sivitas.user',
            'bukti',
            'verifikasi',
        ])
            ->orderByDesc('created_at')
            ->orderByDesc('tahun');

        if ($user && $user->role === 'admin') {
            // Admin melihat semua prestasi, termasuk yang belum disetujui.
        } elseif ($user && $user->role === 'dosen') {
            // Dosen melihat seluruh status pengajuan yang diajukan oleh akunnya.
            $query->whereHas('anggota', function ($anggota) use ($user) {
                    $anggota->where('peran', 'pengaju')
                        ->whereHas('sivitas', function ($sivitasQuery) use ($user) {
                            $sivitasQuery->where('user_id', $user->id);
                        });
                });
        } elseif ($user && $user->role === 'mahasiswa') {
            // Mahasiswa melihat semua status pengajuan yang melibatkan profilnya.
            $query->whereHas('anggota.sivitas', function ($sivitasQuery) use ($user) {
                $sivitasQuery->where('user_id', $user->id);
                });
        } else {
            // Pengunjung umum dapat menjelajahi prestasi semua sivitas yang disetujui.
            $query->where('status', 'disetujui');
        }

        $prestasis = $query->get();

        // Filter anggota hanya pada daftar khusus mahasiswa atau dosen.
        if ($user && in_array($user->role, ['mahasiswa', 'dosen'], true)) {
            $roleSivitas = $user->role;

            $prestasis->each(function ($prestasi) use ($roleSivitas) {
                $anggotaSesuaiRole = $prestasi->anggota
                    ->filter(function ($anggota) use ($roleSivitas) {
                        if ($roleSivitas === 'mahasiswa' && $anggota->peran === 'anggota') {
                            return true;
                        }

                        return data_get($anggota, 'sivitas.user.role') === $roleSivitas;
                    })
                    ->values();

                $prestasi->setRelation('anggota', $anggotaSesuaiRole);
            });
        }

        $kategoriFilter = KategoriPrestasi::orderBy('nama_kategori')
            ->pluck('nama_kategori');

        $tingkatFilter = TingkatPrestasi::orderBy('nama_tingkat')
            ->pluck('nama_tingkat');

        $tahunFilter = Prestasi::query()
            ->whereNotNull('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('prestasi.index', compact(
            'prestasis',
            'kategoriFilter',
            'tingkatFilter',
            'tahunFilter'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | TINGKAT KOMPETISI
    |--------------------------------------------------------------------------
    */

    public function tingkatKompetisi()
    {
        $tingkats = TingkatPrestasi::withCount([
            'prestasis as total_prestasi' => function ($query) {
                $query->where('status', 'disetujui');
            },
        ])
            ->orderBy('nama_tingkat')
            ->get();

        return view('prestasi.tingkat-index', compact('tingkats'));
    }

    public function detailTingkat(TingkatPrestasi $tingkat)
    {
        $prestasis = $tingkat->prestasis()
            ->with([
                'kategori',
                'tingkat',
                'anggota.sivitas.user',
                'bukti',
            ])
            ->where('status', 'disetujui')
            ->orderByDesc('tahun')
            ->orderByDesc('created_at')
            ->get();

        return view('prestasi.kelompok-katalog', [
            'prestasis' => $prestasis,
            'judul' => $tingkat->nama_tingkat,
            'deskripsi' => $tingkat->deskripsi
                ?: 'Daftar prestasi yang telah disetujui pada tingkat kompetisi ini.',
            'label' => 'TINGKAT KOMPETISI',
            'backRoute' => route('home'),
            'emptyMessage' => 'Belum ada prestasi yang disetujui pada tingkat ini.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | KELOMPOK KOMPETISI
    |--------------------------------------------------------------------------
    */

    public function kelompokKompetisi()
    {
        $kategoris = KategoriPrestasi::whereIn(
            'nama_kategori',
            ['Akademik', 'Non Akademik']
        )
            ->withCount([
                'prestasis as total_prestasi' => function ($query) {
                    $query->where('status', 'disetujui');
                },
            ])
            ->orderBy('nama_kategori')
            ->get();

        return view('prestasi.kelompok.index', compact('kategoris'));
    }

    public function detailKelompok(KategoriPrestasi $kategori)
    {
        $namaKategori = mb_strtolower(trim($kategori->nama_kategori));

        abort_unless(
            in_array(
                $namaKategori,
                ['akademik', 'non akademik'],
                true
            ),
            404
        );

        $prestasis = $kategori->prestasis()
            ->with([
                'kategori',
                'tingkat',
                'anggota.sivitas.user',
                'bukti',
            ])
            ->where('status', 'disetujui')
            ->orderByDesc('tahun')
            ->orderByDesc('created_at')
            ->get();

        return view('prestasi.kelompok-katalog', [
            'kategori' => $kategori,
            'prestasis' => $prestasis,
            'judul' => $kategori->nama_kategori,
            'deskripsi' => $kategori->deskripsi ?: 'Jelajahi pencapaian sivitas berdasarkan kelompok kompetisinya.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DOSEN BERPRESTASI
    |--------------------------------------------------------------------------
    */

    public function dosenBerprestasi()
    {
        return $this->tampilkanDirektoriPeserta(
            'Dosen Berprestasi',
            'Jelajahi profil dosen dan riwayat pencapaian yang telah disetujui.',
            'dosen'
        );
    }

    public function mahasiswaBerprestasi()
    {
        return $this->tampilkanDirektoriPeserta(
            'Mahasiswa Berprestasi',
            'Jelajahi profil mahasiswa dan riwayat pencapaian yang telah disetujui.',
            'mahasiswa'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FORM PENGAJUAN PRESTASI
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $kategoris = KategoriPrestasi::orderBy('nama_kategori')
            ->get();

        $tingkats = TingkatPrestasi::orderBy('nama_tingkat')
            ->get();

        $submissionToken = (string) Str::uuid();

        return view('prestasi.create', compact(
            'kategoris',
            'tingkats',
            'submissionToken'
        ));
    }

    public function edit(Request $request, Prestasi $prestasi)
    {
        $this->authorizeResubmission($request->user(), $prestasi);

        $prestasi->load([
            'anggota.sivitas.user',
            'bukti',
        ]);

        $kategoris = KategoriPrestasi::orderBy('nama_kategori')->get();
        $tingkats = TingkatPrestasi::orderBy('nama_tingkat')->get();
        $submissionToken = (string) Str::uuid();
        $catatanPerbaikan = $prestasi->verifikasi()
            ->orderByDesc('tanggal_verifikasi')
            ->value('catatan');

        return view('prestasi.create', compact(
            'kategoris',
            'tingkats',
            'submissionToken',
            'prestasi',
            'catatanPerbaikan'
        ));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $this->authorizeResubmission($request->user(), $prestasi);
        $request->merge(['editing_prestasi_id' => $prestasi->id]);

        return $this->store($request);
    }

    private function authorizeResubmission($user, Prestasi $prestasi): void
    {
        abort_unless(
            $user && in_array($user->role, ['mahasiswa', 'dosen'], true),
            403,
            'Hanya pengaju yang dapat memperbaiki prestasi.'
        );

        abort_unless(
            in_array($prestasi->status, ['ditolak', 'perlu_perbaikan'], true),
            403,
            'Pengajuan ini tidak sedang menunggu perbaikan.'
        );

        $ownerQuery = $prestasi->anggota()
            ->where('peran', 'pengaju')
            ->whereHas('sivitas', fn ($query) => $query->where('user_id', $user->id));

        abort_unless(
            $ownerQuery->exists(),
            403,
            'Anda tidak berhak memperbaiki pengajuan ini.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN PRESTASI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = $request->user();

        abort_unless(
            $user && in_array($user->role, ['mahasiswa', 'dosen'], true),
            403,
            'Hanya mahasiswa dan dosen yang dapat mengajukan prestasi.'
        );

        $prestasi = null;
        if ($request->filled('editing_prestasi_id')) {
            $prestasi = Prestasi::with('bukti')->findOrFail(
                $request->input('editing_prestasi_id')
            );
            $this->authorizeResubmission($user, $prestasi);
        }

        $sivitas = Sivitas::where('user_id', $user->id)->first();

        if (! $sivitas) {
            return back()
                ->withErrors([
                    'pengajuan' => 'Profil sivitas belum terhubung dengan akun ini.',
                ])
                ->withInput();
        }

        $validated = $request->validate([
            'submission_token' => [
                'required',
                'uuid',
            ],

            'kategori_id' => [
                'required',
                'exists:kategori_prestasis,id',
            ],

            'tingkat_id' => [
                'required',
                'exists:tingkat_prestasis,id',
            ],

            'nama_prestasi' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_prestasi' => [
                'required',
                'in:individu,tim',
            ],

            'peringkat' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tahun' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'penyelenggara' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'anggota_tim' => [
                'exclude_unless:jenis_prestasi,tim',
                'required',
                'array',
                'min:1',
            ],

            'anggota_tim.*.nama' => [
                'required',
                'string',
                'max:255',
            ],

            'anggota_tim.*.nim' => [
                'required',
                'string',
                'max:50',
                'distinct',
            ],

            'dosen_pembimbing_nama' => [
                'nullable',
                'required_with:dosen_pembimbing_nip',
                'string',
                'max:255',
            ],

            'dosen_pembimbing_nip' => [
                'nullable',
                'required_with:dosen_pembimbing_nama',
                'string',
                'max:50',
            ],

            'bukti_sertifikat' => [
                $prestasi ? 'nullable' : 'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],

            'bukti_dokumentasi' => [
                $prestasi ? 'nullable' : 'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],

            'bukti_sk' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'bukti_sertifikat.max' => 'Ukuran sertifikat maksimal 2 MB.',
            'bukti_dokumentasi.max' => 'Ukuran dokumentasi maksimal 2 MB.',
            'bukti_sk.max' => 'Ukuran SK maksimal 2 MB.',
        ]);

        if ($prestasi) {
            foreach ([
                'bukti_sertifikat' => 'Sertifikat',
                'bukti_dokumentasi' => 'Dokumentasi',
            ] as $field => $jenis) {
                $buktiTersimpan = $prestasi->bukti
                    ->contains(fn ($bukti) => $bukti->jenis_bukti === $jenis);

                if (! $request->hasFile($field) && ! $buktiTersimpan) {
                    return back()
                        ->withErrors([$field => "Unggah {$jenis} untuk melengkapi pengajuan."])
                        ->withInput();
                }
            }
        }

        /*
         * VERIFIKASI ANGGOTA TIM
         */

        $anggotaTim = [];

        if ($validated['jenis_prestasi'] === 'tim') {
            foreach ($validated['anggota_tim'] as $index => $anggota) {
                $nim = trim($anggota['nim']);
                $nama = trim($anggota['nama']);

                if ($nim === trim((string) $user->nim_nip)) {
                    return back()
                        ->withErrors([
                            "anggota_tim.$index.nim" =>
                                'NIM pengaju tidak perlu dimasukkan kembali sebagai anggota tambahan.',
                        ])
                        ->withInput();
                }

                $profilAnggota = Sivitas::with('user')
                    ->whereHas('user', fn ($query) => $query->where('nim_nip', $nim))
                    ->first();

                $anggotaTim[] = [
                    'nama' => $profilAnggota?->nama ?: $nama,
                    'nim_nip' => $nim,
                    'sivitas_id' => $profilAnggota?->id,
                ];
            }
        }

        /*
         * Simpan dosen pembimbing sebagai snapshot pengajuan.
         * Validasi terhadap data resmi dapat dihubungkan ke API kampus nanti;
         * dosen pembimbing tidak diwajibkan memiliki akun SIPRESKA.
         */
        $dosenPembimbing = null;

        if (! empty($validated['dosen_pembimbing_nip'])) {
            $dosenPembimbing = [
                'nama' => trim($validated['dosen_pembimbing_nama']),
                'nim_nip' => trim($validated['dosen_pembimbing_nip']),
            ];
        }

        /*
         * PENCEGAHAN PENGIRIMAN ULANG
         */

        $cacheKey = 'sipreska:prestasi-submit:'
            . $user->id . ':'
            . $validated['submission_token'];

        if (! Cache::add($cacheKey, true, now()->addMinutes(15))) {
            return back()
                ->withErrors([
                    'pengajuan' =>
                        'Formulir ini sudah pernah dikirim. Silakan periksa daftar prestasimu.',
                ]);
        }

        $buktiFiles = [
            'bukti_sk' => 'SK Tugas',
            'bukti_sertifikat' => 'Sertifikat',
            'bukti_dokumentasi' => 'Dokumentasi',
        ];

        $uploadedPaths = [];
        $replacedPaths = [];
        $isResubmission = $prestasi !== null;

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                $prestasi,
                $sivitas,
                $anggotaTim,
                $dosenPembimbing,
                $buktiFiles,
                &$uploadedPaths,
                &$replacedPaths
            ) {
                $dataPrestasi = [
                    'kategori_id' => $validated['kategori_id'],
                    'tingkat_id' => $validated['tingkat_id'],
                    'nama_prestasi' => $validated['nama_prestasi'],
                    'jenis_prestasi' => $validated['jenis_prestasi'],
                    'peringkat' => $validated['peringkat'] ?? null,
                    'tahun' => $validated['tahun'],
                    'penyelenggara' => $validated['penyelenggara'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'status' => 'menunggu_verifikasi',
                ];

                if ($prestasi) {
                    $prestasi->update($dataPrestasi);
                    $prestasi->anggota()
                        ->whereIn('peran', ['anggota', 'dosen_pembimbing'])
                        ->delete();
                } else {
                    $prestasi = Prestasi::create($dataPrestasi);

                    // Simpan pengaju utama.
                    $prestasi->anggota()->create([
                        'sivitas_id' => $sivitas->id,
                        'peran' => 'pengaju',
                        'keterangan' => 'Pengaju prestasi',
                    ]);
                }

                // Simpan nama dan NIM anggota tanpa mensyaratkan akun SIPRESKA.
                foreach ($anggotaTim as $anggota) {
                    $prestasi->anggota()->create([
                        'sivitas_id' => $anggota['sivitas_id'] ?? null,
                        'nama' => $anggota['nama'],
                        'nim_nip' => $anggota['nim_nip'],
                        'peran' => 'anggota',
                        'keterangan' => 'Anggota tim',
                    ]);
                }

                // Simpan identitas dosen pembimbing tanpa mengharuskan akun SIPRESKA.
                if ($dosenPembimbing) {
                    $prestasi->anggota()->create([
                        'sivitas_id' => null,
                        'nama' => $dosenPembimbing['nama'],
                        'nim_nip' => $dosenPembimbing['nim_nip'],
                        'peran' => 'dosen_pembimbing',
                        'keterangan' => 'Dosen pembimbing',
                    ]);
                }

                // Simpan lampiran bukti.
                foreach ($buktiFiles as $field => $jenis) {
                    if (! $request->hasFile($field)) {
                        continue;
                    }

                    $file = $request->file($field);

                    $path = $file->store(
                        'bukti-prestasi',
                        'public'
                    );

                    $uploadedPaths[] = $path;

                    $buktiLamaQuery = $prestasi->bukti();
                    if ($jenis === 'SK Tugas') {
                        $buktiLamaQuery->whereIn('jenis_bukti', [
                            'SK Tugas',
                            'Surat Keputusan (SK)',
                        ]);
                    } else {
                        $buktiLamaQuery->where('jenis_bukti', $jenis);
                    }
                    $buktiLama = $buktiLamaQuery->first();

                    if ($buktiLama) {
                        $replacedPaths[] = $buktiLama->file_path;
                        $buktiLama->update([
                            'jenis_bukti' => $jenis,
                            'nama_file' => $file->getClientOriginalName(),
                            'file_path' => $path,
                        ]);
                    } else {
                        $prestasi->bukti()->create([
                            'jenis_bukti' => $jenis,
                            'nama_file' => $file->getClientOriginalName(),
                            'file_path' => $path,
                        ]);
                    }
                }
            });

            foreach ($replacedPaths as $path) {
                Storage::disk('public')->delete($path);
            }
        } catch (\Throwable $exception) {
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            Cache::forget($cacheKey);

            report($exception);

            return back()
                ->withErrors([
                    'pengajuan' =>
                        'Pengajuan belum berhasil disimpan. Silakan periksa data dan coba kembali.',
                ])
                ->withInput();
        }

        return redirect()
            ->route($user->role === 'dosen'
                ? 'dosen.prestasi.index'
                : 'prestasi')
            ->with('success', $isResubmission
                ? 'Perbaikan berhasil dikirim ulang dan menunggu verifikasi admin.'
                : 'Pengajuan prestasi berhasil dikirim dan menunggu verifikasi admin.');
    }
}
