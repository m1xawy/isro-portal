<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getGlobalHistory')) {
    function getGlobalHistory($limit = 5)
    {
        return DB::connection('log')->table("_LogChatMessage")->orderBy('EventTime', 'DESC')->take($limit)->get();
    }
}
