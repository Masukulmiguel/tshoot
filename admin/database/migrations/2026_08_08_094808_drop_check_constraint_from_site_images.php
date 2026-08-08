<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE site_images DROP CONSTRAINT IF EXISTS site_images_category_check");
        DB::statement("ALTER TABLE site_images ALTER COLUMN category TYPE varchar(50)");
    }

    public function down(): void
    {
        // no rollback — can't recreate old enum constraint
    }
};
