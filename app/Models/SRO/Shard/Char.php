<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Char extends Model
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
    protected $table = 'dbo._Char';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'CharID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CharID',
        'Deleted',
        'RefObjID',
        'CharName16',
        'NickName16',
        'LastLogout',
        'RemainGold'
    ];

    protected $dates = [
        'LastLogout'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public static function getPlayerRanking($limit = 25)
    {
        return Cache::remember('ranking_player_'.$limit, config('global.general.cache.data.ranking-player'), function () use ($limit) {
            return self::select(
                '_Char.CharID',
                '_Char.CharName16',
                '_Char.CurLevel',
                '_Char.RefObjID',
                '_Guild.ID',
                '_Guild.Name',
                DB::raw("ISNULL((
                    SUM(ISNULL(_BindingOptionWithItem.nOptValue, 0)) +
                    SUM(ISNULL(_Items.OptLevel, 0)) +
                    SUM(ISNULL(_RefObjCommon.ReqLevel1, 0)) +
                    SUM(ISNULL(CASE WHEN _RefObjCommon.CodeName128 LIKE '%_A_RARE%' THEN 5 ELSE 0 END, 0)) +
                    SUM(ISNULL(CASE WHEN _RefObjCommon.CodeName128 LIKE '%_B_RARE%' THEN 10 ELSE 0 END, 0)) +
                    SUM(ISNULL(CASE WHEN _RefObjCommon.CodeName128 LIKE '%_C_RARE%' THEN 15 ELSE 0 END, 0))
                ), 0) AS ItemPoints"))

                ->join('_Guild', '_Char.GuildID', '=', '_Guild.ID')
                ->join('_Inventory', '_Inventory.CharID', '=', '_Char.CharID')
                ->join('_Items', '_Items.ID64', '=', '_Inventory.ItemID')
                ->join('_RefObjCommon', '_RefObjCommon.ID', '=', '_Items.RefItemID')
                ->leftJoin('_BindingOptionWithItem', function ($join) {
                    $join->on('_BindingOptionWithItem.nItemDBID', '=', '_Items.ID64')
                        ->where('_BindingOptionWithItem.nOptValue', '>', 0)
                        ->where('_BindingOptionWithItem.bOptType', '=', 2);
                })
                ->where('_Inventory.Slot', '<', 13)
                ->where('_Inventory.Slot', '!=', 8)
                ->where('_Inventory.Slot', '!=', 7)
                ->where('_Inventory.ItemID', '>', 0)
                ->where('_Char.deleted', '=', 0)
                ->where('_Char.CharID', '>', 0)
                ->groupBy(
                    '_Char.CharID',
                    '_Char.CharName16',
                    '_Char.CurLevel',
                    '_Char.RefObjID',
                    '_Guild.ID',
                    '_Guild.Name'
                )
                ->orderByDesc('ItemPoints')
                ->orderByDesc('_Char.CurLevel')
                ->limit($limit)
                ->get();
        });
    }

    public static function getGuildRanking($limit = 25)
    {
        return Cache::remember('ranking_guild_'.$limit, config('global.general.cache.data.ranking-guild'), function () use ($limit) {
            return self::select(
                '_Guild.ID',
                '_Guild.Name',
                '_Guild.Lvl',
                '_Guild.GatheredSP',
                DB::raw("(SELECT CharID FROM _GuildMember WHERE GuildID = _Guild.ID AND MemberClass = 0) AS LeaderID"),
                DB::raw("(SELECT CharName FROM _GuildMember WHERE GuildID = _Guild.ID AND MemberClass = 0) AS LeaderName"),
                DB::raw("(SELECT COUNT(CharID) FROM _GuildMember WHERE GuildID = _Guild.ID) AS TotalMember"),
                DB::raw("ISNULL((
                    SUM(ISNULL(_BindingOptionWithItem.nOptValue, 0)) +
                    SUM(ISNULL(_Items.OptLevel, 0)) +
                    SUM(ISNULL(_RefObjCommon.ReqLevel1, 0)) +
                    SUM(ISNULL(CASE WHEN _RefObjCommon.CodeName128 LIKE '%_A_RARE%' THEN 5 ELSE 0 END, 0)) +
                    SUM(ISNULL(CASE WHEN _RefObjCommon.CodeName128 LIKE '%_B_RARE%' THEN 10 ELSE 0 END, 0)) +
                    SUM(ISNULL(CASE WHEN _RefObjCommon.CodeName128 LIKE '%_C_RARE%' THEN 15 ELSE 0 END, 0))
                ), 0) AS ItemPoints"))

                ->join('_GuildMember', '_GuildMember.GuildID', '=', '_Guild.ID')
                ->join('_Inventory', '_Inventory.CharID', '=', '_GuildMember.CharID')
                ->join('_Items', '_Items.ID64', '=', '_Inventory.ItemID')
                ->join('_RefObjCommon', '_RefObjCommon.ID', '=', '_Items.RefItemID')
                ->leftJoin('_BindingOptionWithItem', function ($join) {
                    $join->on('_BindingOptionWithItem.nItemDBID', '=', '_Items.ID64')
                        ->where('_BindingOptionWithItem.nOptValue', '>', 0)
                        ->where('_BindingOptionWithItem.bOptType', '=', 2);
                })
                ->where('_Inventory.Slot', '<', 13)
                ->where('_Inventory.Slot', '!=', 8)
                ->where('_Inventory.Slot', '!=', 7)
                ->where('_Inventory.ItemID', '>', 0)
                ->groupBy(
                    '_Guild.ID',
                    '_Guild.Name',
                    '_Guild.Lvl',
                    '_Guild.GatheredSP'
                )
                ->orderByDesc('ItemPoints')
                ->orderByDesc('_Guild.Lvl')
                ->orderByDesc('_Guild.GatheredSP')
                ->limit($limit)
                ->get();

        });
    }

    public static function getUniqueRanking($limit = 25)
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });

        if(!empty($unique_list_settings)) {
            foreach ($unique_list_settings as $unique_settings) {
                $settings_uniques_id_list[] = $unique_settings->attributes->ranking_unique_id;
                $settings_uniques_point_list[] = "+ (CASE WHEN _CharUniqueKill.MobID = " . $unique_settings->attributes->ranking_unique_id . " THEN +" . $unique_settings->attributes->ranking_unique_point . " ELSE 0 END)";
            }
            $uniques_id_list = implode(', ', $settings_uniques_id_list);
            $uniques_point_list = implode(' ', $settings_uniques_point_list);

            $uniqueRanking = cache()->remember('unique_ranking', setting('cache_ranking_unique', 600), function() use ($limit, $uniques_id_list, $uniques_point_list) {
                return collect(DB::connection('shard')->select("
                       SELECT TOP (" . $limit . ")
                            _Char.CharID,
                            _Char.CharName16,
                            _Char.CurLevel,
                            _Char.RefObjID,
                            _Guild.ID,
                            _Guild.Name,

                            (SELECT SUM(CAST(
                            " . $uniques_point_list . "
                            AS INT))) AS Points

                        FROM
                            _CharUniqueKill
                            JOIN _Char ON _Char.CharID = _CharUniqueKill.CharID
                            JOIN _Guild ON _Char.GuildID = _Guild.ID

                        WHERE
                            _CharUniqueKill.MobID IN (" . $uniques_id_list . ")
                            AND _Char.deleted = 0
                            AND _Char.CharID > 0

                        GROUP BY
                            _Char.CharID,
                            _Char.CharName16,
                            _Char.CurLevel,
                            _Char.RefObjID,
                            _Guild.ID,
                            _Guild.Name

                        ORDER BY
                            Points DESC
                "
                ));
            });
        }

        if(empty($uniqueRanking)) {
            return null;
        }

        return $uniqueRanking;
    }

    public static function getUniqueMonthlyRanking($limit = 25)
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });

        if(!empty($unique_list_settings)) {
            foreach ($unique_list_settings as $unique_settings) {
                $settings_uniques_id_list[] = $unique_settings->attributes->ranking_unique_id;
                $settings_uniques_point_list[] = "+ (CASE WHEN _CharUniqueKill.MobID = " . $unique_settings->attributes->ranking_unique_id . " THEN +" . $unique_settings->attributes->ranking_unique_point . " ELSE 0 END)";
            }
            $uniques_id_list = implode(', ', $settings_uniques_id_list);
            $uniques_point_list = implode(' ', $settings_uniques_point_list);

            $uniqueRanking = cache()->remember('unique_monthly_ranking', setting('cache_ranking_unique', 600), function() use ($limit, $uniques_id_list, $uniques_point_list) {
                return collect(DB::connection('shard')->select("
                       SELECT TOP (" . $limit . ")
                            _Char.CharID,
                            _Char.CharName16,
                            _Char.CurLevel,
                            _Char.RefObjID,
                            _Guild.ID,
                            _Guild.Name,

                            (SELECT SUM(CAST(
                            " . $uniques_point_list . "
                            AS INT))) AS Points

                        FROM
                            _CharUniqueKill
                            JOIN _Char ON _Char.CharID = _CharUniqueKill.CharID
                            JOIN _Guild ON _Char.GuildID = _Guild.ID

                        WHERE
                            _CharUniqueKill.MobID IN (" . $uniques_id_list . ")
                            AND _CharUniqueKill.EventDate >= DATEADD(m, DATEDIFF(m, 0, GETDATE()), 0)
                            AND _Char.deleted = 0
                            AND _Char.CharID > 0

                        GROUP BY
                            _Char.CharID,
                            _Char.CharName16,
                            _Char.CurLevel,
                            _Char.RefObjID,
                            _Guild.ID,
                            _Guild.Name

                        ORDER BY
                            Points DESC
                "
                ));
            });
        }

        if(empty($uniqueRanking)) {
            return null;
        }

        return $uniqueRanking;
    }

    public static function getCharInfo($charID)
    {
        $charInfo = cache()->remember('char_info_' . $charID, setting('cache_info_char', 600), function() use ($charID) {
            return collect(DB::connection('shard')->select("
                SELECT
                    CharName16, NickName16, GuildID, RefObjID, CurLevel, HwanLevel, RemainGold, HP, MP, Strength, Intellect, LastLogout, _Guild.ID, (_Guild.Name) AS GuildName, _UserTradeConflictJob.JobType, _CharTradeConflictJob.JobLevel,

					(SUM(_Items.OptLevel)
					+ SUM(_RefObjItem.ItemClass)
					+ SUM(_RefObjCommon.Rarity)
					+ SUM(CASE WHEN _BindingOptionWithItem.nItemDBID IS NULL THEN 0 ELSE _BindingOptionWithItem.nOptValue END))
					AS ItemPoints

                FROM
                    _Char
                    INNER JOIN _Guild ON _Char.GuildID = _Guild.ID
                    INNER JOIN _Inventory ON _Char.CharID = _Inventory.CharID
                    INNER JOIN _Items ON _Inventory.ItemID = _Items.ID64
					INNER JOIN _RefObjCommon WITH (NOLOCK) ON _Items.RefItemID = _RefObjCommon.ID
					INNER JOIN _RefObjItem WITH (NOLOCK) ON _RefObjCommon.Link = _RefObjItem.ID
                    LEFT OUTER JOIN _BindingOptionWithItem ON _Inventory.ItemID = _BindingOptionWithItem.nItemDBID

                    LEFT OUTER JOIN SILKROAD_R_SHARD.._CharTradeConflictJob WITH (NOLOCK) ON _CharTradeConflictJob.CharID = _Char.CharID
                    INNER JOIN SILKROAD_R_SHARD.._User WITH (NOLOCK) ON _User.CharID = _Char.CharID
                    INNER JOIN SILKROAD_R_SHARD.._UserTradeConflictJob WITH (NOLOCK) ON _UserTradeConflictJob.UserJID = _User.UserJID

                WHERE
                    _Inventory.Slot IN(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
                    and _Inventory.ItemID > 0
                    AND _Char.CharID = " . $charID . "

                GROUP BY
                    _Char.CharID,
                    _Char.CharName16,
                    _Char.NickName16,
                    _Char.CurLevel,
                    _Char.RefObjID,
                    _Char.GuildID,
                    _Char.HwanLevel,
                    _Char.RemainGold,
                    _Char.HP,
                    _Char.MP,
                    _Char.Strength,
                    _Char.Intellect,
                    _Char.LastLogout,
                    _Guild.ID,
                    _Guild.Name,
                    _UserTradeConflictJob.JobType,
                    _CharTradeConflictJob.JobLevel

                ORDER BY
                    ItemPoints DESC,
                    _Char.CurLevel DESC
            "
            ))->first();
        });

        if(empty($charInfo)) {
            return null;
        }

        return $charInfo;
    }

    public static function getCharUniqueHistory($charID)
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });
        if(!empty($unique_list_settings)) {
            foreach ($unique_list_settings as $unique_list) {
                $uniques_id_lists[] = $unique_list->attributes->ranking_unique_id;
            }

            $uniques_id_list = implode(', ', $uniques_id_lists);
            $charUniqueHistory = cache()->remember('char_unique_history_' . $charID, setting('cache_info_char', 600), function() use ($uniques_id_list, $charID) {
                return collect(DB::connection('shard')->select("SELECT * FROM _CharUniqueKill WHERE CharID = " . $charID . " AND MobID IN (" . $uniques_id_list . ") ORDER BY EventDate DESC"));
            });
        }

        if(empty($charUniqueHistory)) {
            return null;
        }

        return $charUniqueHistory;
    }

    public static function getCharBuildInfo($charID)
    {
        $charBuildInfo = cache()->remember('char_info_build_' . $charID, setting('cache_info_char', 600), function() use ($charID) {
            return collect(DB::connection('shard')->select("SELECT * FROM _CharSkillMastery WHERE Level > 0 AND CharID = " . $charID));
        });

        if(empty($charBuildInfo)) {
            return null;
        }

        return $charBuildInfo;
    }

    public static function getCharGlobalHistory($charName)
    {
        $charGlobalHistory = cache()->remember('char_global_history_' . $charName, setting('cache_info_char', 600), function() use ($charName) {
            return collect(DB::connection('log')->select("SELECT * FROM _LogChatMessage WHERE TargetName = '[YELL]' AND CharName COLLATE Latin1_General_CI_AS = '" . $charName . "'"));
        });

        if(empty($charGlobalHistory)) {
            return null;
        }

        return $charGlobalHistory;
    }

    public static function getFortressPlayerRanking($limit = 25)
    {
        $fortressPlayerRanking = cache()->remember('fortress_player_ranking', setting('cache_fortress_player', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.RefObjID, _GuildMember.GuildWarKill, _GuildMember.GuildWarKilled

                    FROM
                        _GuildMember
						JOIN _Char ON _Char.CharID = _GuildMember.CharID

                    WHERE
                        _Char.deleted = 0
                        AND _Char.CharID > 0

                    GROUP BY
                        _Char.CharID,
                        _Char.CharName16,
                        _Char.CurLevel,
                        _Char.RefObjID,
						_GuildMember.GuildWarKill,
						_GuildMember.GuildWarKilled

                    ORDER BY
                        _GuildMember.GuildWarKill DESC
            "));
        });

        if(empty($fortressPlayerRanking)) {
            return null;
        }

        return $fortressPlayerRanking;
    }

    public static function getFortressGuildRanking($limit = 25)
    {
        $fortressGuildRanking = cache()->remember('fortress_guild_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                         _Guild.ID, _Guild.Name,

                        (SELECT SUM(GuildWarKill) from _GuildMember WHERE GuildID = _Guild.ID) AS TotalKills,
						(SELECT SUM(GuildWarKilled) from _GuildMember WHERE GuildID = _Guild.ID) AS TotalDeath

                    FROM
                        _Guild
                        JOIN _GuildMember ON _Guild.ID = _GuildMember.GuildID

                    WHERE
                        _Guild.ID > 0

                    GROUP BY
                        _Guild.ID,
                        _Guild.Name

                    ORDER BY
                        TotalKills DESC
            "));
        });

        if(empty($fortressGuildRanking)) {
            return null;
        }

        return $fortressGuildRanking;
    }

    public static function getFortressHistoryRanking($limit = 25)
    {
        $fortressHistoryRanking = cache()->remember('fortress_history_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('log')->select("
                    SELECT TOP(" . $limit . ") FortressID, EventTime, strDesc FROM _LogEventSiegeFortress WHERE EventID = 3 ORDER BY EventTime DESC
            "));
        });

        if(empty($fortressHistoryRanking)) {
            return null;
        }

        return $fortressHistoryRanking;
    }

    public static function getHonorRanking($limit = 25)
    {
        $honorRanking = cache()->remember('honor_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID,
                        _Char.RefObjID,
                        _Char.CharName16,
                        _Guild.ID,
                        _Guild.Name,
                        _TrainingCampHonorRank.Rank,
                        _TrainingCamp.GraduateCount,
                        _TrainingCampMember.HonorPoint,
                        _TrainingCamp.EvaluationPoint,
                        _RefObjCommon.CodeName128

                        FROM
                            SILKROAD_R_SHARD.dbo._TrainingCampHonorRank
                            JOIN SILKROAD_R_SHARD.dbo._TrainingCampMember ON _TrainingCampHonorRank.CampID = _TrainingCampMember.CampID
                            JOIN SILKROAD_R_SHARD.dbo._Char ON _TrainingCampMember.CharID = _Char.CharID
                            JOIN SILKROAD_R_SHARD.dbo._RefObjCommon ON _TrainingCampMember.RefObjID = _RefObjCommon.ID
                            JOIN SILKROAD_R_SHARD.dbo._Guild ON _Guild.ID = _Char.GuildID
                            JOIN SILKROAD_R_SHARD.dbo._TrainingCamp ON _TrainingCampMember.CampID = _TrainingCamp.ID

                        WHERE
                            _TrainingCampMember.MemberClass = 0
                            AND _Char.deleted = 0
                            AND _Char.CharID > 0

                        ORDER BY
                            _TrainingCamp.EvaluationPoint DESC,
                            _TrainingCamp.GraduateCount DESC,
                            _TrainingCampMember.HonorPoint DESC
            "));
        });

        if(empty($honorRanking)) {
            return null;
        }

        return $honorRanking;
    }

    public static function getJobRanking($limit = 25)
    {
        $jobRanking = cache()->remember('job_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.NickName16, _Char.RefObjID, _UserTradeConflictJob.JobType, _CharTradeConflictJob.JobLevel, _CharTradeConflictJob.JobExp
                    FROM
                        SILKROAD_R_SHARD.._CharTradeConflictJob WITH (NOLOCK)
                        INNER JOIN SILKROAD_R_SHARD.._Char WITH (NOLOCK) ON _Char.CharID = _CharTradeConflictJob.CharID
                        INNER JOIN SILKROAD_R_SHARD.._User WITH (NOLOCK) ON _User.CharID = _Char.CharID
                        INNER JOIN SILKROAD_R_SHARD.._UserTradeConflictJob WITH (NOLOCK) ON _UserTradeConflictJob.UserJID = _User.UserJID

                    WHERE
                        _Char.deleted = 0
                        AND _Char.CharID > 0
                        AND _UserTradeConflictJob.JobType > 0

                    ORDER BY
                        _CharTradeConflictJob.JobLevel DESC,
                        _CharTradeConflictJob.JobExp DESC
            "));
        });

        if(empty($jobRanking)) {
            return null;
        }

        return $jobRanking;
    }

    public static function getJobTraderRanking($limit = 25)
    {
        $jobTraderRanking = cache()->remember('job_trader_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.NickName16, _Char.RefObjID, _UserTradeConflictJob.JobType, _CharTradeConflictJob.JobLevel, _CharTradeConflictJob.JobExp
                    FROM
                        SILKROAD_R_SHARD.._CharTradeConflictJob WITH (NOLOCK)
                        INNER JOIN SILKROAD_R_SHARD.._Char WITH (NOLOCK) ON _Char.CharID = _CharTradeConflictJob.CharID
                        INNER JOIN SILKROAD_R_SHARD.._User WITH (NOLOCK) ON _User.CharID = _Char.CharID
                        INNER JOIN SILKROAD_R_SHARD.._UserTradeConflictJob WITH (NOLOCK) ON _UserTradeConflictJob.UserJID = _User.UserJID

                    WHERE
                        _Char.deleted = 0
                        AND _Char.CharID > 0
                        AND _UserTradeConflictJob.JobType = 3

                    ORDER BY
                        _CharTradeConflictJob.JobLevel DESC,
                        _CharTradeConflictJob.JobExp DESC
            "));
        });

        if(empty($jobTraderRanking)) {
            return null;
        }

        return $jobTraderRanking;
    }

    public static function getJobHunterRanking($limit = 25)
    {
        $jobHunterRanking = cache()->remember('job_hunter_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.NickName16, _Char.RefObjID, _UserTradeConflictJob.JobType, _CharTradeConflictJob.JobLevel, _CharTradeConflictJob.JobExp
                    FROM
                        SILKROAD_R_SHARD.._CharTradeConflictJob WITH (NOLOCK)
                        INNER JOIN SILKROAD_R_SHARD.._Char WITH (NOLOCK) ON _Char.CharID = _CharTradeConflictJob.CharID
                        INNER JOIN SILKROAD_R_SHARD.._User WITH (NOLOCK) ON _User.CharID = _Char.CharID
                        INNER JOIN SILKROAD_R_SHARD.._UserTradeConflictJob WITH (NOLOCK) ON _UserTradeConflictJob.UserJID = _User.UserJID

                    WHERE
                        _Char.deleted = 0
                        AND _Char.CharID > 0
                        AND _UserTradeConflictJob.JobType = 2

                    ORDER BY
                        _CharTradeConflictJob.JobLevel DESC,
                        _CharTradeConflictJob.JobExp DESC
            "));
        });

        if(empty($jobHunterRanking)) {
            return null;
        }

        return $jobHunterRanking;
    }

    public static function getJobThieveRanking($limit = 25)
    {
        $jobThieveRanking = cache()->remember('job_thieve_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::connection('shard')->select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.NickName16, _Char.RefObjID, _UserTradeConflictJob.JobType, _CharTradeConflictJob.JobLevel, _CharTradeConflictJob.JobExp
                    FROM
                        SILKROAD_R_SHARD.._CharTradeConflictJob WITH (NOLOCK)
                        INNER JOIN SILKROAD_R_SHARD.._Char WITH (NOLOCK) ON _Char.CharID = _CharTradeConflictJob.CharID
                        INNER JOIN SILKROAD_R_SHARD.._User WITH (NOLOCK) ON _User.CharID = _Char.CharID
                        INNER JOIN SILKROAD_R_SHARD.._UserTradeConflictJob WITH (NOLOCK) ON _UserTradeConflictJob.UserJID = _User.UserJID

                    WHERE
                        _Char.deleted = 0
                        AND _Char.CharID > 0
                        AND _UserTradeConflictJob.JobType = 1

                    ORDER BY
                        _CharTradeConflictJob.JobLevel DESC,
                        _CharTradeConflictJob.JobExp DESC
            "));
        });

        if(empty($jobThieveRanking)) {
            return null;
        }

        return $jobThieveRanking;
    }

    public function getGuildMemberUser()
    {
        return $this->hasOne(GuildMember::class, 'CharID', 'CharID');
    }

    public function getGuildUser()
    {
        $query = $this->hasOne(Guild::class, 'ID', 'GuildID');
        $query->where('ID', '!=', 0);
        return $query;
    }

    public function getAccountUser()
    {
        return $this->belongsTo(User::class, 'CharID', 'CharID');
    }
}
