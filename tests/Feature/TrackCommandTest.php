<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_product_stock()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);
        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $stock = new Stock([
            'price' => 1000,
            'url' => 'http://foo.com',
            'sku' => '12346',
            'in_stock' => false
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertFalse($stock->fresh()->in_stock);

        Http::fake(fn() => [
            'available' => true,
            'price' => 29900
        ]);

        $this->artisan('track');

        $this->assertTrue($stock->fresh()->in_stock);
    }
}
