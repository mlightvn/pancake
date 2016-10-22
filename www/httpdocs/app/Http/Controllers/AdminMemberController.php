<?php namespace App\Http\Controllers;


use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\FormRequest;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AdminMemberController extends AdminController {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request, Guard $guard, Registrar $registrar)
	{
		// $this->middleware('admin');
		parent::__construct($request, $guard, $registrar);

		$this->model = new Member();
		$this->url_pattern = "member";
	}

	// -----------------------------------------------------------------
	// 会社
	// -----------------------------------------------------------------
	public function listData()
	{
		// search
		$input = $this->form_input;

		if((isset($input["keyword"])) && !empty($input["keyword"])){
			$keyword = $input["keyword"];
			$keyword = $this->sqlEscape($keyword);

			$this->model = $this->model->whereRaw(
					"(
						(email        LIKE '%" . $keyword . "%)
					 OR (firstname    LIKE '%" . $keyword . "%)
					 OR (lastname     LIKE '%" . $keyword . "%)
					 OR (phone        LIKE '%" . $keyword . "%)
					 OR (short_description    LIKE '%" . $keyword . "%)
					 OR (description          LIKE '%" . $keyword . "%)
					 OR (prefecture           LIKE '%" . $keyword . "%)
					 OR (city                 LIKE '%" . $keyword . "%)
					 OR (address              LIKE '%" . $keyword . "%)
					 OR (building             LIKE '%" . $keyword . "%)
					)"
				);
		}

		if((isset($input["status"])) && !empty($input["status"])){
			$this->model = $this->model->where('status', '=', $input["status"]);
		}
// dd($this->model->toSql());
		return $this->search();
	}

	public function edit($id = NULL)
	{
		if($this->form_input){
			$this->form_input["birthday"] = $this->dateStandardFormat($this->form_input["birthday"]);
			if(!isset($this->form_input["password"]))unset($this->form_input["password"]);
			if(!isset($this->form_input["password_confirmation"]))unset($this->form_input["password_confirmation"]);
		}

		return $this->editBy($id, FormRequest::rules($id, $this->url_pattern, 'edit'));
	}

	public function downloadCsv()
	{
		$this->exportCsv("memberlist_" . time() . ".csv", [
				"id", 
				"email", 
				"firstname", 
				'lastname',
				'gender',
				'birthday',
				'phone',
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
		], [
				"id", 
				"email", 
				"Firstname", 
				'Lastname',
				'Gender',
				'Birthday',
				'Phone',
				'Logo',
				'Images',
				'Short_description',
				'Sescription',
				'zip_code',
				'Prefecture',
				'City',
				'Address',
				'Building',
				'Status',
		]);
	}

}
