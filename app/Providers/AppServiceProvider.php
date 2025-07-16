<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        Log::info('MAIL DEBUG', [
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'from' => config('mail.from.address'),
            'name' => config('mail.from.name'),
        ]);

        $acceptLang = request()->server('HTTP_ACCEPT_LANGUAGE');
        $locale = substr($acceptLang, 0, 2);

        if (in_array($locale, ['en', 'fr', 'es'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('en');
        }

        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });
    }
}
