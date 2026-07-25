<?php
$dirs = [
    __DIR__ . '/bootstrap/cache',
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/storage/framework/sessions',
    __DIR__ . '/storage/framework/cache/data',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    foreach (glob($dir . '/*') as $f) {
        if (is_file($f) && basename($f) !== '.gitignore' && basename($f) !== '.gitkeep') unlink($f);
    }
}
echo "Done";
