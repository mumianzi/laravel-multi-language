<?php

namespace Deepcode\MultiLanguage;

use Deepcode\MultiLanguage\Http\Controllers\MultiLanguageController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Deepcode\MultiLanguage\Widgets\LanguageMenu;
use Deepcode\MultiLanguage\Middlewares\MultiLanguageMiddleware;

class MultiLanguageServiceProvider extends ServiceProvider
{

    public function register()
    {
        app('router')->aliasMiddleware('lang', MultiLanguageMiddleware::class);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'multi-language');
        }

        if ( ! MultiLanguage::enabled()) {
            return;
        }
        $this->loadRoutes();

        $this->loadViewsFrom(MultiLanguage::$views, 'multi-language');
    }

    public function loadRoutes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }
        if ($providers = config('lang.providers', [])) {
            $baseMiddleware = config('lang.middleware', []);
            $baseMiddleware = $this->transMiddleware($baseMiddleware);
            foreach ($providers as $item) {
                if (is_array($item)) {
                    $path = trim(Arr::get($item, 'path'), '/');
                    $path = $path ? "/{$path}/locale" : "/locale";
                    $middleware = array_merge($baseMiddleware, $this->transMiddleware(Arr::get($item, 'middleware')));
                    Route::post($path, MultiLanguageController::class.'@locale')->middleware($middleware);
                }
            }
        }
    }

    private function transMiddleware($value)
    {
        return is_string($value) ? explode(',', $value) : (is_array($value) ? $value : []);
    }
}
