<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Schedule extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._Schedule';

    protected $primaryKey = 'ScheduleIdx';

    protected $fillable = [];

    public static function getSchedules($Type = [1], $Idx = [3])
    {
        return Cache::remember('event_schedule', now()->addMinutes(config('global.general.cache.data.event_schedule')), function () use ($Idx, $Type) {
            return self::select(["MainInterval_Type", "ScheduleDefineIdx", "SubInterval_DayOfWeek", "SubInterval_StartTimeHour", "SubInterval_StartTimeMinute", "SubInterval_DurationSecond"])
                ->whereIn("MainInterval_Type", $Type)
                ->whereIn("ScheduleDefineIdx", $Idx)
                ->get();
        });
    }
}
