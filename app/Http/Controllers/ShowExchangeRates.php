<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ShowExchangeRates extends Controller
{
    public function __invoke(Request $request)
    {
        $date = ExchangeRate::orderByDesc('date')->limit(1)->first(['date'])->date;

        $rates = ExchangeRate::where('date', $date)->orderBy('currency')->get();

        return [
            'date'  => $date,
            'base'  => $request->get('base', 'EUR'),
            'rates' => $this->applyFilters($request, $this->mapRates($rates)),
        ];
    }
}
