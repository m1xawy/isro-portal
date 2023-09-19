<?php

use App\Models\SRO\Shard\Char;

if (!function_exists('getTopPlayer')) {
    function getTopPlayer()
    {
        return Char::getPlayerRanking();
    }
}
