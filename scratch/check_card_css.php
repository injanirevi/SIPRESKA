<?php
$admin = file_get_contents('d:/projek/sipreska/resources/views/dashboard/admin.blade.php');
preg_match_all('/\.stat-card[^{]*\{[^}]*\}/i', $admin, $m);
print_r($m[0]);

preg_match('/<section class="stats">[\s\S]*?<\/section>/i', $admin, $mSec);
echo "\n--- FULL ADMIN STATS HTML ---\n";
echo $mSec[0] ?? 'NONE';

