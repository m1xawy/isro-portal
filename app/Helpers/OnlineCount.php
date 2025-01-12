<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getOnlineCount')) {
    function getOnlineCount()
    {
        $OnlineUser = cache()->remember('online_count', 300, function() {
                return DB::connection('account')->table("dbo._ShardCurrentUser")->select("nUserCount")->orderBy("nID", "desc")->take(1)->get()->value("nUserCount");
        });

        return is_null($OnlineUser) ? 0 : $OnlineUser;
    }
}
