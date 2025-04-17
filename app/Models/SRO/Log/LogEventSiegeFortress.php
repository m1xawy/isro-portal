<?php

namespace App\Models\SRO\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LogEventSiegeFortress extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'log';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
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
