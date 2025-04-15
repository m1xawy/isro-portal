<?php

namespace App\Models\SRO\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LogEventSiegeFortress extends Model
{
    use HasFactory;

    protected $connection = 'log';
    protected $table = 'dbo._LogEventSiegeFortress';

    public static function getFortressHistory($limit = 25)
    {
        return Cache::remember('fortress_war'.$limit, now()->addMinutes(config('global.general.cache.data.fortress_war')), function () use ($limit) {
            return self::select(['FortressID', 'EventTime', 'strDesc'])
                ->where('EventID', 3)
                ->orderByDesc('EventTime')
                ->limit($limit)
                ->get();
        });
    }
}
