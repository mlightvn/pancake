<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	protected $fillable = [
		'id',
		'email',
		'password',
		'slug',
		'name',
		'president',
		'capital',
		'employee_number',
		'description',
		'thumbnail',
		'favicon',
		'logo',
		'note',
		'website',
		'contact_tel',
		'contact_phone',
		'zip_code',
		'prefecture',
		'city',
		'district',
		'address',
		'building',
		'status',
	];
}
