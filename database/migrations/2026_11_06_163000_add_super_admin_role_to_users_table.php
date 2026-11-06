<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom role menjadi VARCHAR(30) agar mendukung role super_admin dan fleksibel
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(30) NOT NULL DEFAULT 'mahasiswa'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('mahasiswa', 'dosen', 'admin') NOT NULL DEFAULT 'mahasiswa'");
    }
};

