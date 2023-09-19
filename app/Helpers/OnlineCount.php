<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getOnlineCount')) {
    function getOnlineCount()
    {
        $OnlineUser = DB::connection('account')->table("dbo._ShardCurrentUser")->select("nUserCount")->orderBy("nID", "desc")->value("nUserCount");
        return is_null($OnlineUser) ? 0 : $OnlineUser;
    }
}
