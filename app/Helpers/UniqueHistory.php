<?php

use App\Models\SRO\Shard\Char;
use Illuminate\Support\Facades\DB;

if (!function_exists('getUniqueHistory')) {
    function getUniqueHistory($limit = 5)
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', 600, function() { return json_decode(setting('ranking_unique_list')); });

        if(!empty($unique_list_settings)) {
            foreach ($unique_list_settings as $unique_settings) {
                $settings_uniques_id_list[] = $unique_settings->attributes->ranking_unique_id;
            }
            $uniques_id_list = implode(', ', $settings_uniques_id_list);

            $uniqueHistory = cache()->remember('unique_history', 300, function() use ($limit, $uniques_id_list) {
                return collect(DB::connection('shard')->select("
                       SELECT TOP (". $limit .")
                            _CharUniqueKill.CharID,
							_Char.CharName16,
                            _Char.RefObjID,
                            _CharUniqueKill.MobID,
							_CharUniqueKill.EventDate

                        FROM
                            _CharUniqueKill
                            JOIN _Char ON _Char.CharID = _CharUniqueKill.CharID

                        WHERE
                            _CharUniqueKill.MobID IN (" . $uniques_id_list . ")
                            AND _Char.deleted = 0
                            AND _Char.CharID > 0

						ORDER BY
                            _CharUniqueKill.EventDate DESC
                "
                ));
            });
        }

        if(empty($uniqueHistory)) {
            return null;
        }

        return $uniqueHistory;
    }
}

if (!function_exists('getFullUniqueHistory')) {
    function getFullUniqueHistory($limit = 50)
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', 600, function() { return json_decode(setting('ranking_unique_list')); });

        if(!empty($unique_list_settings)) {
            foreach ($unique_list_settings as $unique_settings) {
                $settings_uniques_code_list[] = $unique_settings->attributes->ranking_unique_code;
            }

            $settings_uniques_code_list_quotes = array_map(function($item) {return "'" . $item . "'";}, $settings_uniques_code_list);
            $uniques_code_list = implode(", ", $settings_uniques_code_list_quotes);

            $fullUniqueHistory = cache()->remember('unique_full_history', 300, function() use ($limit, $uniques_code_list) {
                return collect(DB::connection('log')->select("
                        SELECT TOP (". $limit .")
                            _LogInstanceWorldInfo.CharID,
                            _Char.CharName16,
                            _Char.RefObjID,
                            _LogInstanceWorldInfo.Value,
                            _LogInstanceWorldInfo.WorldID,
							_RefRegion.wRegionID,
                            _RefRegion.AreaName,
                            _LogInstanceWorldInfo.EventTime

                        FROM
                            _LogInstanceWorldInfo
                            LEFT JOIN SILKROAD_R_SHARD.dbo._Char ON _Char.CharID = _LogInstanceWorldInfo.CharID

							--if replaced WorldID with RegionID from _Char in _AddLogInstanceWorldInfo use this file in databases/seeders/_AddLogInstanceWorldInfo.sql
							LEFT JOIN SILKROAD_R_SHARD.dbo._RefRegion ON _RefRegion.wRegionID = _LogInstanceWorldInfo.WorldID

                            --for testing original system, but worldID always recorded by 1
							--LEFT JOIN SILKROAD_R_SHARD.dbo._RefRegion ON _RefRegion.wRegionID = (SELECT TOP (1) _RefInstance_World_Region.RegionID FROM SILKROAD_R_SHARD.dbo._RefInstance_World_Region WHERE _RefInstance_World_Region.WorldID = _LogInstanceWorldInfo.WorldID)

                        WHERE
                            _LogInstanceWorldInfo.Value IN (" . $uniques_code_list . ") AND
                            _LogInstanceWorldInfo.ValueCodeName128 = 'KILL_UNIQUE_MONSTER'

                        ORDER BY
                            _LogInstanceWorldInfo.EventTime DESC
                "
                ));
            });
        }

        if(empty($fullUniqueHistory)) {
            return null;
        }

        return $fullUniqueHistory;
    }
}

if (!function_exists('getUniqueHistoryNames')) {
    function getUniqueHistoryNames()
    {
        $unique_list_settings = cache()->remember('ranking_unique_list_names', 300, function() { return json_decode(setting('ranking_unique_list')); });

        if($unique_list_settings) {
            foreach ($unique_list_settings as $unique_settings) {
                $unique_settings_array[] = $unique_settings->attributes;
                $unique_name = array_column($unique_settings_array, 'ranking_unique_name', 'ranking_unique_id');
            }
        }

        return $unique_name;
    }
}

if (!function_exists('getUniqueHistoryNamesCode')) {
    function getUniqueHistoryNamesCode()
    {
        $unique_list_settings = cache()->remember('ranking_unique_list_names_code', 300, function() { return json_decode(setting('ranking_unique_list')); });

        if($unique_list_settings) {
            foreach ($unique_list_settings as $unique_settings) {
                $unique_settings_array[] = $unique_settings->attributes;
                $unique_name_code = array_column($unique_settings_array, 'ranking_unique_name', 'ranking_unique_code');
            }
        }

        return $unique_name_code;
    }
}
