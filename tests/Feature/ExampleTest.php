<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function it_checks_stock_for_products_at_retailers()
    // {
    //     $switch = Product::create(['name' => 'Nintendo Switch']);

    //     $bestBuy = Retailer::create(['name' => 'Best Buy']);

    //     $this->assertFalse($switch->inStock());
    // }
}
