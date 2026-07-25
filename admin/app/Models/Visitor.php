<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address', 'country', 'city', 'latitude', 'longitude',
        'timezone', 'isp', 'browser', 'os', 'device',
        'screen_resolution', 'language', 'referrer',
        'landing_page', 'pages_visited', 'first_visit', 'last_visit',
    ];

    protected $casts = [
        'first_visit' => 'datetime',
        'last_visit' => 'datetime',
        'pages_visited' => 'integer',
    ];

    public function logs()
    {
        return $this->hasMany(VisitorLog::class);
    }
}
