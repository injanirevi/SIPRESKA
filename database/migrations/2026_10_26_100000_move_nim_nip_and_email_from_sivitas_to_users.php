<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        $profilesWithoutAccount = DB::table('sivitas')
            ->whereNull('user_id')
            ->count();

        $profilesWithoutMatchingAccount = DB::table('sivitas')
            ->leftJoin('users', 'users.id', '=', 'sivitas.user_id')
            ->whereNotNull('sivitas.user_id')
            ->whereNull('users.id')
            ->count();

        if ($profilesWithoutAccount > 0 || $profilesWithoutMatchingAccount > 0) {
            throw new RuntimeException(
                'Pemindahan NIM/NIP dibatalkan: ada profil sivitas yang belum terhubung ke akun users.'
            );
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('nim_nip', 50)->nullable()->unique()->after('email');
        });

        DB::table('sivitas')
            ->orderBy('id')
            ->get(['user_id', 'nim_nip'])
            ->each(function ($profile) {
                DB::table('users')
                    ->where('id', $profile->user_id)
                    ->update(['nim_nip' => $profile->nim_nip]);
            });

        Schema::table('sivitas', function (Blueprint $table) {
            $table->dropUnique('sivitas_nim_nip_unique');
            $table->dropUnique('sivitas_email_unique');
            $table->dropColumn(['nim_nip', 'email']);
        });
    }

    public function down(): void
    {
        Schema::table('sivitas', function (Blueprint $table) {
            $table->string('nim_nip')->nullable()->unique();
            $table->string('email')->nullable()->unique();
        });

        DB::table('sivitas')
            ->leftJoin('users', 'users.id', '=', 'sivitas.user_id')
            ->select('sivitas.id', 'users.nim_nip', 'users.email')
            ->orderBy('sivitas.id')
            ->get()
            ->each(function ($profile) {
                DB::table('sivitas')
                    ->where('id', $profile->id)
                    ->update([
                        'nim_nip' => $profile->nim_nip,
                        'email' => $profile->email,
                    ]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_nim_nip_unique');
            $table->dropColumn('nim_nip');
        });
    }
};
