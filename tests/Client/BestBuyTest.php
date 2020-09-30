<?php

namespace Tests\Client;

use App\Clients\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;


class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_a_product()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $stock = tap(Stock::first())->update([
            'sku' => 6401728,
            'url' => 'https://www.bestbuy.com/site/nintendo-switch-animal-crossing-new-horizons-edition-32gb-console-multi/6401728.p?skuId=6401728'
        ]);

        try {
            $stockStatus = (new BestBuy())->checkAvailability($stock);
        } catch (\Exception $e) {
            $this->fail('Failed to track BestBuy API properly.' . $e->getMessage());
        }

        $this->assertTrue(true);
    }



    /** @test */
    function it_creates_the_proper_stock_status_response()
    {
        Http::fake(function () {
            return ['salePrice' => 299.99, 'onlineAvailability' => true];
        });

        $stockStatus = (new BestBuy())->checkAvailability(new Stock());

        $this->assertEquals(29999, $stockStatus->price);
        $this->assertTrue($stockStatus->available);
    }
}
