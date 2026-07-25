<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = ['section', 'key', 'value', 'type'];

    public static function get($section, $key, $default = null)
    {
        $content = static::where('section', $section)->where('key', $key)->first();
        return $content ? $content->value : $default;
    }

    public static function set($section, $key, $value, $type = 'text')
    {
        return static::updateOrCreate(
            ['section' => $section, 'key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    public static function getSection($section)
    {
        return static::where('section', $section)->pluck('value', 'key')->toArray();
    }
}
