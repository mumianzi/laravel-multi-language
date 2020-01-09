<?php

namespace Deepcode\MultiLanguage\Middlewares;

use Closure;
use Deepcode\MultiLanguage\MultiLanguage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class MultiLanguageMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $args
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$args)
    {
        $provider = ($args[0] ?? NULL) ?: 'default';
        if ($this->setLanguage($request, $provider) !== NULL) {
            view()->share([
                'locale' => [
                    'languages' => config("lang.providers.{$provider}.languages"),
                    'current' => app()->getLocale(),
                    'provider' => $provider,
                    'path' => '/'.trim(config("lang.providers.{$provider}.path"), '/').'/locale',
                ],
            ]);
        }

        return $next($request);
    }

    function setLanguage($request, $provider)
    {
        if ( ! MultiLanguage::enabled($provider)) {
            return NULL;
        }

        $supportLangs = config("lang.providers.{$provider}.languages", []);

        $lang = NULL;

        if ( ! MultiLanguage::isApi($provider)) {
            $lang = Cookie::has('language') ? Cookie::get('language') : $lang;
        }

        if ( ! $lang) {
            $lang = $request->header('language', $request->getPreferredLanguage(array_keys($supportLangs)));
            $lang = $lang ? $lang : config("lang.providers.{$provider}.default", config('app.locale'));
            if ($lang && function_exists('fix_language_code')) {
                $lang = fix_language_code($lang);
            }
        }

        if ($lang && key_exists($lang, $supportLangs) && $lang !== app()->getLocale()) {
            app()->setLocale($lang);

            return TRUE;
        }

        return FALSE;
    }
}
