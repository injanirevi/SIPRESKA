<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Sivitas;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Menghasilkan gambar Captcha SVG bergaya AICIS UINSSC
     */
    public function captcha(Request $request): Response
    {
        $pool = '23456789bcdfghjkmnpqrstvwxyz';
        $code = '';
        $length = 4;
        for ($i = 0; $i < $length; $i++) {
            $code .= $pool[random_int(0, strlen($pool) - 1)];
        }

        $request->session()->put('login_captcha', $code);

        $width = 220;
        $height = 65;

        $charPositions = [
            ['x' => 38, 'y' => 45, 'rot' => random_int(-5, 5)],
            ['x' => 84, 'y' => 43, 'rot' => random_int(-5, 5)],
            ['x' => 132, 'y' => 46, 'rot' => random_int(-5, 5)],
            ['x' => 178, 'y' => 44, 'rot' => random_int(-5, 5)],
        ];

        $line1Y1 = random_int(22, 48);
        $line1Y2 = random_int(18, 42);
        $line2Y1 = random_int(28, 52);
        $line2Y2 = random_int(16, 36);

        $svgChars = '';
        for ($i = 0; $i < $length; $i++) {
            $char = htmlspecialchars($code[$i], ENT_QUOTES, 'UTF-8');
            $pos = $charPositions[$i];
            $svgChars .= sprintf(
                '<text x="%d" y="%d" font-family="Arial, -apple-system, BlinkMacSystemFont, sans-serif" font-size="38" font-weight="700" fill="#1b633d" text-anchor="middle" transform="rotate(%d %d %d)">%s</text>',
                $pos['x'], $pos['y'], $pos['rot'], $pos['x'], $pos['y'], $char
            );
        }

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}">
    <rect width="100%" height="100%" fill="#ffffff" rx="8" />
    <!-- Noise / strike-through lines ala AICIS -->
    <line x1="8" y1="{$line1Y1}" x2="212" y2="{$line1Y2}" stroke="#d63384" stroke-width="2.2" stroke-linecap="round" opacity="0.75" />
    <line x1="15" y1="{$line2Y1}" x2="205" y2="{$line2Y2}" stroke="#5b3a8e" stroke-width="1.6" stroke-linecap="round" opacity="0.35" />
    {$svgChars}
</svg>
SVG;

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
            'captcha'  => ['required', 'string'],
        ], [
            'captcha.required' => 'Kode keamanan captcha wajib diisi.',
        ]);

        // Verifikasi Captcha
        $sessionCaptcha = (string) $request->session()->get('login_captcha');
        $userCaptcha = strtolower(trim((string) $request->input('captcha')));

        if ($sessionCaptcha === '' || $userCaptcha !== $sessionCaptcha) {
            $request->session()->forget('login_captcha');

            return back()
                ->withErrors(['captcha' => 'Kode captcha tidak cocok atau telah kedaluwarsa. Silakan ketik kembali kode yang baru.'])
                ->onlyInput('username');
        }

        // Hapus kode captcha yang sudah digunakan
        $request->session()->forget('login_captcha');

        $username = trim($credentials['username']);
        $remember = $request->boolean('remember');
        $campusApiToken = null;
        $campusName = null;

        // 1. Cek Akun Super Admin
        if (strtolower($username) === 'superadmin') {
            $superUser = User::with('admin')->where('role', 'super_admin')->first();

            if (! $superUser) {
                return back()
                    ->withErrors(['username' => 'Akun Super Admin belum terdaftar di sistem.'])
                    ->onlyInput('username');
            }

            if (! Hash::check($credentials['password'], $superUser->password)) {
                return back()
                    ->withErrors(['username' => 'Kata sandi Super Admin salah.'])
                    ->onlyInput('username');
            }

            Auth::login($superUser, $remember);
            $campusName = $superUser->admin?->nama ?? 'Super Administrator';
        }
        // 2. Cek Akun Admin Standar ('admin')
        elseif (strtolower($username) === 'admin') {
            $adminUser = User::with('admin')->where('role', 'admin')->first();

            if (! $adminUser || ! $adminUser->admin) {
                return back()
                    ->withErrors(['username' => 'Akun admin belum tersedia atau belum terhubung.'])
                    ->onlyInput('username');
            }

            if (! Hash::check($credentials['password'], $adminUser->password)) {
                return back()
                    ->withErrors(['username' => 'Username admin atau kata sandi salah.'])
                    ->onlyInput('username');
            }

            Auth::login($adminUser, $remember);
            $campusName = $adminUser->admin->nama;
        }
        else {
            // 3. Cek apakah ada akun lokal yang terdaftar (Super Admin lain, Admin dengan NIP/Email, atau User yang diubah passwordnya)
            $localUser = User::with(['admin', 'sivitas'])
                ->where('nim_nip', $username)
                ->orWhereHas('admin', fn ($q) => $q->where('email', $username))
                ->orWhereHas('sivitas', fn ($q) => $q->where('email', $username))
                ->first();

            if ($localUser && Hash::check($credentials['password'], $localUser->password)) {
                // Pastikan akun sivitas aktif jika sivitas
                if ($localUser->sivitas && $localUser->sivitas->status === 'nonaktif') {
                    return back()
                        ->withErrors(['username' => 'Akun Anda dinonaktifkan oleh administrator. Silakan hubungi admin.'])
                        ->onlyInput('username');
                }

                Auth::login($localUser, $remember);
                $campusName = $localUser->admin?->nama ?? $localUser->sivitas?->nama ?? $localUser->nim_nip;
            } else {
                // 4. Mahasiswa dan dosen diverifikasi oleh API Portal kampus
                $baseUrl = rtrim((string) config('services.campus_bridge.base_url'), '/');

                try {
                    $response = Http::asForm()
                        ->acceptJson()
                        ->connectTimeout(5)
                        ->timeout(15)
                        ->post($baseUrl . '/api/v2/portal/login', [
                            'username' => $username,
                            'password' => $credentials['password'],
                        ]);
                } catch (ConnectionException) {
                    return back()
                        ->withErrors(['username' => 'Kredensial lokal salah, dan layanan autentikasi kampus belum dapat dihubungi. Coba lagi beberapa saat.'])
                        ->onlyInput('username');
                }

                if (in_array($response->status(), [400, 401, 422], true)) {
                    return back()
                        ->withErrors(['username' => 'NIM/NIP atau kata sandi salah.'])
                        ->onlyInput('username');
                }

                if (! $response->successful()) {
                    return back()
                        ->withErrors(['username' => 'Autentikasi kampus sedang bermasalah. Coba lagi nanti.'])
                        ->onlyInput('username');
                }

                $campusApiToken = $response->json('data.token') ?? $response->json('token');
                $campusName = $response->json('data.nama');
                $campusRole = strtolower(trim((string) $response->json('data.role')));

                if (! is_string($campusApiToken) || trim($campusApiToken) === '') {
                    return back()
                        ->withErrors(['username' => 'Respons autentikasi kampus tidak memuat token yang valid.'])
                        ->onlyInput('username');
                }

                if (! in_array($campusRole, ['mahasiswa', 'dosen'], true)) {
                    $this->logoutCampusToken($campusApiToken);

                    return back()
                        ->withErrors(['username' => 'Role akun dari portal tidak dikenali sebagai mahasiswa atau dosen.'])
                        ->onlyInput('username');
                }

                // Ambil profil akademik menggunakan token yang diberikan Portal.
                $campusProfile = [];
                try {
                    $profileResponse = Http::acceptJson()
                        ->withToken($campusApiToken)
                        ->connectTimeout(5)
                        ->timeout(10)
                        ->get($baseUrl . '/api/v2/profil');

                    if ($profileResponse->successful()) {
                        $campusProfile = $profileResponse->json('data', []);
                        if (! is_array($campusProfile)) {
                            $campusProfile = [];
                        }

                        foreach (['profil', 'mahasiswa', 'dosen'] as $section) {
                            if (isset($campusProfile[$section]) && is_array($campusProfile[$section])) {
                                $campusProfile = array_merge($campusProfile, $campusProfile[$section]);
                            }
                        }
                    }
                } catch (ConnectionException) {
                    // Login tetap bisa berjalan; data profil dilengkapi saat API tersedia.
                }

                $campusName = $campusProfile['nama'] ?? $campusName;
                $campusEmail = $campusProfile['email'] ?? null;
                $campusProgramStudi = $campusProfile['program_studi']
                    ?? $campusProfile['programStudi']
                    ?? $campusProfile['prodi']
                    ?? $campusProfile['program_studi_nama']
                    ?? null;
                $campusFakultas = $campusProfile['fakultas']
                    ?? $campusProfile['nama_fakultas']
                    ?? $campusProfile['fakultas_nama']
                    ?? null;
                $campusPhone = $campusProfile['no_hp']
                    ?? $campusProfile['nomor_hp']
                    ?? null;

                // Buat akun minimal di users; nama dan email profil disimpan di sivitas.
                $user = DB::transaction(function () use (
                    $username,
                    $credentials,
                    $campusName,
                    $campusEmail,
                    $campusRole,
                    $campusProgramStudi,
                    $campusFakultas,
                    $campusPhone
                ) {
                    $user = User::with('sivitas')->where('nim_nip', $username)->first();

                    if ($user && $user->role !== $campusRole) {
                        return $user->load('sivitas');
                    }

                    $displayName = is_string($campusName) && trim($campusName) !== ''
                        ? trim($campusName)
                        : ($user?->sivitas?->nama ?: $username);
                    $portalEmail = is_string($campusEmail) && filter_var(trim($campusEmail), FILTER_VALIDATE_EMAIL)
                        ? strtolower(trim($campusEmail))
                        : null;
                    $emailOwner = $portalEmail
                        ? Sivitas::where('email', $portalEmail)
                            ->when($user, fn ($query) => $query->where('user_id', '!=', $user->id))
                            ->exists()
                        : false;

                    if (! $user) {
                        $user = User::create([
                            'nim_nip' => $username,
                            'password' => $credentials['password'],
                            'role' => $campusRole,
                        ]);
                    } else {
                        // Sinkronkan password lokal dengan password portal yang berhasil digunakan
                        $user->update(['password' => $credentials['password']]);
                    }

                    $profileData = [
                        'nim' => $username,
                        'nama' => $displayName,
                        'email' => $portalEmail && ! $emailOwner
                            ? $portalEmail
                            : ($user->sivitas?->email ?? null),
                        'jenis_sivitas' => $campusRole,
                        'program_studi' => is_string($campusProgramStudi) && trim($campusProgramStudi) !== ''
                            ? trim($campusProgramStudi)
                            : ($user->sivitas?->program_studi ?: 'Belum disinkronkan'),
                        'fakultas' => is_string($campusFakultas) && trim($campusFakultas) !== ''
                            ? trim($campusFakultas)
                            : ($user->sivitas?->fakultas ?: 'Belum disinkronkan'),
                    ];

                    if (is_string($campusPhone) && trim($campusPhone) !== '') {
                        $profileData['no_hp'] = trim($campusPhone);
                    }

                    if ($user->sivitas) {
                        $user->sivitas->update($profileData);
                    } else {
                        $profileData['status'] = 'aktif';
                        $user->sivitas()->create($profileData);
                    }

                    $user = $user->fresh('sivitas');
                    if ($user->sivitas) {
                        DB::table('anggota_prestasis')
                            ->where('nim_nip', $username)
                            ->whereNull('sivitas_id')
                            ->update([
                                'sivitas_id' => $user->sivitas->id,
                                'nama' => $user->sivitas->nama,
                            ]);
                    }

                    return $user->load('sivitas');
                });

                if ($user->role !== $campusRole || ! $user->sivitas || $user->sivitas->status !== 'aktif') {
                    $this->logoutCampusToken($campusApiToken);

                    return back()
                        ->withErrors(['username' => 'Profil SIPRESKA tidak aktif atau role-nya berbeda dari data portal. Hubungi admin SIPRESKA.'])
                        ->onlyInput('username');
                }

                $campusName = $user->sivitas->nama;
                Auth::login($user, $remember);
            }
        }

        $request->session()->regenerate();

        if (is_string($campusName) && trim($campusName) !== '') {
            $request->session()->put('campus_display_name', trim($campusName));
        }

        if ($campusApiToken !== null) {
            $request->session()->put('campus_api_token', $campusApiToken);
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $campusApiToken = $request->session()->pull('campus_api_token');

        if (is_string($campusApiToken) && $campusApiToken !== '') {
            $this->logoutCampusToken($campusApiToken);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function logoutCampusToken(string $token): void
    {
        $baseUrl = rtrim((string) config('services.campus_bridge.base_url'), '/');

        try {
            Http::acceptJson()
                ->withToken($token)
                ->connectTimeout(3)
                ->timeout(5)
                ->post($baseUrl . '/api/v2/portal/logout');
        } catch (ConnectionException) {
            // Abaikan kegagalan logout token portal; sesi lokal sudah dibersihkan.
        }
    }
}
