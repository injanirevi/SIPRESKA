<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sivitas', 'nim')) {
            Schema::table('sivitas', function (Blueprint $table) {
                $table->string('nim', 50)->nullable()->after('user_id');
            });
        }

        // Isi data nim pada tabel sivitas berdasarkan user_id di tabel users
        try {
            DB::statement("UPDATE sivitas s JOIN users u ON s.user_id = u.id SET s.nim = u.nim_nip WHERE s.nim IS NULL OR s.nim = ''");
        } catch (\Throwable $e) {
            // Lanjutkan jika query join spesifik gagal
        }

        // Isi data nim pada tabel sivitas dari anggota_prestasis jika user_id kosong
        try {
            DB::statement("UPDATE sivitas s JOIN anggota_prestasis ap ON ap.sivitas_id = s.id SET s.nim = ap.nim_nip WHERE (s.nim IS NULL OR s.nim = '') AND ap.nim_nip IS NOT NULL");
        } catch (\Throwable $e) {
            // Lanjutkan jika query join spesifik gagal
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sivitas', 'nim')) {
            Schema::table('sivitas', function (Blueprint $table) {
                $table->dropColumn('nim');
            });
        }
    }
};
