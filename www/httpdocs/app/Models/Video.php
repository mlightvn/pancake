<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

	protected $fillable = [
		'id',
		'company_id',
		'category_id',
		'member_id',
		'title',
		'description',
		'path',
		'mime',
		'likes_number',
		'status',
	];

}
