<?php
header('Content-Type: text/plain');

echo "=== DIAGNOSTICO PHP ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "\n\n";

echo "=== PDO SQLite ===\n";
echo "pdo_sqlite loaded: " . (extension_loaded('pdo_sqlite') ? 'YES' : 'NO') . "\n\n";

echo "=== AUTOLOADER ===\n";
$autoload = __DIR__ . '/../vendor/autoload.php';
echo "Autoload path: " . realpath($autoload) . "\n";
echo "Autoload exists: " . (file_exists($autoload) ? 'YES' : 'NO') . "\n";

if (file_exists($autoload)) {
    require $autoload;
    echo "Autoload loaded: OK\n\n";

    echo "=== LARAVEL ===\n";
    try {
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        echo "Laravel boot: OK\n";
        echo "Environment: " . $app->environment() . "\n";
    } catch (\Throwable $e) {
        echo "Laravel ERROR: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
} else {
    echo "Autoload MISSING!\n";
}

echo "\n=== FIM ===\n";
