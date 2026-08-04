<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $seoSettings = [
            ['key' => 'meta_title', 'value' => 'Troubleshoot Soluções Tecnológicas | Informática em Angola', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_description', 'value' => 'Empresa Angolana de Informática - Soluções completas de tecnologia de informação, assistência técnica, desenvolvimento de software e infraestrutura de rede em Luanda.', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_keywords', 'value' => 'informática, assistência técnica, desenvolvimento software, infraestrutura, Angola, Luanda, Troubleshoot', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'og_title', 'value' => 'Troubleshoot Soluções Tecnológicas', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'og_description', 'value' => 'Empresa Angolana de Informática - Soluções completas de tecnologia de informação', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'og_image', 'value' => '', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'google_analytics', 'value' => '', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($seoSettings as $setting) {
            DB::table('site_settings')->insert($setting);
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'og_image', 'google_analytics'
        ])->delete();
    }
};
