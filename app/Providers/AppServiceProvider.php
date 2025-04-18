<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
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
        //Databases
        Config::set('database.connections.sqlsrv.host', config('global.general.connection.host'));
        Config::set('database.connections.sqlsrv.port', config('global.general.connection.port'));
        Config::set('database.connections.sqlsrv.username', config('global.general.connection.user'));
        Config::set('database.connections.sqlsrv.password', config('global.general.connection.password'));
        Config::set('database.connections.sqlsrv.database', config('global.general.connection.db_website'));
        //SRO
        Config::set('database.connections.web.database', config('global.general.connection.db_website'));
        Config::set('database.connections.portal.database', config('global.general.connection.db_portal'));
        Config::set('database.connections.account.database', config('global.general.connection.db_account'));
        Config::set('database.connections.shard.database', config('global.general.connection.db_shard'));
        Config::set('database.connections.log.database', config('global.general.connection.db_log'));

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role?->is_admin;
        });

        date_default_timezone_set(config('global.general.options.timezone'));

        if (!app()->runningInConsole()) {
            $this->configureApp();
        }
    }

    private function configureApp(): void
    {
        try {
            Theme::set(setting('site_theme', 'default'));

            if(config('global.general.cache.config')){
                $global_config = Cache::remember('global_config', now()->addMinutes(config('global.general.cache.data.global_config')), function () {
                    return array_merge(config('global'), Setting::pluck('value', 'key')->toArray());
                });
            }else {
                $global_config = array_merge(config('global'), Setting::pluck('value', 'key')->toArray());
            }
            Config::set('settings', $global_config);
            //dd(config('settings'));

            //General
            Config::set('mail.default', config('settings.general.smtp.enable') ? 'smtp' : 'log');

            //Captcha
            Config::set('captcha.sitekey', config('settings.general.captcha.sitekey'));
            Config::set('captcha.secret', config('settings.general.captcha.secret'));

            //Paypal
            Config::set('paypal.mode', config('settings.donation.paypal.api.mode'));
            Config::set('paypal.sandbox.clientId', config('settings.donation.paypal.api.sandbox.clientId'));
            Config::set('paypal.sandbox.secret', config('settings.donation.paypal.api.sandbox.secret'));
            Config::set('paypal.live.clientId', config('settings.donation.paypal.api.live.clientId'));
            Config::set('paypal.live.secret', config('settings.donation.paypal.api.live.secret'));
            //MaxiCard
            Config::set('maxicard.key', config('settings.donation.maxicard.api.key'));
            Config::set('maxicard.password', config('settings.donation.maxicard.api.password'));

        } catch (QueryException $e) {
            // Error: Something Error.
        }
    }
}
