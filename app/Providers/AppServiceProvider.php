<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\TelegramService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // регистрация класса в качестве сервис-контейнера
        $this->app->bind(TelegramService::class, function ($app) {
            return new TelegramService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
