<?php

namespace App\Providers;

use App\Models\Pages;
use App\Models\SRO\Account\ShardCurrentUser;
use App\Models\SRO\Log\LogChatMessage;
use App\Models\SRO\Log\LogInstanceWorldInfo;
use App\Models\SRO\Shard\Char;
use App\Models\SRO\Shard\Guild;
use App\Models\SRO\Shard\SiegeFortress;
use App\Services\ScheduleService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            if(config('settings.widgets.event_schedule.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('event_schedule', ScheduleService::getEventSchedules());
                });
            }
            if(config('settings.widgets.fortress_war.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('fortress_war', SiegeFortress::getFortress());
                });
            }
            if(config('settings.widgets.globals_history.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('globals_history', LogChatMessage::getGlobalsHistory(5));
                });
            }
            if(config('settings.widgets.unique_history.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('unique_history', LogInstanceWorldInfo::getUniques($limit = 5));
                });
            }
            if(config('settings.widgets.online_counter.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('online_counter', ShardCurrentUser::getOnlineCounter());
                });
            }
            if(config('settings.widgets.top_player.enable')) {
                View::composer(['layouts.sidebar', 'layouts.sidebar-right'], function ($view) {
                    $view->with('top_player', Char::getPlayerRanking(5, 0));
                });
            }
            //Pages
            View::composer(['layouts.header'], function ($view) {
                $view->with('pages', Pages::get());
            });

        } catch (QueryException $e) {
            // Error: Something Wrong.
        }
    }
}
