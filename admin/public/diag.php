<?php
header('Content-Type: text/plain');
echo "PHP Version: " . phpversion() . "\n";
echo "APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'NOT SET') . "\n";
echo "DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'NOT SET') . "\n";
echo "SESSION_DRIVER: " . (getenv('SESSION_DRIVER') ?: 'NOT SET') . "\n";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'SET (hidden)' : 'NOT SET') . "\n";
echo "DB_DATABASE: " . (getenv('DB_DATABASE') ?: 'NOT SET') . "\n";
echo "Cache exists: " . (file_exists(__DIR__ . '/../bootstrap/cache/packages.php') ? 'yes' : 'no') . "\n";
echo "Storage writable: " . (is_writable(__DIR__ . '/../storage') ? 'yes' : 'no') . "\n";
echo "Sessions dir: " . (is_dir(__DIR__ . '/../storage/framework/sessions') ? 'exists' : 'MISSING') . "\n";
echo "Session writable: " . (is_writable(__DIR__ . '/../storage/framework/sessions') ? 'yes' : 'no') . "\n";
$dbPath = __DIR__ . '/../database/database.sqlite';
echo "SQLite DB exists: " . (file_exists($dbPath) ? 'yes (' . filesize($dbPath) . ' bytes)' : 'MISSING') . "\n";
echo "SQLite DB writable: " . (is_writable($dbPath) ? 'yes' : 'no') . "\n";
echo "\n--- .env file ---\n";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        if (trim($line) === '' || $line[0] === '#') continue;
        if (strpos($line, 'APP_KEY=') === 0) {
            echo "APP_KEY=SET (length=" . strlen(substr($line, 8)) . ")\n";
        } else {
            echo $line . "\n";
        }
    }
} else {
    echo ".env file MISSING!\n";
}
echo "\n--- Laravel bootstrap test ---\n";
try {
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (!file_exists($autoload)) { throw new Exception('vendor/autoload.php MISSING'); }
    require $autoload;
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    echo "App booted OK\n";
    echo "Config APP_DEBUG: " . var_export(config('app.debug'), true) . "\n";
    echo "Config APP_KEY set: " . var_export(strlen(config('app.key')) > 0, true) . "\n";
    echo "Config DB_CONNECTION: " . var_export(config('database.default'), true) . "\n";
    echo "Config SESSION_DRIVER: " . var_export(config('session.driver'), true) . "\n";
} catch (\Throwable $e) {
    echo "BOOTSTRAP FAILED: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack: " . $e->getTraceAsString() . "\n";
}
