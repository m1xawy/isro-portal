<?php

namespace App\Providers;

use AlexAzartsev\Heroicon\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\NovaSettings\NovaSettings;
use Outl1ne\PageManager\PageManager;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::footer(function ($request) {
            return Blade::render('
                <div class="mt-8 leading-normal text-xs text-gray-500 space-y-1">
                    <p class="text-center">© 2023 ' . setting('server_name', config('app.name', 'Laravel')) . '  · Coded by <a class="link-default" href="https://mix-shop.tech/">m1xawy</a>.</p>
                </div>
            ');
        });

        //Heroicon::registerGlobalIconSet('social', 'Social Icons', resource_path('img/icons'));

        new \App\Nova\Settings\General;
        new \App\Nova\Settings\Widgets;
        new \App\Nova\Settings\Register;
        new \App\Nova\Settings\Ranking;
        new \App\Nova\Settings\Donate;
        new \App\Nova\Settings\Caching;
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->role == 'admin';
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new PageManager,
            new NovaSettings,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
