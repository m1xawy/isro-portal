<?php

namespace App\Nova\Settings;

use AlexAzartsev\Heroicon\Heroicon;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSettings\NovaSettings;
use Whitecube\NovaFlexibleContent\Flexible;

class Ranking
{
    public function __construct()
    {
        return [
            NovaSettings::addSettingsFields([
                Boolean::make('Player Ranking Enable', 'ranking_player_enable'),
                Boolean::make('Guild Ranking Enable', 'ranking_guild_enable'),
                Boolean::make('Unique Ranking Enable', 'ranking_unique_enable'),

                Flexible::make('Ranking Unique List', 'ranking_unique_list')
                    ->addLayout('Ranking Add Unique', 'ranking_unique_add', [
                        Text::make('Unique Name', 'ranking_unique_name')->help('For example, Tiger Girl'),
                        Text::make('Unique Code', 'ranking_unique_code')->help('For example, "MOB_CH_TIGERWOMAN"'),
                        Text::make('Unique ID', 'ranking_unique_id')->help('For example, "1954"'),
                        Text::make('Unique Points', 'ranking_unique_point')->help('For example, "5"'),
                    ]),
            ], [], 'Ranking'),
        ];
    }
}
