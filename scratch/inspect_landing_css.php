<?php
$css = file_get_contents('d:/projek/sipreska/public/css/landing.css');

function extractBlock($css, $selector) {
    if (preg_match('/' . preg_quote($selector, '/') . '\s*\{([^}]*)\}/', $css, $m)) {
        return $selector . " {\n" . trim($m[1]) . "\n}";
    }
    return "$selector not found";
}

echo extractBlock($css, '.stat-box') . "\n\n";
echo extractBlock($css, '.stat-value') . "\n\n";
echo extractBlock($css, '.competition-card') . "\n\n";
echo extractBlock($css, '.recent-card') . "\n\n";
echo extractBlock($css, '.chart-card') . "\n\n";
echo extractBlock($css, '.btn-primary') . "\n\n";
echo extractBlock($css, '.hero-slider') . "\n\n";
echo extractBlock($css, '.site-footer') . "\n\n";

