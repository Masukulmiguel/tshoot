<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL: drop old enum and recreate as varchar with all categories
        DB::statement("ALTER TABLE site_images ALTER COLUMN category TYPE varchar(50)");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE site_images ALTER COLUMN category TYPE varchar(50)");
    }
};
