<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestasi_id');
            $table->foreignId('sivitas_id');
            $table->string('peran')->default('anggota');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['prestasi_id', 'sivitas_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_prestasis');
    }
};