<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getGlobalHistory')) {
    function getGlobalHistory()
    {
        return DB::connection('log')->table("_LogChatMessage")->get();
    }
}
