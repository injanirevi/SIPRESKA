<?php
$admin = file_get_contents('d:/projek/sipreska/resources/views/dashboard/admin.blade.php');
$prestasi = file_get_contents('d:/projek/sipreska/resources/views/dashboard/prestasi.blade.php');

preg_match('/<!-- STATS -->[\s\S]*?<!-- \/STATS -->|<section class="stats">[\s\S]*?<\/section>/i', $admin, $mAdmin);
preg_match('/<!-- STATS -->[\s\S]*?<!-- \/STATS -->|<section class="stats">[\s\S]*?<\/section>/i', $prestasi, $mPrestasi);

echo "=== ADMIN STATS HTML ===\n";
echo substr($mAdmin[0] ?? 'NONE', 0, 800) . "\n\n";

echo "=== PRESTASI STATS HTML ===\n";
echo substr($mPrestasi[0] ?? 'NONE', 0, 800) . "\n";

