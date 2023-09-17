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
            return collect(DB::select("
                        SELECT
                            Name, Lvl, GatheredSP, FoundationDate,

                            (select count (*) from [SILKROAD_R_SHARD].[dbo].[_GuildMember] where GuildID = _Guild.ID) as Members,
                            + (CAST((sum(_Items.OptLevel))
                            + SUM(_RefObjItem.ItemClass)
                            + SUM(_RefObjCommon.Rarity)
                            + (CASE WHEN sum(_BindingOptionWithItem.nOptValue) > 0 THEN sum(_BindingOptionWithItem.nOptValue) ELSE 0 END) as INT))
                            AS ItemPoints

                        FROM
                            SILKROAD_R_SHARD.._Guild
                            JOIN SILKROAD_R_SHARD.._GuildMember ON _Guild.ID = _GuildMember.GuildID
                            JOIN SILKROAD_R_SHARD.._Inventory ON _GuildMember.CharID = _Inventory.CharID
                            JOIN SILKROAD_R_SHARD.._Items ON _Inventory.ItemID = _Items.ID64
                            LEFT JOIN SILKROAD_R_SHARD.._BindingOptionWithItem ON _Inventory.ItemID = _BindingOptionWithItem.nItemDBID
                            JOIN SILKROAD_R_SHARD.._RefObjCommon ON _Items.RefItemID = _RefObjCommon.ID
                            JOIN SILKROAD_R_SHARD.._RefObjItem ON _RefObjCommon.Link = _RefObjItem.ID

                        WHERE
                            _Inventory.Slot between 0 and 12
                            and _Inventory.Slot NOT IN (7, 8)
                            and _Inventory.ItemID > 0
                            AND _Guild.ID = " . $guildID . "

                        GROUP BY
                            _Guild.ID,
                            _Guild.Name,
                            _Guild.Lvl,
                            _Guild.GatheredSP,
                            _Guild.FoundationDate

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
            return collect(DB::select("SELECT * FROM [SILKROAD_R_SHARD].[dbo].[_GuildMember] WHERE GuildID = " . $guildID . " ORDER BY MemberClass ASC,Contribution DESC,GuildWarKill DESC,CharLevel DESC,GP_Donation DESC"));
        });

        if(empty($guildInfoMembers)) {
            return null;
        }

        return $guildInfoMembers;
    }

    public function getGuildInfoAlliance($guildID)
    {
        $guildInfoAlliance = cache()->remember('guild_info_alliance_' . $guildID, setting('cache_info_guild', 600), function() use ($guildID) {
            return collect(DB::select("SELECT Name from [SILKROAD_R_SHARD].[dbo].[_Guild] WHERE Alliance = (SELECT Alliance FROM [SILKROAD_R_SHARD].[dbo].[_Guild] WHERE ID = " . $guildID . ")"));
        });

        if(empty($guildInfoAlliance)) {
            return null;
        }

        return $guildInfoAlliance;
    }
}
