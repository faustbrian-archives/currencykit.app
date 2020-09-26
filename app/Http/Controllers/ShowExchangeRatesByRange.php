<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ShowExchangeRatesByRange extends Controller
{
    public function __invoke(Request $request, string $start, string $end)
    {
        $query = ExchangeRate::whereBetween('date', [$start, $end]);

        if ($request->has('symbols')) {
            $query->whereIn('currency', explode(',', $request->get('symbols')));
        }

        $rates = $query->orderBy('currency')->orderBy('date', 'desc')->get()->groupBy('date');

        return [
            'start_at'                => $start,
            'end_at'                  => $end,
            'base'                    => $request->get('base', 'EUR'),
            'rates'                   => $rates
                ->transform(fn ($day) => $this->mapRates($day))
                ->mapWithKeys(fn ($rate, $date) => [$date => $this->applyFilters($request, $rate)]),
        ];
    }
}
