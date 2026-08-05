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
