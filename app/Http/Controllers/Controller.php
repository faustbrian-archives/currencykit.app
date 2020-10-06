<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function mapRates($rates): Collection
    {
        return $rates->mapWithKeys(fn ($rate) => [$rate['currency'] => floatval($rate['rate'])]);
    }

    protected function applyFilters($request, $rates): Collection
    {
        if ($request->has('base')) {
            $base = $request->get('base');

            if ($rates->keys()->contains($base)) {
                $baseRate = $rates->get($base);

                $rates->transform(fn ($rate) => round($rate / $baseRate, 4));

                if ($base !== 'EUR') {
                    $rates->put('EUR', round(1 / $baseRate, 4));
                }
            }
        }

        // if ($request->has('symbols')) {
        //     $rates = $rates->filter(fn ($rate, $currency) => \in_array($currency, explode(',', $request->get('symbols')), true));
        // }

        return $rates->sortKeys();
    }
}
