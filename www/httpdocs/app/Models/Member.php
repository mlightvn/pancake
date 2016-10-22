<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Member extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $fillable = [
		'id',
		'email',
		'password',
		'firstname',
		'lastname',
		'gender',
		'birthday',
		'phone',

		'thumbnail',
		'logo',
		'images',
		'short_description',
		'description',
		'zip_code',
		'prefecture',
		'city',
		'address',
		'building',
		'status',

		// 'remember_token',

	];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	// protected $table = 'members';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

}
