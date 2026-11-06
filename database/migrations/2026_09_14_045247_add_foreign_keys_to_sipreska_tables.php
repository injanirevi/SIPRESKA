<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori_prestasis')
                ->restrictOnDelete();

            $table->foreign('tingkat_id')
                ->references('id')
                ->on('tingkat_prestasis')
                ->restrictOnDelete();
        });

        Schema::table('anggota_prestasis', function (Blueprint $table) {
            $table->foreign('prestasi_id')
                ->references('id')
                ->on('prestasis')
                ->cascadeOnDelete();

            $table->foreign('sivitas_id')
                ->references('id')
                ->on('sivitas')
                ->restrictOnDelete();
        });

        Schema::table('bukti_prestasis', function (Blueprint $table) {
            $table->foreign('prestasi_id')
                ->references('id')
                ->on('prestasis')
                ->cascadeOnDelete();
        });

        Schema::table('verifikasis', function (Blueprint $table) {
            $table->foreign('prestasi_id')
                ->references('id')
                ->on('prestasis')
                ->cascadeOnDelete();

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('verifikasis', function (Blueprint $table) {
            $table->dropForeign(['prestasi_id']);
            $table->dropForeign(['admin_id']);
        });

        Schema::table('bukti_prestasis', function (Blueprint $table) {
            $table->dropForeign(['prestasi_id']);
        });

        Schema::table('anggota_prestasis', function (Blueprint $table) {
            $table->dropForeign(['prestasi_id']);
            $table->dropForeign(['sivitas_id']);
        });

        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['tingkat_id']);
        });
    }
};