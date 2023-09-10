<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\Select;
use Timothyasp\Color\Color;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\NovaSettings\NovaSettings;
use Outl1ne\PageManager\PageManager;
use Alexwenzel\DependencyContainer\HasDependencies;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\ActionHasDependencies;
use AlexAzartsev\Heroicon\Heroicon;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    use HasDependencies;

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
                    <p class="text-center">© 2023 ' . nova_get_setting('server_name', config('app.name', 'Laravel')) . '  · Coded by <a class="link-default" href="https://mix-shop.tech/">m1xawy</a>.</p>
                </div>
            ');
        });

        Heroicon::registerGlobalIconSet('social', 'Social Icons', public_path('/images/icons'));

        NovaSettings::addSettingsFields([
            Text::make('Server Name', 'server_name')->default('Silkroad'),
            Text::make('Description', 'server_desc'),
            Text::make('Server Url', 'server_url'),
            Select::make('Time Zone', 'server_timezone')->options(['UTC' => 'UTC', 'Africa/Cairo' => 'Africa/Cairo']),
            Select::make('Site Language', 'site_lang')->options(['switch' => 'Switch', 'en' => 'English', 'ar' => 'Arabic']),
            Number::make('Max Player', 'server_max_player'),
            Number::make('News Posts limit', 'server_news_limit'),
            Number::make('Discord Server ID', 'server_discord_id'),
            Select::make('Server files', 'server_files_type')->options(['isro' => 'iSRO', 'vsro' => 'vSRO']),
            Image::make('Favicon', 'server_favicon'),
            Image::make('Logo', 'server_logo'),
        ], [], 'General');

        NovaSettings::addSettingsFields([
            Select::make('Theme Name', 'theme_name')->options(['default' => 'Default', 'add' => 'Add new']),

            DependencyContainer::make([
                Select::make('Theme Mode', 'theme_mode')->options(['switch' => 'Switch', 'dark' => 'Dark', 'light' => 'Light', 'customize' => 'Customize']),
            ])->dependsOn('theme_name', 'default'),

            DependencyContainer::make([
                Image::make('Background Image', 'color_background_image'),
                Color::make('Background Color', 'color_background')->chrome()->help('default: #111827'),
                Color::make('Navbar Color', 'color_navbar')->chrome()->help('default: #1f2937'),
                Color::make('Footer Color', 'color_footer')->chrome()->help('default: #1f2937'),
                Color::make('Boxes Color', 'color_boxes')->chrome()->help('default: #1f2937'),
                Color::make('Dropdown Color', 'color_dropdown')->chrome()->help('default: #374151'),
                Color::make('Border Color', 'color_border')->chrome()->help('default: #374151'),
                Color::make('Heading Color', 'color_heading')->chrome()->help('default: #f3f4f6'),
                Color::make('Paragraph Color', 'color_paragraph')->chrome()->help('default: #9ca3af'),
                Color::make('Link Color', 'color_link')->chrome()->help('default: #9ca3af'),
                Color::make('Button Background Color', 'color_background_button')->chrome()->help('default: #1f2937'),
                Color::make('Button Color', 'color_button')->chrome()->help('default: #e5e7e'),
                Color::make('Input Color', 'color_input')->chrome()->help('default: #111827'),
                Color::make('Hover Color', 'color_hover')->chrome()->help('default: #1f2937'),
            ])->dependsOn('theme_mode', 'dark')->dependsOn('theme_name', 'default'),
        ], [], 'Appearance');
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
            new NovaSettings,
            new PageManager,
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
