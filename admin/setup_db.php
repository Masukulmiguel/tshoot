<?php
define('LARAVEL_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Run migrations
echo "Running migrations...\n";
Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
echo Illuminate\Support\Facades\Artisan::output();

// Run seeders
echo "Running seeder...\n";
Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
echo Illuminate\Support\Facades\Artisan::output();

echo "Done!\n";
