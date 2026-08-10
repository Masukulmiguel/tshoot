<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Drop ALL unique constraints on slug columns using raw SQL
        $constraints = DB::select("
            SELECT c.conname AS constraint_name,
                   a2.relname AS table_name
            FROM pg_constraint c
            JOIN pg_attribute a
              ON a.attnum = ANY(c.conkey)
             AND a.attrelid = c.conrelid
             AND a.attname = 'slug'
            JOIN pg_class a2 ON a2.oid = c.conrelid
            WHERE c.contype = 'u'
              AND c.conrelid IN ('posts'::regclass, 'services'::regclass)
        ");

        foreach ($constraints as $row) {
            DB::statement("ALTER TABLE {$row->table_name} DROP CONSTRAINT IF EXISTS \"{$row->constraint_name}\"");
        }

        // Fallback: drop by Laravel naming convention
        DB::statement("ALTER TABLE posts DROP CONSTRAINT IF EXISTS posts_slug_unique");
        DB::statement("ALTER TABLE services DROP CONSTRAINT IF EXISTS services_slug_unique");

        // Make slug nullable (no unique) on both tables
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
        });

        // Add unique constraint back separately
        Schema::table('posts', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->unique('slug');
        });

        // Fix existing records with null slug
        foreach (\App\Models\Post::whereNull('slug')->get() as $post) {
            $post->slug = Str::slug($post->title);
            $post->saveQuietly();
        }

        foreach (\App\Models\Service::whereNull('slug')->get() as $service) {
            $service->slug = Str::slug($service->title);
            $service->saveQuietly();
        }
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }
};
