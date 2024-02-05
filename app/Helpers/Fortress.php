<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getFortress')) {
    function getFortress()
    {
        return DB::connection('shard')->table("_SiegeFortress")->select(array("FortressID", "GuildID", "TaxRatio", "_Guild.Name"))->join("_Guild", "_SiegeFortress.GuildID", "=", "_Guild.ID")->get();
    }
}
