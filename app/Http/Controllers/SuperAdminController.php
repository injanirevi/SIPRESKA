<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Sivitas;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Memastikan hanya Super Administrator yang dapat mengakses controller ini.
     */
    private function checkSuperAdmin(Request $request): void
    {
        $user = $request->user() ?: auth()->user();
        abort_unless(
            $user && $user->role === 'super_admin',
            403,
            'Halaman ini memiliki tingkat kewenangan khusus dan hanya dapat diakses oleh Super Administrator.'
        );
    }

    /**
     * Tampilkan daftar seluruh akun sistem (Admin, Dosen, Mahasiswa).
     */
    public function index(Request $request): View
    {
        $this->checkSuperAdmin($request);

        $query = User::with(['admin', 'sivitas'])->orderByDesc('id');

        // Pencarian
        $q = trim((string) $request->get('q', ''));
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nim_nip', 'like', "%{$q}%")
                    ->orWhereHas('admin', fn ($a) => $a->where('nama', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"))
                    ->orWhereHas('sivitas', fn ($s) => $s->where('nama', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
            });
        }

        // Filter Role
        $roleFilter = trim((string) $request->get('role', ''));
        if ($roleFilter !== '' && in_array($roleFilter, ['super_admin', 'admin', 'dosen', 'mahasiswa'], true)) {
            $query->where('role', $roleFilter);
        }

        // Filter Status
        $statusFilter = trim((string) $request->get('status', ''));
        if ($statusFilter === 'aktif' || $statusFilter === 'nonaktif') {
            $query->where(function ($sub) use ($statusFilter) {
                $sub->whereHas('sivitas', fn ($s) => $s->where('status', $statusFilter))
                    ->orWhere('role', 'admin')
                    ->orWhere('role', 'super_admin');
            });
        }

        $users = $query->paginate(25)->withQueryString();

        // Ringkasan Statistik Akun
        $totalSuperAdmin = User::where('role', 'super_admin')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalDosen = User::where('role', 'dosen')->count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalSemua = User::count();

        return view('dashboard.superadmin.users', compact(
            'users',
            'totalSemua',
            'totalSuperAdmin',
            'totalAdmin',
            'totalDosen',
            'totalMahasiswa',
            'q',
            'roleFilter',
            'statusFilter'
        ));
    }

    /**
     * Buat akun baru (Admin, Mahasiswa, atau Dosen).
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin($request);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim_nip' => ['required', 'string', 'max:50', 'unique:users,nim_nip'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'in:super_admin,admin,dosen,mahasiswa'],
            'password' => ['required', 'string', 'min:6'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'program_studi' => ['nullable', 'string', 'max:150'],
            'fakultas' => ['nullable', 'string', 'max:150'],
            'no_hp' => ['nullable', 'string', 'max:30'],
        ], [
            'nim_nip.unique' => 'NIM/NIP atau Username tersebut sudah terdaftar di sistem.',
            'password.min' => 'Kata sandi minimal terdiri dari 6 karakter.',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'nim_nip' => $validated['nim_nip'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            if (in_array($validated['role'], ['admin', 'super_admin'], true)) {
                Admin::create([
                    'user_id' => $user->id,
                    'nama' => $validated['nama'],
                    'jabatan' => $validated['jabatan'] ?: ($validated['role'] === 'super_admin' ? 'Super Administrator' : 'Administrator'),
                    'email' => $validated['email'],
                    'no_hp' => $validated['no_hp'] ?? null,
                ]);
            } else {
                Sivitas::create([
                    'user_id' => $user->id,
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'jenis_sivitas' => $validated['role'],
                    'program_studi' => $validated['program_studi'] ?: 'Belum diisi',
                    'fakultas' => $validated['fakultas'] ?: 'Belum diisi',
                    'no_hp' => $validated['no_hp'] ?? null,
                    'status' => 'aktif',
                ]);
            }
        });

        return redirect()->route('superadmin.users.index')
            ->with('success', "Akun baru {$validated['nama']} ({$validated['role']}) berhasil ditambahkan.");
    }

    /**
     * Perbarui data akun pengguna atau admin.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->checkSuperAdmin($request);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim_nip' => ['required', 'string', 'max:50', Rule::unique('users', 'nim_nip')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'in:super_admin,admin,dosen,mahasiswa'],
            'status' => ['nullable', 'in:aktif,nonaktif'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'program_studi' => ['nullable', 'string', 'max:150'],
            'fakultas' => ['nullable', 'string', 'max:150'],
            'no_hp' => ['nullable', 'string', 'max:30'],
        ]);

        DB::transaction(function () use ($user, $validated) {
            $user->update([
                'nim_nip' => $validated['nim_nip'],
                'role' => $validated['role'],
            ]);

            if (in_array($validated['role'], ['admin', 'super_admin'], true)) {
                if ($user->admin) {
                    $user->admin->update([
                        'nama' => $validated['nama'],
                        'jabatan' => $validated['jabatan'] ?: ($validated['role'] === 'super_admin' ? 'Super Administrator' : 'Administrator'),
                        'email' => $validated['email'],
                        'no_hp' => $validated['no_hp'] ?? null,
                    ]);
                } else {
                    Admin::create([
                        'user_id' => $user->id,
                        'nama' => $validated['nama'],
                        'jabatan' => $validated['jabatan'] ?: 'Administrator',
                        'email' => $validated['email'],
                        'no_hp' => $validated['no_hp'] ?? null,
                    ]);
                }
            } else {
                if ($user->sivitas) {
                    $user->sivitas->update([
                        'nama' => $validated['nama'],
                        'email' => $validated['email'],
                        'jenis_sivitas' => $validated['role'],
                        'program_studi' => $validated['program_studi'] ?: $user->sivitas->program_studi,
                        'fakultas' => $validated['fakultas'] ?: $user->sivitas->fakultas,
                        'no_hp' => $validated['no_hp'] ?? $user->sivitas->no_hp,
                        'status' => $validated['status'] ?? 'aktif',
                    ]);
                } else {
                    Sivitas::create([
                        'user_id' => $user->id,
                        'nama' => $validated['nama'],
                        'email' => $validated['email'],
                        'jenis_sivitas' => $validated['role'],
                        'program_studi' => $validated['program_studi'] ?: 'Belum diisi',
                        'fakultas' => $validated['fakultas'] ?: 'Belum diisi',
                        'no_hp' => $validated['no_hp'] ?? null,
                        'status' => $validated['status'] ?? 'aktif',
                    ]);
                }
            }
        });

        return redirect()->route('superadmin.users.index')
            ->with('success', "Data akun {$validated['nama']} berhasil diperbarui.");
    }

    /**
     * Super Admin mengubah kata sandi akun pengguna manapun.
     */
    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $this->checkSuperAdmin($request);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $nama = $user->admin?->nama ?? $user->sivitas?->nama ?? $user->nim_nip;

        return redirect()->route('superadmin.users.index')
            ->with('success', "Kata sandi untuk akun {$nama} ({$user->nim_nip}) berhasil diperbarui.");
    }

    /**
     * Hapus akun pengguna / admin.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->checkSuperAdmin($request);

        $currentUser = $request->user() ?: auth()->user();
        if ($user->id === $currentUser?->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Super Admin yang sedang digunakan untuk masuk.');
        }

        $nama = $user->admin?->nama ?? $user->sivitas?->nama ?? $user->nim_nip;

        DB::transaction(function () use ($user) {
            // Hapus profil admin atau sivitas terkait
            $user->admin()?->delete();
            $user->sivitas()?->delete();
            $user->delete();
        });

        return redirect()->route('superadmin.users.index')
            ->with('success', "Akun {$nama} berhasil dihapus dari sistem.");
    }
}
