<?php

namespace App\Providers;

use App\Models\SRO\Shard\Char;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            $view->with('event_schedule', getServerTimes());
        });
        View::composer('layouts.sidebar', function ($view) {
            $view->with('fortress_war', getFortress());
        });
        View::composer('layouts.sidebar', function ($view) {
            $view->with('global_history', getGlobalHistory());
        });
        View::composer('layouts.sidebar', function ($view) {
            $view->with('unique_history', getFullUniqueHistory());
        });
        View::composer('layouts.sidebar', function ($view) {
            $view->with('online_counter', getOnlineCount());
        });
        View::composer('layouts.sidebar', function ($view) {
            $view->with('top_player', Char::getPlayerRanking(5));
        });
        View::composer('layouts.sidebar', function ($view) {
            $view->with('top_guild', Char::getGuildRanking(5));
        });
    }
}
