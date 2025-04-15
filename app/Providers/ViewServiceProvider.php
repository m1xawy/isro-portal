<?php

namespace App\Providers;

use App\Models\SRO\Shard\Char;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            if(config('global.widgets.event_schedule.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('event_schedule', getServerTimes());
                });
            }
            if(config('global.widgets.fortress_war.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('fortress_war', getFortress());
                });
            }
            if(config('global.widgets.globals_history.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('globals_history', getGlobalHistory());
                });
            }
            if(config('global.widgets.unique_history.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('unique_history', getFullUniqueHistory());
                });
            }
            if(config('global.widgets.online_counter.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('online_counter', getOnlineCount());
                });
            }
            if(config('global.widgets.top_player.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('top_player', Char::getPlayerRanking(5));
                });
            }
            if(config('global.widgets.top_guild.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('top_guild', Char::getGuildRanking(5));
                });
            }

        } catch (QueryException $e) {
            // Error: Something Wrong.
        }
    }
}
