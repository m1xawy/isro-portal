<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
