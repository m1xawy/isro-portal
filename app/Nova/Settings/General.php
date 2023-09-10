<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSettings\NovaSettings;

class General
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                Text::make('Server Name', 'server_name')->default('Silkroad'),
                Text::make('Description', 'server_desc'),
                Text::make('Server Url', 'server_url'),
                Select::make('Time Zone', 'server_timezone')->options(['UTC' => 'UTC', 'Africa/Cairo' => 'Africa/Cairo']),
                Select::make('Site Language', 'site_lang')->options(['switch' => 'Switch', 'en' => 'English', 'ar' => 'Arabic']),
                Number::make('Max Player', 'server_max_player'),
                Number::make('News Posts limit', 'server_news_limit'),
                Number::make('Discord Server ID', 'server_discord_id'),
                Select::make('Server files', 'server_files_type')->options(['isro' => 'iSRO', 'vsro' => 'vSRO']),
                Image::make('Favicon', 'server_favicon'),
                Image::make('Logo', 'server_logo'),
            ], [], 'General'),
        ];
    }
}
