<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getGlobalHistory')) {
    function getGlobalHistory($limit = 5)
    {
        return DB::connection('log')->table("_LogChatMessage")->where('TargetName', '[YELL]')->orderBy('EventTime', 'DESC')->take($limit)->get();
    }
}
