<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sivitas', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('nama');
        });

        // Keep identity/profile details with the academic profile before removing
        // the duplicate identity columns from users.
        DB::table('users')
            ->leftJoin('sivitas', 'sivitas.user_id', '=', 'users.id')
            ->leftJoin('admins', 'admins.user_id', '=', 'users.id')
            ->select([
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.role as user_role',
                'sivitas.id as sivitas_id',
                'admins.id as admin_id',
                'admins.nama as admin_name',
            ])
            ->orderBy('users.id')
            ->get()
            ->each(function ($row): void {
                $email = is_string($row->user_email)
                    && filter_var($row->user_email, FILTER_VALIDATE_EMAIL)
                    && ! str_ends_with(strtolower($row->user_email), '.invalid')
                        ? strtolower($row->user_email)
                        : null;

                if ($row->sivitas_id) {
                    DB::table('sivitas')->where('id', $row->sivitas_id)->update([
                        'nama' => $row->user_name ?: 'Nama belum tersedia',
                        'email' => $email,
                    ]);
                } elseif (in_array($row->user_role, ['mahasiswa', 'dosen'], true)) {
                    DB::table('sivitas')->insert([
                        'user_id' => $row->user_id,
                        'nama' => $row->user_name ?: 'Nama belum tersedia',
                        'email' => $email,
                        'jenis_sivitas' => $row->user_role,
                        'program_studi' => 'Belum disinkronkan',
                        'fakultas' => 'Belum disinkronkan',
                        'status' => 'aktif',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Admin identity already belongs to admins; only fill it if blank.
                if ($row->admin_id && $row->admin_name === null && $row->user_name) {
                    DB::table('admins')->where('id', $row->admin_id)->update([
                        'nama' => $row->user_name,
                    ]);
                }
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->dropColumn(['name', 'email', 'email_verified_at']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
        });

        DB::table('users')
            ->leftJoin('sivitas', 'sivitas.user_id', '=', 'users.id')
            ->leftJoin('admins', 'admins.user_id', '=', 'users.id')
            ->select([
                'users.id as user_id',
                'users.nim_nip',
                'sivitas.nama as sivitas_name',
                'sivitas.email as sivitas_email',
                'admins.nama as admin_name',
                'admins.email as admin_email',
            ])
            ->orderBy('users.id')
            ->get()
            ->each(function ($row): void {
                DB::table('users')->where('id', $row->user_id)->update([
                    'name' => $row->sivitas_name ?: $row->admin_name ?: $row->nim_nip,
                    'email' => $row->sivitas_email ?: $row->admin_email ?: 'user-'.$row->user_id.'@sipreska.invalid',
                ]);
            });

        Schema::table('sivitas', function (Blueprint $table) {
            $table->dropUnique('sivitas_email_unique');
            $table->dropColumn('email');
        });
    }
};
