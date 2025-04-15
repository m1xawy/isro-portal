<?php

namespace App\Models\SRO\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LogInstanceWorldInfo extends Model
{
    use HasFactory;

    protected $connection = 'log';
    protected $table = 'dbo._LogInstanceWorldInfo';

    public static function getUniques($limit = 25, $CharID = 0)
    {
        $unique_points = array_keys(config('global.ranking.unique_points'));
        return Cache::remember('unique_history_'.$limit.'_'.$CharID, now()->addMinutes(config('global.general.cache.data.unique_history')), function () use ($CharID, $limit, $unique_points) {
            return self::select(['_LogInstanceWorldInfo.CharID', '_Char.CharName16', '_Char.RefObjID', '_LogInstanceWorldInfo.Value', '_LogInstanceWorldInfo.WorldID', '_RefRegion.wRegionID', '_RefRegion.AreaName', '_LogInstanceWorldInfo.EventTime',])
                ->leftJoin('SILKROAD_R_SHARD.dbo._Char', '_Char.CharID', '=', '_LogInstanceWorldInfo.CharID')
                ->leftJoin('SILKROAD_R_SHARD.dbo._RefRegion', '_RefRegion.wRegionID', '=', '_LogInstanceWorldInfo.WorldID')
                ->whereIn('_LogInstanceWorldInfo.Value', $unique_points)
                ->where('_LogInstanceWorldInfo.ValueCodeName128', 'KILL_UNIQUE_MONSTER')
                ->when($CharID > 0, function ($query) use ($CharID) {
                    $query->where('_LogInstanceWorldInfo.CharID', $CharID);
                })
                ->orderByDesc('_LogInstanceWorldInfo.EventTime')
                ->limit($limit)
                ->get();
        });
    }
}
