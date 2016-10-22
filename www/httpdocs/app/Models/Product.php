<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $fillable = [
		'id',
		'company_id',
		'category_id',
		'name',
		'market_price',
		'price',
		'down_percent',
		'quantity',
		'max_quantity',
		'status',
		'short_description',
		'description',
		'expired_datetime',

		'thumbnail',
		'logo',
		'rate',
		'slug',
		'url',
	];

}
