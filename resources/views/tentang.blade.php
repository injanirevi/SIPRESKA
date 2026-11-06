@extends('layouts.app')

@section('title', 'Tentang - SIPRESKA')

@section('content')
<section class="section about-section">

    <div class="about-hero">
        <span class="eyebrow dark">TENTANG SIPRESKA</span>

        <h1>
            Sistem Informasi Pendataan dan Pengelolaan
            Prestasi Sivitas Akademika
        </h1>

        <p>
            SIPRESKA dirancang sebagai portal informasi
            untuk mendata, mengelola, dan menampilkan
            prestasi mahasiswa dan dosen.
        </p>
    </div>

    <div class="about-grid">
        <article class="about-card">
            <h2>Tujuan</h2>
            <p>
                Menyediakan media informasi prestasi sivitas
                akademika yang terstruktur dan mudah diakses.
            </p>
        </article>

        <article class="about-card">
            <h2>Ruang Lingkup</h2>
            <p>
                Pendataan prestasi, informasi sivitas,
                bukti prestasi, dan proses verifikasi.
            </p>
        </article>

        <article class="about-card">
            <h2>Status Prototype</h2>
            <p>
                Tampilan saat ini masih menggunakan data dummy
                sebelum integrasi backend, database, dan API.
            </p>
        </article>
    </div>

</section>
@endsection
