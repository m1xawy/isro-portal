<?php

namespace App\Providers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Inertia\Ssr\Gateway;
use Qirolab\Theme\Theme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureApp();

        if (!app()->runningInConsole()) {
            Theme::set(config('global.general.options.theme'));
        }
    }

    private function configureApp(): void
    {
        try {
            Config::set('app.name', config('global.general.options.server_name'));
            Config::set('app.url', config('global.general.options.server_url'));
            Config::set('mail.default', config('global.smtp.enable') ? env('MAIL_MAILER', 'smtp') : 'log');

            date_default_timezone_set(config('global.general.options.timezone'));

        } catch (QueryException $e) {
            // Error: Something Wrong.
        }
    }
}
