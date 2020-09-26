<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowExchangeRatesByDay extends Controller
{
    public function __invoke(Request $request, string $date)
    {
        abort_if(Carbon::parse($date)->isWeekend(), Response::HTTP_I_AM_A_TEAPOT);

        $query = ExchangeRate::where('date', $date);

        if ($request->has('symbols')) {
            $query->whereIn('currency', explode(',', $request->get('symbols')));
        }

        $rates = $query->orderBy('currency')->orderBy('date', 'desc')->get();

        return [
            'date'  => $date,
            'base'  => $request->get('base', 'EUR'),
            'rates' => $this->applyFilters($request, $this->mapRates($rates)),
        ];
    }
}
