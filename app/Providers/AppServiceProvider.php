<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Providers\MyUserProvider;

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
        Vite::prefetch(concurrency: 3);

        Auth::provider('my-auth', function ($app, array $config) {
            return new MyUserProvider();
        });

        Auth::extend('external-api', function ($app, $name, array $config) {
            return new \Illuminate\Auth\SessionGuard($name, Auth::createUserProvider($config['provider']), $app['session.store']);
        });
    }
}
