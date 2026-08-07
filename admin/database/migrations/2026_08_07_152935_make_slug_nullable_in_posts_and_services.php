<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->change();
        });

        // Fix existing posts with null slug
        foreach (\App\Models\Post::whereNull('slug')->get() as $post) {
            $post->slug = Str::slug($post->title);
            $post->saveQuietly();
        }

        // Fix existing services with null slug
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
