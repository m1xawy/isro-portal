<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    protected $casts = [];

    public static function getPage($slug)
    {
        return Cache::remember('pages_view_'.$slug, now()->addMinutes(config('settings.general.cache.data.pages')), function () use ($slug) {
            return self::where('slug', $slug)->first();
        });
    }
}
