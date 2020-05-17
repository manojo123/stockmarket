<?php

namespace App;

use App\Retailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stock extends Model
{
	protected $casts = ['in_stock' => 'boolean'];

	public function track()
	{
		$status = $this
			->retailer
			->client()
			->checkAvailability($this);

		$this->update([
			'in_stock' => $status->available,
			'price' => $status->price
		]);
	}

	public function retailer()
	{ 
		return $this->belongsTo(Retailer::class);
	}

}
