<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Models\Member;
use App\Models\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;

/*
 http://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-facebook-login.html
 */
class FacebookController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		parent::__construct($request);

		$this->guard = Auth::guard('member');
		// $this->url_pattern = "member.login";
	}

	public function redirect()
	{
		return Socialite::driver('facebook')->redirect();
	}

	public function callback()
	{
		// when facebook call us a with token
		$providerUser = Socialite::driver('facebook')->user();

		$user = $this->createOrGetUser($providerUser);

		$this->guard->login($user);
		return redirect()->intended('/member');
	}

	public function createOrGetUser(ProviderUser $providerUser)
	{
		$account = SocialAccount::whereProvider('facebook')
			->whereProviderUserId($providerUser->getId())
			->first();

		if ($account) {
			return $account->user;
		} else {
			$account = new SocialAccount([
				'provider_user_id'		=> $providerUser->getId(),
				'provider'				=> 'facebook'
			]);

			$user = Member::whereEmail($providerUser->getEmail())->first();

			if (!$user) {
				$user = Member::create([
					'email' => $providerUser->getEmail(),
					'name' => $providerUser->getName(),
				]);
			}

			$account->user()->associate($user);
			$account->save();

			return $user;

		}
	}
}
