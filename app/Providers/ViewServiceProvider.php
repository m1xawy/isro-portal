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
                $event_schedule = Cache::remember('event_schedule', config('global.general.cache.data.event_schedule'), function () {
                    return getServerTimes();
                });

                View::composer('layouts.sidebar', function ($view) use ($event_schedule) {
                    $view->with('event_schedule', $event_schedule);
                });
            }
            if(config('global.widgets.fortress_war.enable')) {
                $fortress_war = Cache::remember('fortress_war', config('global.general.cache.data.fortress_war'), function () {
                    return getFortress();
                });

                View::composer('layouts.sidebar', function ($view) use ($fortress_war) {
                    $view->with('fortress_war', $fortress_war);
                });
            }
            if(config('global.widgets.globals_history.enable')) {
                $globals_history = Cache::remember('globals_history', config('global.general.cache.data.globals_history'), function () {
                    return getGlobalHistory();
                });

                View::composer('layouts.sidebar', function ($view) use ($globals_history) {
                    $view->with('globals_history', $globals_history);
                });
            }
            if(config('global.widgets.unique_history.enable')) {
                $unique_history = Cache::remember('unique_history', config('global.general.cache.data.unique_history'), function () {
                    return getFullUniqueHistory();
                });

                View::composer('layouts.sidebar', function ($view) use ($unique_history) {
                    $view->with('unique_history', $unique_history);
                });
            }
            if(config('global.widgets.online_counter.enable')) {
                $online_counter = Cache::remember('online_counter', config('global.general.cache.data.online_counter'), function () {
                    return getOnlineCount();
                });

                View::composer('layouts.sidebar', function ($view) use ($online_counter) {
                    $view->with('online_counter', $online_counter);
                });
            }
            if(config('global.widgets.top_player.enable')) {
                $top_player = Cache::remember('top_player', config('global.general.cache.data.ranking_player'), function () {
                    return Char::getPlayerRanking(5);
                });

                View::composer('layouts.sidebar', function ($view) use ($top_player) {
                    $view->with('top_player', $top_player);
                });
            }
            if(config('global.widgets.top_guild.enable')) {
                $top_guild = Cache::remember('top_guild', config('global.general.cache.data.ranking_guild'), function () {
                    return Char::getGuildRanking(5);
                });

                View::composer('layouts.sidebar', function ($view) use ($top_guild) {
                    $view->with('top_guild', $top_guild);
                });
            }

        } catch (QueryException $e) {
            // Error: Something Wrong.
        }
    }
}
