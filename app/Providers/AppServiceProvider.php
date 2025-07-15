<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\JWTAuthRepositoryInterface::class,
            \App\Repositories\JWTAuthRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $acceptLang = request()->server('HTTP_ACCEPT_LANGUAGE');
        $locale = substr($acceptLang, 0, 2);

        if (in_array($locale, ['en', 'fr', 'es'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('en');
        }
    }
}
