<?php

namespace App;

use App\Stock;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function inStock()
	{
		return $this->stock()->where('in_stock', true)->exists();
	}

	public function stock()
	{
		return $this->hasMany(Stock::class);
	}
}
