<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('city');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('timezone')->nullable()->after('longitude');
            $table->string('isp')->nullable()->after('timezone');
            $table->string('screen_resolution')->nullable()->after('device');
            $table->string('language')->nullable()->after('screen_resolution');
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn([
                'latitude', 'longitude', 'timezone', 'isp',
                'screen_resolution', 'language'
            ]);
        });
    }
};
