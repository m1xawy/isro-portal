<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TrainingCampHonorRank extends Model
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
    protected $table = 'dbo._TrainingCampHonorRank';

    public static function getHonorRanking($limit = 25)
    {
        return Cache::remember('ranking_fortress_honor_'.$limit, config('global.general.cache.data.ranking_fortress_honor'), function () use ($limit) {
            return self::join('_TrainingCampMember', '_TrainingCampMember.CampID', '=', '_TrainingCampHonorRank.CampID')
                ->join('_Char', '_Char.CharID', '=', '_TrainingCampMember.CharID')
                ->join('_RefObjCommon', '_RefObjCommon.ID', '=', '_TrainingCampMember.RefObjID')
                ->join('_Guild', '_Guild.ID', '=', '_Char.GuildID')
                ->join('_TrainingCamp', '_TrainingCamp.ID', '=', '_TrainingCampMember.CampID')
                ->select(
                    '_Char.CharID',
                    '_Char.RefObjID',
                    '_Char.CharName16',
                    '_Guild.ID as GuildID',
                    '_Guild.Name as GuildName',
                    '_TrainingCampHonorRank.Rank',
                    '_TrainingCamp.GraduateCount',
                    '_TrainingCampMember.HonorPoint',
                    '_TrainingCamp.EvaluationPoint',
                    '_RefObjCommon.CodeName128'
                )
                ->where('_TrainingCampMember.MemberClass', 0)
                ->where('_Char.deleted', 0)
                ->where('_Char.CharID', '>', 0)
                ->orderByDesc('_TrainingCamp.EvaluationPoint')
                ->orderByDesc('_TrainingCamp.GraduateCount')
                ->orderByDesc('_TrainingCampMember.HonorPoint')
                ->limit($limit)
                ->get();
        });
    }
}
