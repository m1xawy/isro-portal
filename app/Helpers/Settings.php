<?php

use Outl1ne\NovaSettings\Models\Settings;

if (!function_exists('setting')) {
    function setting($settingKey, $default = null)
    {
        $setting = Settings::where('key', $settingKey)->get()->first();
        return isset($setting) ? $setting->value : null;
    }
}
