<?php
$cssPath = 'd:/projek/sipreska/public/css/landing.css';
$css = file_get_contents($cssPath);

// 1. Update font families to Plus Jakarta Sans and Poppins
$css = str_replace(
    'font-family: "Segoe UI", Arial, sans-serif;',
    "font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;",
    $css
);

// Add heading typography rule if not already present
if (strpos($css, 'h1, h2, h3, h4, .brand-title, .hero-title') === false) {
    $headingRule = "\n\nh1, h2, h3, h4, .brand-title, .hero-title, .section-heading h2, .competition-body h3 {\n    font-family: 'Poppins', 'Plus Jakarta Sans', sans-serif;\n    letter-spacing: -0.02em;\n}\n";
    $css = preg_replace('/(\/\* ==================================================\s*NAVBAR)/', $headingRule . '$1', $css, 1);
}

// 2. Modernize .stat-box
$oldStatBoxPattern = '/\.stat-box\s*\{[^}]*\}/s';
$newStatBox = '.stat-box {
    position: relative;
    overflow: hidden;
    padding: 24px 26px;
    border: 1px solid #ECE3F5;
    border-radius: 18px;
    background: #FFFFFF;
    text-align: left;
    box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}

.stat-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #7A53B3, #C9A45E);
    opacity: 0;
    transition: opacity 0.25s ease;
}

.stat-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 34px rgba(67, 39, 101, 0.09);
    border-color: #DCCDEE;
}

.stat-box:hover::before {
    opacity: 1;
}';
$css = preg_replace($oldStatBoxPattern, $newStatBox, $css, 1);

// Modernize .stat-value
$oldStatValPattern = '/\.stat-value\s*\{[^}]*\}/s';
$newStatVal = '.stat-value {
    margin-bottom: 6px;
    background: linear-gradient(135deg, #432765 0%, #7A53B3 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    color: var(--purple-dark);
    font-size: 38px;
    font-weight: 800;
    letter-spacing: -0.8px;
    line-height: 1.15;
    overflow-wrap: anywhere;
}';
$css = preg_replace($oldStatValPattern, $newStatVal, $css, 1);

// Modernize .stat-label
$oldStatLblPattern = '/\.stat-label\s*\{[^}]*\}/s';
$newStatLbl = '.stat-label {
    margin-bottom: 10px;
    color: #726284;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}';
$css = preg_replace($oldStatLblPattern, $newStatLbl, $css, 1);

// 3. Modernize .competition-card
$oldCompPattern = '/\.competition-card\s*\{[^}]*\}/s';
$newComp = '.competition-card {
    display: block;
    min-width: 0;
    overflow: hidden;
    border: 1px solid #ECE3F5;
    border-radius: 18px;
    background: #FFFFFF;
    color: inherit;
    text-decoration: none;
    box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}

.competition-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(67, 39, 101, 0.09);
    border-color: #D5C2EB;
}';
$css = preg_replace($oldCompPattern, $newComp, $css, 1);

// 4. Modernize .recent-card
$oldRecentPattern = '/\.recent-card\s*\{[^}]*\}/s';
$newRecent = '.recent-card {
    padding: 22px;
    border: 1px solid #ECE3F5;
    border-radius: 18px;
    background: #FFFFFF;
    box-shadow: 0 4px 18px rgba(67, 39, 101, 0.04);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}

.recent-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 34px rgba(67, 39, 101, 0.09);
    border-color: #DCCFE8;
}';
$css = preg_replace($oldRecentPattern, $newRecent, $css, 1);

// 5. Modernize .chart-card
$oldChartPattern = '/\.chart-card\s*\{[^}]*\}/s';
$newChart = '.chart-card {
    width: 88%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 32px;
    border: 1px solid #ECE3F5;
    border-radius: 20px;
    background: #FFFFFF;
    box-shadow: 0 6px 24px rgba(67, 39, 101, 0.04);
}';
$css = preg_replace($oldChartPattern, $newChart, $css, 1);

// 6. Modernize .btn-primary
$oldBtnPrimPattern = '/\.btn-primary\s*\{[^}]*\}/s';
$newBtnPrim = '.btn-primary {
    border: 1px solid transparent;
    border-radius: 12px;
    background: linear-gradient(135deg, #7A53B3 0%, #5B3A8E 100%);
    color: #FFFFFF;
    font-weight: 700;
    box-shadow: 0 6px 20px rgba(91, 58, 142, 0.25);
    transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease, background 0.2s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(91, 58, 142, 0.35);
    background: linear-gradient(135deg, #6C44A7 0%, #482A75 100%);
    color: #FFFFFF;
}';
$css = preg_replace($oldBtnPrimPattern, $newBtnPrim, $css, 1);

// 7. Modernize .hero-slider
$oldHeroPattern = '/\.hero-slider\s*\{[^}]*\}/s';
$newHero = '.hero-slider {
    position: relative;
    isolation: isolate;
    width: min(1600px, calc(100% - 56px));
    height: clamp(500px, 61vw, 680px);
    min-height: 500px;
    margin: 26px auto 0;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 26px;
    background: #25163A;
    box-shadow: 0 20px 55px rgba(45, 26, 71, 0.2);
}';
$css = preg_replace($oldHeroPattern, $newHero, $css, 1);

// 8. Modernize slider navigation arrows
$oldSliderBtn = '/\.slider-btn\s*\{[^}]*\}/s';
$newSliderBtn = '.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: rgba(255, 255, 255, 0.85);
    color: #432765;
    font-size: 26px;
    line-height: 1;
    cursor: pointer;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.18);
    transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
}

.slider-btn:hover {
    background: #FFFFFF;
    transform: translateY(-50%) scale(1.08);
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.25);
}';
if (preg_match($oldSliderBtn, $css)) {
    $css = preg_replace($oldSliderBtn, $newSliderBtn, $css, 1);
}

// 9. Modernize .mini-badge in recent cards
$oldMiniBadge = '/\.mini-badge\s*\{[^}]*\}/s';
$newMiniBadge = '.mini-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 999px;
    background: #F4EFFB;
    border: 1px solid #E4D6F5;
    color: #5B3A8E;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.2px;
    line-height: 1.2;
    margin-bottom: 10px;
}';
if (preg_match($oldMiniBadge, $css)) {
    $css = preg_replace($oldMiniBadge, $newMiniBadge, $css, 1);
}

file_put_contents($cssPath, $css);
echo "Modernize landing.css completed successfully! File size: " . strlen($css) . " bytes.\n";

