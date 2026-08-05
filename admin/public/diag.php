<?php
header('Content-Type: text/plain');
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

echo "PHP Version: " . phpversion() . "\n";
echo "APP_DEBUG (env): " . (getenv('APP_DEBUG') ?: 'NOT SET') . "\n";
echo "DB_CONNECTION (env): " . (getenv('DB_CONNECTION') ?: 'NOT SET') . "\n";
echo "SESSION_DRIVER (env): " . (getenv('SESSION_DRIVER') ?: 'NOT SET') . "\n";
echo "APP_KEY (env): " . (getenv('APP_KEY') ? 'SET (hidden)' : 'NOT SET') . "\n";
echo "DB_DATABASE (env): " . (getenv('DB_DATABASE') ?: 'NOT SET') . "\n";
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

echo "\n--- Laravel log (last 100 lines) ---\n";
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES);
    $tail = array_slice($lines, -100);
    echo implode("\n", $tail) . "\n";
} else {
    echo "No log file found\n";
}

echo "\n--- Kernel test (simulate /login) ---\n";
try {
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (!file_exists($autoload)) { throw new Exception('vendor/autoload.php MISSING'); }
    require_once $autoload;
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $request = \Illuminate\Http\Request::create('/login');
    ob_start();
    $response = $kernel->handle($request);
    ob_end_clean();
    echo "Login Status: " . $response->getStatusCode() . "\n";
    echo "Config APP_DEBUG: " . var_export(config('app.debug'), true) . "\n";
    echo "Config APP_KEY set: " . var_export(strlen(config('app.key')) > 0, true) . "\n";
    echo "Config SESSION_DRIVER: " . var_export(config('session.driver'), true) . "\n";
    if ($response->getStatusCode() >= 400) {
        echo "Error content (first 2000 chars):\n";
        echo substr($response->getContent(), 0, 2000) . "\n";
    }
} catch (\Throwable $e) {
    echo "EXCEPTION: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack:\n" . $e->getTraceAsString() . "\n";
    if ($e->getPrevious()) {
        echo "\nPrevious: " . get_class($e->getPrevious()) . ": " . $e->getPrevious()->getMessage() . "\n";
        echo "File: " . $e->getPrevious()->getFile() . ":" . $e->getPrevious()->getLine() . "\n";
        echo "Stack:\n" . $e->getPrevious()->getTraceAsString() . "\n";
    }
}
