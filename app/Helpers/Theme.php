<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Qirolab\Theme\Theme;

/*
function setTheme()
{
    $getThemeSetting = DB::table("dbo.nova_settings")->select("value")->where("key","site_theme")->value('value');
    $getTheme = is_null($getThemeSetting) ? 'default' : $getThemeSetting;

    return Theme::set($getTheme);
}
*/
