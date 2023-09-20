<?php

use Illuminate\Support\Facades\DB;
use Qirolab\Theme\Theme;

$getThemeSetting = DB::table("dbo.nova_settings")->select("value")->where("key","site_theme")->value('value');
$getTheme = is_null($getThemeSetting) ? 'default' : $getThemeSetting;

Theme::set($getTheme);
