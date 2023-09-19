<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Char extends Model
{
    use HasFactory;

    protected $connection = 'shard';

    public $timestamps = false;

    protected $table = 'dbo._Char';

    protected $primaryKey = 'CharID';

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
        $playerRanking = cache()->remember('player_ranking', setting('cache_ranking_player', 600), function() use ($limit) {
            return collect(DB::select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.CurLevel, _Char.RefObjID, _Guild.ID, _Guild.Name,

                        + (CAST((sum(_Items.OptLevel))
                        + SUM(_RefObjItem.ItemClass)
                        + SUM(_RefObjCommon.Rarity)
                        + (CASE WHEN sum(_BindingOptionWithItem.nOptValue) > 0 THEN sum(_BindingOptionWithItem.nOptValue) ELSE 0 END) as INT))
                        AS ItemPoints

                    FROM
                        SILKROAD_R_SHARD.._Char
                        JOIN SILKROAD_R_SHARD.._Guild ON _Char.GuildID = _Guild.ID
                        JOIN SILKROAD_R_SHARD.._Inventory ON _Char.CharID = _Inventory.CharID
                        JOIN SILKROAD_R_SHARD.._Items ON _Inventory.ItemID = _Items.ID64
                        LEFT JOIN SILKROAD_R_SHARD.._BindingOptionWithItem ON _Inventory.ItemID = _BindingOptionWithItem.nItemDBID
                        JOIN SILKROAD_R_SHARD.._RefObjCommon ON _Items.RefItemID = _RefObjCommon.ID
                        JOIN SILKROAD_R_SHARD.._RefObjItem ON _RefObjCommon.Link = _RefObjItem.ID

                    WHERE
                        _Inventory.Slot between 0 and 12
                        and _Inventory.Slot NOT IN (7, 8)
                        and _Inventory.ItemID > 0
                        and _Char.CharName16 NOT LIKE '%[[]GM]%'
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
                        ItemPoints DESC,
                        _Char.CurLevel DESC
            "
            ));
        });

        if(empty($playerRanking)) {
            return null;
        }

        return $playerRanking;
    }

    public static function getGuildRanking($limit = 25)
    {
        $guildRanking = cache()->remember('guild_ranking', setting('cache_ranking_guild', 600), function() use ($limit) {
            return collect(DB::select("
                    SELECT TOP(" . $limit . ")
                         _Guild.ID, _Guild.Name,  _Guild.Lvl, _Guild.GatheredSP,

                        (select CharID from SILKROAD_R_SHARD.._GuildMember where GuildID = _Guild.ID and MemberClass = 0) as MasterID,
                        (select CharName from SILKROAD_R_SHARD.._GuildMember where GuildID = _Guild.ID and MemberClass = 0) as MasterName,
                        (select COUNT(CharID) from SILKROAD_R_SHARD.._GuildMember where GuildID = _Guild.ID) AS TotalMember,

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
                        AND _Guild.ID > 0

                    GROUP BY
                        _Guild.ID,
                        _Guild.Name,
                        _Guild.Lvl,
                        _Guild.GatheredSP

                    ORDER BY
                        ItemPoints DESC,
                        _Guild.Lvl DESC,
                        _Guild.GatheredSP DESC
            "
            ));
        });

        if(empty($guildRanking)) {
            return null;
        }

        return $guildRanking;
    }

    public function getUniqueRanking($limit = 25)
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
                return collect(DB::select("
                       SELECT TOP (" . $limit . ")
                            _CharUniqueKill.CharID,
                            _CharUniqueKill.MobID,
                            _Char.CharName16,
                            _Char.CurLevel,
                            _Char.RefObjID,
                            _Guild.ID,
                            _Guild.Name,

                            (SELECT SUM(CAST(
                            " . $uniques_point_list . "
                            AS INT))) AS Points

                        FROM
                            SILKROAD_R_SHARD.._CharUniqueKill
                            JOIN SILKROAD_R_SHARD.._Char ON _Char.CharID = _CharUniqueKill.CharID
                            JOIN SILKROAD_R_SHARD.._Guild ON _Char.GuildID = _Guild.ID

                        WHERE
                            _CharUniqueKill.MobID IN (" . $uniques_id_list . ")
                            AND _Char.CharName16 NOT LIKE '%[[]GM]%'
                            AND _Char.deleted = 0
                            AND _Char.CharID > 0

                        GROUP BY
                            _CharUniqueKill.CharID,
                            _CharUniqueKill.MobID,
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

    public function getCharInfo($charID)
    {
        $charInfo = cache()->remember('char_info_' . $charID, setting('cache_info_char', 600), function() use ($charID) {
            return collect(DB::select("
                SELECT
                    CharName16, NickName16, GuildID, RefObjID, CurLevel, HwanLevel, RemainGold, HP, MP, Strength, Intellect, LastLogout,
                    (SELECT Name FROM [SILKROAD_R_SHARD].[dbo].[_Guild] WHERE ID = _Char.GuildID) AS GuildName,
                    + (CAST((sum(_Items.OptLevel))
                    + SUM(_RefObjItem.ItemClass)
                    + SUM(_RefObjCommon.Rarity)
                    + (CASE WHEN sum(_BindingOptionWithItem.nOptValue) > 0 THEN sum(_BindingOptionWithItem.nOptValue) ELSE 0 END) as INT))
                    AS ItemPoints

                FROM
                    SILKROAD_R_SHARD.._Char
                    JOIN SILKROAD_R_SHARD.._Inventory ON _Char.CharID = _Inventory.CharID
                    JOIN SILKROAD_R_SHARD.._Items ON _Inventory.ItemID = _Items.ID64
                    LEFT JOIN SILKROAD_R_SHARD.._BindingOptionWithItem ON _Inventory.ItemID = _BindingOptionWithItem.nItemDBID
                    JOIN SILKROAD_R_SHARD.._RefObjCommon ON _Items.RefItemID = _RefObjCommon.ID
                    JOIN SILKROAD_R_SHARD.._RefObjItem ON _RefObjCommon.Link = _RefObjItem.ID

                WHERE
                    _Inventory.Slot between 0 and 12
                    and _Inventory.Slot NOT IN (7, 8)
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
                    _Char.LastLogout

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

    public function getCharUniqueHistory($charID)
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', setting('cache_ranking_unique', 600), function() { return json_decode(setting('ranking_unique_list')); });
        if(!empty($unique_list_settings)) {
            foreach ($unique_list_settings as $unique_list) {
                $uniques_id_lists[] = $unique_list->attributes->ranking_unique_id;
            }

            $uniques_id_list = implode(', ', $uniques_id_lists);
            $charUniqueHistory = cache()->remember('char_unique_history_' . $charID, setting('cache_info_char', 600), function() use ($uniques_id_list, $charID) {
                return collect(DB::select("SELECT * FROM [SILKROAD_R_SHARD].[dbo].[_CharUniqueKill] WHERE CharID = " . $charID . " AND MobID IN (" . $uniques_id_list . ") ORDER BY EventDate DESC"));
            });
        }

        if(empty($charUniqueHistory)) {
            return null;
        }

        return $charUniqueHistory;
    }

    public function getFortressPlayerRanking($limit = 25)
    {
        $fortressPlayerRanking = cache()->remember('fortress_player_ranking', setting('cache_fortress_player', 600), function() use ($limit) {
            return collect(DB::select("
                    SELECT TOP(" . $limit . ")
                        _Char.CharID, _Char.CharName16, _Char.RefObjID, _GuildMember.GuildWarKill, _GuildMember.GuildWarKilled

                    FROM
                        SILKROAD_R_SHARD.._GuildMember
						JOIN SILKROAD_R_SHARD.._Char ON _Char.CharID = _GuildMember.CharID

                    WHERE
						_Char.CharName16 NOT LIKE '%[[]GM]%'
                        AND _Char.deleted = 0
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

    public function getFortressGuildRanking($limit = 25)
    {
        $fortressGuildRanking = cache()->remember('fortress_guild_ranking', setting('cache_fortress_guild', 600), function() use ($limit) {
            return collect(DB::select("
                    SELECT TOP(" . $limit . ")
                         _Guild.ID, _Guild.Name,

                        (SELECT SUM(GuildWarKill) from SILKROAD_R_SHARD.._GuildMember WHERE GuildID = _Guild.ID) AS TotalKills,
						(SELECT SUM(GuildWarKilled) from SILKROAD_R_SHARD.._GuildMember WHERE GuildID = _Guild.ID) AS TotalDeath

                    FROM
                        SILKROAD_R_SHARD.._Guild
                        JOIN SILKROAD_R_SHARD.._GuildMember ON _Guild.ID = _GuildMember.GuildID

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
