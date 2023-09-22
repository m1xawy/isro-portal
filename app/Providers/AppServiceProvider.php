<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Qirolab\Theme\Theme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if(DB::connection()) {
            $getThemeSetting = DB::table("dbo.nova_settings")->select("value")->where("key","site_theme")->value('value');
            $getTheme = is_null($getThemeSetting) ? 'default' : $getThemeSetting;

            Theme::set($getTheme);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
