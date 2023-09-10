<?php

namespace App\Providers;

use App\Models\Backlink;
use App\Models\Slider;
use App\Models\Social;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $sliders = Slider::all();
        $socials = Social::all();
        $backlinks = Backlink::all();

        View::share('sliders', $sliders);
        View::share('socials', $socials);
        View::share('backlinks', $backlinks);
    }
}
