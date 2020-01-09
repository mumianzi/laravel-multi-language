<?php

namespace Deepcode\MultiLanguage\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Deepcode\MultiLanguage\MultiLanguage;
use Illuminate\Support\Arr;

class MultiLanguageController extends Controller
{

    public function locale()
    {
        $provider = Request::get('provider');
        $locale = Request::get('locale');
        $langConfig = config("lang.providers.{$provider}", []);
        if (MultiLanguage::enabled($provider)
            && array_key_exists($locale, Arr::get($langConfig, 'languages', []))) {
            $path = '/'.trim(Arr::get($langConfig, 'path'), '/');

            $cookie = Cookie::forever('language', $locale, $path, Arr::get($langConfig, 'domain'));

            return response('ok')->cookie($cookie);
        }
    }

    public function getLogin()
    {
        return view("multi-language::login");
    }
}
