<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'fr', 'ja', 'es'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
        return redirect()->back();
    }

    public function switchCurrency($currency)
    {
                if (in_array($currency, ['TND', 'EUR', 'USD'])) {
            Session::put('currency', $currency);
        }
        return redirect()->back();
    }
}
