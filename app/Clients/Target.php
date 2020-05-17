<?php

namespace App\Clients;

use App\Clients\StockStatus;
use App\Stock;
use Illuminate\Support\Facades\Http;

class Target
{
	/**
	 * @return array
	 */
	public function checkAvailability(Stock $stock): StockStatus
	{
		//
	}
}
