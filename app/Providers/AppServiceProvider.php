<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {

        if(env('APP_ENV') !== 'local')
        {
            $url->forceSchema('https');
        }

        View::composer('*', function ($view) {
            $view->with('user_info', Auth::user());
        });

    }
}
