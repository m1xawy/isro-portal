<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Boolean;
use Outl1ne\NovaSettings\NovaSettings;

class Register
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                Boolean::make('Register Page Disable', 'register_disable'),
                Boolean::make('Google reCAPTCHA Enable', 'register_reraptcha_enable'),
                Boolean::make('Email Confirmation Enable', 'register_confirmation_enable'),
            ], [], 'Registration'),
        ];
    }
}
