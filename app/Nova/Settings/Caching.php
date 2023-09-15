<?php

namespace App\Nova\Settings;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Outl1ne\NovaSettings\NovaSettings;

class Caching
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                Number::make('Settings', 'cache_setting')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),
                Number::make('News', 'cache_news')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),
                Number::make('Download', 'cache_download')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),

                Number::make('Player Ranking', 'cache_ranking_player')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),
                Number::make('Guild Ranking', 'cache_ranking_guild')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),
                Number::make('Unique Ranking', 'cache_ranking_unique')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),

                Number::make('Character Information', 'cache_info_char')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),
                Number::make('Guild Information', 'cache_info_guild')->help('For example, if you write 3600, your page data will be cached for 60 minutes'),
            ], [], 'Cache Settings'),
        ];
    }
}
