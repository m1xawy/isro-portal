<?php

use Illuminate\Support\Facades\Artisan;
use Qirolab\Theme\Theme;

if (!function_exists('isEmailConfirmation')) {
    function isEmailConfirmation()
    {
        if (!app()->runningInConsole()) {
            $rce = (setting('register_confirmation_enable', 0) == 1 ? 'verified' : 'throttle');
            Artisan::call('route:clear');

            return $rce;
        }
    }
}
