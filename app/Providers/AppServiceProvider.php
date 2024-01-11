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
            Theme::set(setting('site_theme', 'default'));
        }
    }

    private function configureApp(): void
    {
        try {
            //Config::set('app.name', setting('server_name', env('APP_NAME')));
            //Config::set('app.url', setting('server_url', env('APP_URL')));

            Config::set('mail.default', isEmailConfirmation() == 'verified' ? env('MAIL_MAILER', 'smtp') : 'log');
            //Config::set('mail.mailers.smtp.host', setting('site_mail_host', env('MAIL_HOST', 'smtp')));
            //Config::set('mail.mailers.smtp.port', setting('site_mail_port', env('MAIL_PORT', 'smtp')));
            //Config::set('mail.mailers.smtp.username', setting('site_mail_username', env('MAIL_USERNAME', 'smtp')));
            //Config::set('mail.mailers.smtp.password', setting('site_mail_password', env('MAIL_PASSWORD', 'smtp')));
            //Config::set('mail.mailers.smtp.encryption', setting('site_mail_encryption', env('MAIL_ENCRYPTION', 'smtp')));

        } catch (QueryException $e) {
            // Error: No database configured yet
        }
    }
}
