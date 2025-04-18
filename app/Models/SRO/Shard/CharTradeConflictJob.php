<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CharTradeConflictJob extends Model
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
    protected $table = 'dbo._CharTradeConflictJob';

    public static function getJobRanking($limit = 25, $type = 0)
    {
        return Cache::remember('ranking_fortress_job_all_'.$limit.'_'.$type, config('settings.general.cache.data.ranking_fortress_job'), function () use ($type, $limit) {
            return self::join('_Char', '_Char.CharID', '=', '_CharTradeConflictJob.CharID')
                ->join('_User', '_User.CharID', '=', '_Char.CharID')
                ->join('_UserTradeConflictJob', '_UserTradeConflictJob.UserJID', '=', '_User.UserJID')
                ->select(
                    '_Char.CharID',
                    '_Char.CharName16',
                    '_Char.NickName16',
                    '_Char.RefObjID',
                    '_UserTradeConflictJob.JobType',
                    '_CharTradeConflictJob.JobLevel',
                    '_CharTradeConflictJob.JobExp'
                )
                ->where('_Char.deleted', 0)
                ->where('_Char.CharID', '>', 0)
                ->where('_UserTradeConflictJob.JobType', '!=', 0)
                ->when($type > 0, function ($query) use ($type) {
                    $query->where('_UserTradeConflictJob.JobType', '=', $type);
                })
                ->orderByDesc('_CharTradeConflictJob.JobLevel')
                ->orderByDesc('_CharTradeConflictJob.JobExp')
                ->limit($limit)
                ->get();
        });
    }
}
