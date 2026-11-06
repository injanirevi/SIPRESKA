<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function dropSivitasForeignKeyIfPresent(): void
    {
        $keys = DB::select(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'anggota_prestasis'
               AND COLUMN_NAME = 'sivitas_id'
               AND REFERENCED_TABLE_NAME IS NOT NULL"
        );

        if ($keys !== []) {
            Schema::table('anggota_prestasis', function (Blueprint $table) use ($keys) {
                $table->dropForeign($keys[0]->CONSTRAINT_NAME);
            });
        }
    }

    public function up(): void
    {
        $this->dropSivitasForeignKeyIfPresent();

        Schema::table('anggota_prestasis', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('sivitas_id');
            $table->string('nim_nip', 50)->nullable()->after('nama');
            $table->foreignId('sivitas_id')->nullable()->change();
        });

        Schema::table('anggota_prestasis', function (Blueprint $table) {
            $table->foreign('sivitas_id')->references('id')->on('sivitas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (DB::table('anggota_prestasis')->whereNull('sivitas_id')->exists()) {
            throw new \RuntimeException(
                'Rollback dibatalkan: masih ada anggota tim tanpa profil. Pindahkan data anggota terlebih dahulu.'
            );
        }

        $this->dropSivitasForeignKeyIfPresent();

        Schema::table('anggota_prestasis', function (Blueprint $table) {
            $table->dropColumn(['nama', 'nim_nip']);
            $table->foreignId('sivitas_id')->nullable(false)->change();
        });

        Schema::table('anggota_prestasis', function (Blueprint $table) {
            $table->foreign('sivitas_id')->references('id')->on('sivitas')->restrictOnDelete();
        });
    }
};
