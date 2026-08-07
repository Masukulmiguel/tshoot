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
        // Drop existing unique constraints first, then alter
        $postsConstraint = DB::select("SELECT conname FROM pg_constraint WHERE conrelid = 'posts'::regclass AND contype = 'u' AND conkey::text LIKE '%slug%'");
        foreach ($postsConstraint as $c) {
            Schema::table('posts', fn (Blueprint $t) => $t->dropUnique($c->conname));
        }

        $servicesConstraint = DB::select("SELECT conname FROM pg_constraint WHERE conrelid = 'services'::regclass AND contype = 'u' AND conkey::text LIKE '%slug%'");
        foreach ($servicesConstraint as $c) {
            Schema::table('services', fn (Blueprint $t) => $t->dropUnique($c->conname));
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
