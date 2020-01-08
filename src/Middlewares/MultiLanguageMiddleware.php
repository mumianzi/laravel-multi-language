<?php

namespace Deepcode\MultiLanguage\Middlewares;

use Closure;
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
        $platform = ($args[0] ?? NULL) ?: 'default';
        if ($this->setLanguage($request, $platform) !== NULL) {
            view()->share([
                'locale' => [
                    'languages' => config("lang.{$platform}.enable") ? config("lang.{$platform}.languages") : NULL,
                    'current' => app()->getLocale(),
                    'type' => $platform,
                    'path' => '/'.trim(config("lang.{$platform}.path"), '/').'/locale',
                ],
            ]);
        }

        return $next($request);
    }

    function setLanguage($request, $platform)
    {
        if (config("lang.{$platform}.enable") !== TRUE) {
            return NULL;
        }

        $supportLangs = config("lang.{$platform}.languages");
        // config([
        //     'lang.languages' => $supportLangs,
        //     'lang.type' => $platform,
        // ]);
        $lang = NULL;

        if ( ! Str::is(['api', 'pcapi'], $platform)) {
            $lang = Cookie::has('language') ? Cookie::get('language') : $lang;
        }

        if ( ! $lang) {
            $lang = $request->header('language', $request->getPreferredLanguage(array_keys($supportLangs)));
            $lang = $lang ? fix_language_code($lang) : config("lang.{$platform}.default", config('app.locale'));
        }

        if ($lang && key_exists($lang, $supportLangs) && $lang !== app()->getLocale()) {
            app()->setLocale($lang);

            return TRUE;
        }

        return FALSE;
    }
}
