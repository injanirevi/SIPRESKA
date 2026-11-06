<?php

namespace Database\Seeders;

use App\Models\TingkatPrestasi;
use Illuminate\Database\Seeder;

class TingkatPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $tingkats = [
            [
                'nama_tingkat' => 'Fakultas',
                'deskripsi' => 'Prestasi pada tingkat fakultas.',
            ],
            [
                'nama_tingkat' => 'Universitas',
                'deskripsi' => 'Prestasi pada tingkat universitas.',
            ],
            [
                'nama_tingkat' => 'Nasional',
                'deskripsi' => 'Prestasi pada tingkat nasional.',
            ],
            [
                'nama_tingkat' => 'Internasional',
                'deskripsi' => 'Prestasi pada tingkat internasional.',
            ],
        ];

        foreach ($tingkats as $tingkat) {
            TingkatPrestasi::updateOrCreate(
                ['nama_tingkat' => $tingkat['nama_tingkat']],
                $tingkat
            );
        }
    }
};