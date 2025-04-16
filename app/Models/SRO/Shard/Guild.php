<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Guild extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._Guild';

    protected $primaryKey = 'ID';

    protected $fillable = [];

    protected $dates = [
        'FoundationDate'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

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

    public function getGuildInfo($guildID)
    {
        $guildInfo = cache()->remember('guild_info_' . $guildID, setting('cache_info_guild', 600), function() use ($guildID) {
            return collect(DB::connection('shard')->select("
                        SELECT
                            Name, Lvl, GatheredSP, FoundationDate,

                            CONVERT(VARCHAR(MAX), _GuildCrest.CrestBinary, 2) AS Icon,

                            (select count (*) from _GuildMember where GuildID = _Guild.ID) as Members,
                            (select CharName from _GuildMember where Permission = -1 AND GuildID = _Guild.ID) as Leader,

                            (SUM(_Items.OptLevel)
                            + SUM(_RefObjItem.ItemClass)
                            + SUM(_RefObjCommon.Rarity)
                            + SUM(CASE WHEN _BindingOptionWithItem.nItemDBID IS NULL THEN 0 ELSE _BindingOptionWithItem.nOptValue END))
                            AS ItemPoints

                        FROM
                            _Guild
                            INNER JOIN _GuildMember ON _Guild.ID = _GuildMember.GuildID
                            LEFT JOIN _GuildCrest ON _GuildCrest.GuildID = _Guild.ID
                            INNER JOIN _Inventory ON _GuildMember.CharID = _Inventory.CharID
                            INNER JOIN _Items ON _Inventory.ItemID = _Items.ID64
                            INNER JOIN _RefObjCommon WITH (NOLOCK) ON _Items.RefItemID = _RefObjCommon.ID
                            INNER JOIN _RefObjItem WITH (NOLOCK) ON _RefObjCommon.Link = _RefObjItem.ID
                            LEFT OUTER JOIN _BindingOptionWithItem ON _Inventory.ItemID = _BindingOptionWithItem.nItemDBID

                        WHERE
                            _Inventory.Slot IN(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
                            and _Inventory.ItemID > 0
                            AND _Guild.ID = " . $guildID . "

                        GROUP BY
                            _Guild.ID,
                            _Guild.Name,
                            _Guild.Lvl,
                            _Guild.GatheredSP,
                            _Guild.FoundationDate,
                            _GuildCrest.CrestBinary

                        ORDER BY
                            ItemPoints DESC,
                            _Guild.Lvl DESC,
                            _Guild.GatheredSP DESC
            "
            ))->first();
        });

        if(empty($guildInfo)) {
            return null;
        }

        return $guildInfo;
    }

    public function getGuildInfoMembers($guildID)
    {
        $guildInfoMembers = cache()->remember('guild_info_members_' . $guildID, setting('cache_info_guild', 600), function() use ($guildID) {
            return collect(DB::connection('shard')->select("SELECT * FROM _GuildMember WHERE GuildID = " . $guildID . " ORDER BY MemberClass ASC,Contribution DESC,GuildWarKill DESC,CharLevel DESC,GP_Donation DESC"));
        });

        if(empty($guildInfoMembers)) {
            return null;
        }

        return $guildInfoMembers;
    }

    public function getGuildInfoAlliance($guildID)
    {
        $guildInfoAlliance = cache()->remember('guild_info_alliance_' . $guildID, setting('cache_info_guild', 600), function() use ($guildID) {
            return collect(DB::connection('shard')->select("SELECT Name from _Guild WHERE Alliance = (SELECT Alliance FROM _Guild WHERE ID = " . $guildID . " AND Alliance > 0)"));
        });

        if(empty($guildInfoAlliance)) {
            return null;
        }

        return $guildInfoAlliance;
    }
}
