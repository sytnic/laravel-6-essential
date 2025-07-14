<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Регистрация классов, которые нужно сделать доступными 
     * и которые не зависят от других классов.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Libraries\NotificationsInterface', function($app) {
            return new \App\Libraries\Notifications();
        });
    }

    /**
     * Bootstrap any application services.
     * Определяет классы, которые нужно сделать доступными 
     * и которые зависят от других классов для получения информации.
     * 
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
