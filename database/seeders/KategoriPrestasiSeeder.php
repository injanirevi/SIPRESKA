<?php

namespace Database\Seeders;

use App\Models\KategoriPrestasi;
use Illuminate\Database\Seeder;

class KategoriPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Akademik',
                'deskripsi' => 'Prestasi pada bidang akademik dan keilmuan.',
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Prestasi pada bidang olahraga.',
            ],
            [
                'nama_kategori' => 'Seni dan Budaya',
                'deskripsi' => 'Prestasi pada bidang seni dan budaya.',
            ],
            [
                'nama_kategori' => 'Inovasi dan Kewirausahaan',
                'deskripsi' => 'Prestasi inovasi, penelitian terapan, dan kewirausahaan.',
            ],
            [
                'nama_kategori' => 'Organisasi',
                'deskripsi' => 'Prestasi dalam kegiatan organisasi dan kepemimpinan.',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriPrestasi::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }
    }
}