<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getGlobalHistory')) {
    function getGlobalHistory($limit = 5)
    {
        $globalHistory = cache()->remember('global_history', 300, function() use ($limit) {
            return DB::connection('log')->table("_LogChatMessage")->where('TargetName', '[YELL]')->orderBy('EventTime', 'DESC')->take($limit)->get();
        });

        return is_null($globalHistory) ? null : $globalHistory;
    }
}
