<?php

namespace App\Models\SRO\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LogChatMessage extends Model
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
    protected $table = 'dbo._LogChatMessage';

    public static function getGlobalsHistory($limit = 25, $CharName = null)
    {
        return Cache::remember('globals_history_'.$limit.'_'.$CharName, now()->addMinutes(config('settings.general.cache.data.globals_history')), function () use ($CharName, $limit) {
            return self::select(['CharName', 'EventTime', 'Comment'])
                ->where('TargetName', '[YELL]')
                ->when(!is_null($CharName), function ($query) use ($CharName) {
                    $query->where('CharName', $CharName);
                })
                ->orderByDesc('EventTime')
                ->limit($limit)
                ->get();
        });
    }
}
