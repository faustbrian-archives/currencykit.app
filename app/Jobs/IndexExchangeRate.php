<?php

namespace App\Jobs;

use App\Models\ExchangeRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexExchangeRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $child;

    /**
     * Create a new job instance.
     *
     * @param mixed $child
     *
     * @return void
     */
    public function __construct($child)
    {
        $this->child = $child;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = $this->child['@attributes']['time'];

        foreach ($this->child['Cube'] as $rate) {
            $attributes = $rate['@attributes'];

            ExchangeRate::updateOrCreate(
                ['date' => $date, 'currency' => $attributes['currency']],
                ['rate' => $attributes['rate']]
            );
        }
    }
}
