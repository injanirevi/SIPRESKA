<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestasi_id');
            $table->string('jenis_bukti');
            $table->string('nama_file');
            $table->string('file_path');
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_prestasis');
    }
};