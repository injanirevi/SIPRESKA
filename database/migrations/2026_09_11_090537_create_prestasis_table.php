<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id');
            $table->foreignId('tingkat_id');
            $table->string('nama_prestasi');
            $table->enum('jenis_prestasi', ['individu', 'tim']);
            $table->string('peringkat', 100)->nullable();
            $table->year('tahun');
            $table->string('penyelenggara');
            $table->text('deskripsi')->nullable();
            $table->enum('status', [
                'menunggu_verifikasi',
                'disetujui',
                'perlu_perbaikan',
                'ditolak',
            ])->default('menunggu_verifikasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};