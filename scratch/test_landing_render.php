<?php
$html = @file_get_contents('http://127.0.0.1:8000/');
if ($html === false) {
    echo "Could not fetch landing page.\n";
    exit(1);
}
echo "Landing page fetched successfully! HTML size: " . strlen($html) . " bytes.\n";

if (strpos($html, 'Plus+Jakarta+Sans') !== false) {
    echo "Google Font Plus Jakarta Sans: YES\n";
} else {
    echo "Google Font Plus Jakarta Sans: NO\n";
}

if (strpos($html, 'SIPRESKA') !== false) {
    echo "Brand SIPRESKA: YES\n";
}

if (strpos($html, 'stat-box') !== false) {
    echo "Stat boxes present: YES\n";
}

