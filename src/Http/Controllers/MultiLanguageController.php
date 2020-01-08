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
        $type = Request::get('type');
        $locale = Request::get('locale');
        $langConfig = config("lang.{$type}", []);
        if (Arr::get($langConfig, 'enable') !== FALSE
            && array_key_exists($locale, Arr::get($langConfig, 'languages', []))) {
            $path = '/'.trim(Arr::get($langConfig, 'path'), '/');

            $cookie = Cookie::forever('language', $locale, $path);

            return response('ok')->cookie($cookie);
        }
    }

    public function getLogin()
    {
        return view("multi-language::login");
    }
}
