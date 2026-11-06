<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sivitas', function (Blueprint $table) {
            $table->id();
            $table->string('nim_nip')->unique();
            $table->string('nama');
            $table->enum('jenis_sivitas', ['mahasiswa', 'dosen']);
            $table->string('program_studi');
            $table->string('fakultas');
            $table->string('email')->unique();
            $table->string('no_hp', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sivitas');
    }
};