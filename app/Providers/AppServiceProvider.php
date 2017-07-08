<?php

namespace App\Providers;

use App\Facades\SkyScannerFacade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sky.utils', function () {
            $api_key = env('SKYSCANNER_API_KEY', 'ah157133207656443122789513994939');

            return new SkyScannerFacade($api_key);
        });
    }
}
