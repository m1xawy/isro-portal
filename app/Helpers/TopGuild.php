<?php

use App\Models\SRO\Shard\Char;

if (!function_exists('getTopGuild')) {
    function getTopGuild()
    {
        return Char::getGuildRanking();
    }
}
