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

if (!function_exists('getUniqueHistoryNames')) {
    function getUniqueHistoryNames()
    {
        $unique_list_settings = cache()->remember('ranking_unique_list', 300, function() { return json_decode(setting('ranking_unique_list')); });

        if($unique_list_settings) {
            foreach ($unique_list_settings as $unique_settings) {
                $unique_settings_array[] = $unique_settings->attributes;
                $unique_name = array_column($unique_settings_array, 'ranking_unique_name', 'ranking_unique_id');
            }
        }

        return $unique_name;
    }
}
