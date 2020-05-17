<?php

namespace Tests\Unit;

use Mockery;
use App\Clients\Client;
use App\Clients\ClientException;
use App\Clients\StockStatus;
use App\Retailer;
use App\Stock;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RetailerWithProductSeeder;
use Tests\TestCase;

class StockTest extends TestCase
{

	use RefreshDatabase;

	/** @test */
	public function throws_an_exception_if_a_client_is_not_found_when_tracking()
	{
		$this->withoutExceptionHandling();

		$this->seed(RetailerWithProductSeeder::class);

		Retailer::first()->update(['name' => 'Foo Retailer']);

		$this->expectException(ClientException::class);

		Stock::first()->track();
	}

	/** @test */
	public function it_updates_local_stock_status_after_being_tracked()
	{
		$this->withoutExceptionHandling();
		
		$this->seed(RetailerWithProductSeeder::class);

		// $clientMock = Mockery::mock(Client::class);
		// $clientMock->shouldReceive('checkAvailability')->andReturn(new StockStatus($available = true, $price = 9900));

		ClientFactory::shouldReceive('make->checkAvailability')->andReturn(
			new StockStatus($available = true, $price = 9900)
		);

		$stock = tap(Stock::first())->track();

		$this->assertTrue($stock->in_stock);
		$this->assertEquals(9900, $stock->price);

	}
}
