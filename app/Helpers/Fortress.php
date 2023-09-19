<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getFortress')) {
    function getFortress()
    {
        return DB::connection('shard')->table("_SiegeFortress as sf")->select(array("sf.FortressID", "sf.GuildID", "sf.TaxRatio", "gu.Name"))->join("_Guild as gu", "sf.GuildID", "=", "gu.ID")->get();
    }
}
