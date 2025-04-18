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
        try {
            //General
            Config::set('app.name', config('global.general.options.server_name'));
            Config::set('app.url', config('global.general.options.server_url'));
            Config::set('mail.default', config('global.smtp.enable') ? env('MAIL_MAILER', 'smtp') : 'log');

            //Captcha
            Config::set('captcha.sitekey', config('global.captcha.sitekey'));
            Config::set('captcha.secret', config('global.captcha.secret'));

            //Paypal
            Config::set('paypal.mode', config('global.donation.paypal.api.mode'));
            Config::set('paypal.sandbox.clientId', config('global.donation.paypal.api.sandbox.clientId'));
            Config::set('paypal.sandbox.secret', config('global.donation.paypal.api.sandbox.secret'));
            Config::set('paypal.live.clientId', config('global.donation.paypal.api.live.clientId'));
            Config::set('paypal.live.secret', config('global.donation.paypal.api.live.secret'));

            //MaxiCard
            Config::set('maxicard.key', config('global.donation.maxicard.api.key'));
            Config::set('maxicard.password', config('global.donation.maxicard.api.password'));

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

            date_default_timezone_set(config('global.general.options.timezone'));

        } catch (QueryException $e) {
            // Error: Something Wrong.
        }

        if (!app()->runningInConsole()) {
            Theme::set(config('global.general.options.theme'));
        }
    }
}
