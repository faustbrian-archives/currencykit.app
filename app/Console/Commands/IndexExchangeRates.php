<?php

namespace App\Console\Commands;

use App\Jobs\IndexExchangeRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class IndexExchangeRates extends Command
{
    protected $signature = 'index:rates';

    protected $description = 'Command description';

    public function handle()
    {
        $response = Http::get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.xml')->body();

        $days = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA)->Cube;

        foreach ($days->children() as $day) {
            IndexExchangeRate::dispatch(json_decode(json_encode((array) $day), true));
        }
    }
}
