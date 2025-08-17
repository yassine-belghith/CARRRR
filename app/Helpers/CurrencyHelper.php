<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyHelper
{
    protected static $apiKey;

    public static function getApiKey()
    {
        if (!self::$apiKey) {
            self::$apiKey = config('services.exchangerate.api_key');
        }
        return self::$apiKey;
    }

    public static function getRates($baseCurrency = 'TND')
    {
        $apiKey = self::getApiKey();
        // If you don't have an API key, you can use static rates for testing.
        if (!$apiKey) {
            return Cache::remember('static_exchange_rates', 3600, function () {
                return [
                    'TND' => 1,
                    'EUR' => 0.29, // 1 TND = 0.29 EUR
                                'USD' => 0.32, // 1 TND = 0.32 USD
                ];
            });
        }

        return Cache::remember('exchange_rates_' . $baseCurrency, 3600, function () use ($baseCurrency, $apiKey) {
            $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}");

            if ($response->successful() && $response->json()['result'] === 'success') {
                return $response->json()['conversion_rates'];
            }

            // Fallback to static rates if API fails
            return [
                'TND' => 1,
                'EUR' => 0.29,
                'USD' => 0.32,
            ];
        });
    }

    public static function convert($amount, $from = 'TND', $to = null)
    {
        if (is_null($to)) {
            $to = session('currency', 'TND');
        }

        if ($from === $to) {
            return $amount;
        }

        $rates = self::getRates($from);

        if (!isset($rates[$to])) {
            // If the target currency is not in the rates, return the original amount
            return $amount;
        }

        return $amount * $rates[$to];
    }
}
