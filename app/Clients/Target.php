<?php


namespace App\Clients;

use App\Models\Stock;
use App\Clients\StockStatus;

class Target implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get('http://foo.test')->json();

        return new StockStatus(
            $results['available'],
            $results['price']
        );
    }
}
