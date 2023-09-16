<?php

use Outl1ne\NovaSettings\NovaSettings;

if (!function_exists('settings')) {
    function settings($settingKeys = null, $defaults = [])
    {
        return NovaSettings::getSettings($settingKeys, $defaults);
    }
}

if (!function_exists('setting')) {
    function setting($settingKey, $default = null)
    {
        return NovaSettings::getSetting($settingKey, $default);
    }
}
