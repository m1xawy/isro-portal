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
                Boolean::make('Register Page Enable', 'register_enable'),
            ], [], 'Registration'),
        ];
    }
}
