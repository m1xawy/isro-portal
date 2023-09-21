<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Qirolab\Theme\Theme;

$getThemeSetting = DB::table("dbo.nova_settings")->select("value")->where("key","site_theme")->value('value');
$getTheme = is_null($getThemeSetting) ? 'default' : $getThemeSetting;

Theme::set($getTheme);

if (!function_exists('themes')) {
    function themes($path)
    {
        return Theme::path().$path;
    }
}
