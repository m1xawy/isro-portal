<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('getCache')) {
    function getCache($key, $value, $seconds = 600)
    {
        return Cache::remember($key, $seconds, function () use ($value) {
            return $value;
        });
    }
}
