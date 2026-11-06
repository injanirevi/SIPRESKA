<?php
$html = @file_get_contents('http://127.0.0.1:8000/admin/prestasi');
if (!$html) {
    echo "Could not fetch URL\n";
    exit;
}

// Check if .stat-card CSS is present in the rendered HTML
if (strpos($html, '.stat-card {') !== false) {
    echo "CSS .stat-card { found!\n";
} else {
    echo "CSS .stat-card { NOT found!\n";
}

if (strpos($html, '.stat-number {') !== false) {
    echo "CSS .stat-number { found!\n";
} else {
    echo "CSS .stat-number { NOT found!\n";
}

if (strpos($html, '.stat-top-row') !== false) {
    echo "CSS .stat-top-row found!\n";
} else {
    echo "CSS .stat-top-row NOT found!\n";
}

if (strpos($html, 'class="stat-card') !== false) {
    echo "HTML class='stat-card' found!\n";
} else {
    echo "HTML class='stat-card' NOT found!\n";
}

