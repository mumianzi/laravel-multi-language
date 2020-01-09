<?php

namespace Deepcode\MultiLanguage;

use Illuminate\Support\Arr;

class MultiLanguage
{

    public $name = 'multi-language';

    public static $views = __DIR__.'/../resources/views';

    public static function enabled($provider = NULL)
    {
        if ($provider) {
            return config('lang.enable') !== FALSE
                && config("lang.providers.{$provider}.enable") !== FALSE;
        }

        return config('lang.enable') !== FALSE;
    }

    public static function isApi($provider)
    {
        return config("lang.providers.{$provider}.is_api") === TRUE;
    }
}
