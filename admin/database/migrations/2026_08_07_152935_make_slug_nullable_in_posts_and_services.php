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
        $slugConstraints = DB::select("
            SELECT c.conname, a2.relname AS table_name
            FROM pg_constraint c
            JOIN pg_attribute a ON a.attnum = ANY(c.conkey) AND a.attrelid = c.conrelid
            JOIN pg_class a2 ON a2.oid = c.conrelid
            WHERE c.contype = 'u'
            AND a.attname = 'slug'
            AND a2.relname IN ('posts', 'services')
        ");

        foreach ($slugConstraints as $row) {
            Schema::table($row->table_name, fn (Blueprint $t) => $t->dropUnique($row->conname));
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->change();
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
