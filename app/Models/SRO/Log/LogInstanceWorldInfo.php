<?php

namespace App\Models\SRO\Log;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LogInstanceWorldInfo extends Model
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
    protected $table = 'dbo._LogInstanceWorldInfo';

    public static function getUniqueRanking($limit = 25, $month = 0)
    {
        $uniquePoints = config('settings.ranking.unique_points');

        $caseExpression = 'SUM(CASE ';
        foreach ($uniquePoints as $mobCode => $points) {
            $points = $points['points'];
            $caseExpression .= "WHEN _LogInstanceWorldInfo.Value = '$mobCode' THEN $points ";
        }
        $caseExpression .= 'ELSE 0 END) AS Points';
        $startOfMonth = Carbon::now()->startOfMonth();

        return Cache::remember('ranking_unique_'.$limit.'_'.$month, now()->addMinutes(config('settings.general.cache.data.ranking_unique')), function () use ($month, $startOfMonth, $uniquePoints, $caseExpression, $limit) {
            return self::join('SILKROAD_R_SHARD.dbo._Char', '_Char.CharID', '=', '_LogInstanceWorldInfo.CharID')
                ->join('SILKROAD_R_SHARD.dbo._Guild', '_Char.GuildID', '=', '_Guild.ID')
                ->select(
                    '_Char.CharName16',
                    '_Char.RefObjID',
                    '_Char.CurLevel',
                    '_Guild.ID',
                    '_Guild.Name',
                    DB::raw($caseExpression)
                )
                ->whereIn('_LogInstanceWorldInfo.Value', array_keys($uniquePoints))
                ->where('_LogInstanceWorldInfo.ValueCodeName128', 'KILL_UNIQUE_MONSTER')
                ->when($month == 1, function ($query) use ($startOfMonth) {
                    $query->where('_LogInstanceWorldInfo.EventTime', '>=', $startOfMonth);
                })
                ->groupBy(
                    '_Char.CharName16',
                    '_Char.RefObjID',
                    '_Char.CurLevel',
                    '_Guild.ID',
                    '_Guild.Name'
                )
                ->orderByDesc('Points')
                ->limit(25)
                ->get();
        });
    }

    public static function getUniques($limit = 25, $CharID = 0)
    {
        $unique_points = array_keys(config('settings.ranking.unique_points'));
        return Cache::remember('unique_history_'.$limit.'_'.$CharID, now()->addMinutes(config('settings.general.cache.data.unique_history')), function () use ($CharID, $limit, $unique_points) {
            return self::select(['_LogInstanceWorldInfo.CharID', '_Char.CharName16', '_Char.RefObjID', '_Char.CurLevel', '_LogInstanceWorldInfo.ValueCodeName128', '_LogInstanceWorldInfo.Value', '_LogInstanceWorldInfo.WorldID', '_RefRegion.wRegionID', '_RefRegion.AreaName', '_LogInstanceWorldInfo.EventTime',])
                ->leftJoin('SILKROAD_R_SHARD.dbo._Char', '_Char.CharID', '=', '_LogInstanceWorldInfo.CharID')
                ->leftJoin('SILKROAD_R_SHARD.dbo._RefRegion', '_RefRegion.wRegionID', '=', '_LogInstanceWorldInfo.WorldID')
                ->whereIn('_LogInstanceWorldInfo.Value', $unique_points)
                ->whereIn('_LogInstanceWorldInfo.ValueCodeName128', ['KILL_UNIQUE_MONSTER', 'SPAWN_UNIQUE_MONSTER'])
                ->when($CharID > 0, function ($query) use ($CharID) {
                    $query->where('_LogInstanceWorldInfo.CharID', $CharID);
                })
                ->orderByDesc('_LogInstanceWorldInfo.EventTime')
                ->limit($limit)
                ->get();
        });
    }
}
