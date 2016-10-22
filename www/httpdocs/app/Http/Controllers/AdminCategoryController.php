<?php namespace App\Http\Controllers;


use App\Models\Category;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AdminCategoryController extends AdminController {

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

		$this->model = new Category();
		$this->url_pattern = "category";
	}

	// -----------------------------------------------------------------
	// 会社
	// -----------------------------------------------------------------
	public function listData()
	{
		$this->model = $this->model->select(['categories.*', 'parent_cat.name AS parent_name']);
		$this->model = $this->model->leftjoin('categories AS parent_cat', 'categories.parent_id', '=', 'parent_cat.id');

		// search
		$input = $this->form_input;
		if($input){

			if((isset($input["name"])) && !empty($input["name"])){
				$this->model = $this->model->where('categories.name', 'LIKE', '%' . $input["name"] . '%');
			}
			if((isset($input["status"])) && !empty($input["status"])){
				$this->model = $this->model->where('categories.status', '=', $input["status"]);
			}
		}

		return $this->search();
	}

}
