<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'desc', 'url', 'icon',
    ];

    public static function getDownloads()
    {
        return Cache::remember('download', now()->addMinutes(config('settings.general.cache.data.download')), function () {
            return self::all();
        });
    }
}
