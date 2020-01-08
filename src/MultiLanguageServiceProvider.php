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

        if (config('lang.enable') !== TRUE) {
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
        foreach (config('lang', []) as $item) {
            if (is_array($item)) {
                $path = trim(Arr::get($item, 'path'), '/');
                $path = $path ? "/{$path}/locale" : "/locale";
                Route::post($path, MultiLanguageController::class.'@locale');
            }
        }
    }
}
