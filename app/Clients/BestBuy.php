<?php


namespace App\Clients;

use App\Models\Stock;
use App\Clients\StockStatus;
use Illuminate\Support\Facades\Http;



class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {

        $results = Http::get($this->endpoint($stock->sku))->json();


        return new StockStatus(
            $results['onlineAvailability'],
            $this->dollarsToCents($results['salePrice'])
        );
    }


    public function endpoint($sku)
    {
        $key = config('services.clients.bestBuy.key');

        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$key}";
    }


    private function dollarsToCents($salePrice)
    {
        return (int) (int) ($salePrice * 100);
    }
}
