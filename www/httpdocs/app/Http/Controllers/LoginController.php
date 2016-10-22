<?php namespace App\Http\Controllers;

use App\Models\Member;

use Illuminate\Http\Request;

class LoginController extends UserController {


	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->model = new Member();
	}

	public function login($pattern = "member") {
		$this->url_pattern = $pattern;
		return view($this->url_pattern . '.login', ['model' => $this->model]);
	}

}
