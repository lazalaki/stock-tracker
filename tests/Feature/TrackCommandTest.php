<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Retailer;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());


        Http::fake(function () {
            return [
                'available' => true,
                'price' => 29900
            ];
        });

        $this->artisan('track')
            ->expectsOutput("All done!");

        $this->assertTrue(Product::first()->inStock());
    }
}
