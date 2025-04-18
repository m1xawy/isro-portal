<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'shard';

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
    protected $table = 'dbo._Schedule';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'ScheduleIdx';

    public static function getSchedules($Type = [1], $Idx = [3])
    {
        return Cache::remember('event_schedule', now()->addMinutes(config('settings.general.cache.data.event_schedule')), function () use ($Idx, $Type) {
            return self::select(["MainInterval_Type", "ScheduleDefineIdx", "SubInterval_DayOfWeek", "SubInterval_StartTimeHour", "SubInterval_StartTimeMinute", "SubInterval_DurationSecond"])
                ->whereIn("MainInterval_Type", $Type)
                ->whereIn("ScheduleDefineIdx", $Idx)
                ->get();
        });
    }
}
