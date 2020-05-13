<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);
        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $stock = new Stock([
        	'price' => 1000,
        	'url' => 'http://foo.com',
        	'sku' => '12346',
        	'in_stock' => true
        ]);
        
        $this->assertFalse($switch->inStock());

        $bestBuy->addStock($switch, $stock);

        $this->assertTrue($switch->inStock());
    }
}