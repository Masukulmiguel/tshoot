<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform', 'url', 'icon', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->icon)) {
                $model->icon = self::defaultIcon($model->platform);
            }
        });
    }

    public static function defaultIcon(string $platform): string
    {
        return match($platform) {
            'facebook' => 'fab fa-facebook-f',
            'instagram' => 'fab fa-instagram',
            'whatsapp' => 'fab fa-whatsapp',
            'linkedin' => 'fab fa-linkedin-in',
            'youtube' => 'fab fa-youtube',
            'tiktok' => 'fab fa-tiktok',
            'twitter' => 'fab fa-x-twitter',
            default => 'fas fa-globe',
        };
    }
}
