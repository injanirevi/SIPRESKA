<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Compile or check if view compiles without error
try {
    $view = view('dashboard.prestasi', [
        'prestasis' => \App\Models\Prestasi::with(['anggota.sivitas.user', 'kategori', 'tingkat'])->latest()->get(),
        'kategoris' => \App\Models\KategoriPrestasi::all(),
        'tingkats' => \App\Models\TingkatPrestasi::all(),
        'tahunList' => [2026, 2025, 2024, 2023, 2022, 2021],
    ])->render();
    
    echo "Render success! Length: " . strlen($view) . "\n";
    echo "Has .stat-card in CSS: " . (strpos($view, '.stat-card {') !== false ? 'YES' : 'NO') . "\n";
    echo "Has .stats in CSS: " . (strpos($view, '.stats {') !== false ? 'YES' : 'NO') . "\n";
    echo "Has .stat-number in CSS: " . (strpos($view, '.stat-number {') !== false ? 'YES' : 'NO') . "\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}

