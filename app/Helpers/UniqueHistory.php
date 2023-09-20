<?php

use App\Models\SRO\Shard\Char;

if (!function_exists('getUniqueHistory')) {
    function getUniqueHistory()
    {
        return Char::getUniqueHistory();
    }
}
