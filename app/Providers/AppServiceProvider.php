<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Resend\Resend as ResendClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::preventLazyLoading(app()->isProduction());
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
