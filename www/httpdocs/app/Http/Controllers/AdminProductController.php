<?php namespace App\Http\Controllers;


use App\Models\Company;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AdminProductController extends AdminController {

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

		$this->model = new Product();
		$this->url_pattern = "product";
	}

	// -----------------------------------------------------------------
	// 会社
	// -----------------------------------------------------------------
	public function listData($company_id = NULL)
	{
		if($company_id){
			$company = Company::find($company_id);
			if(!$company){
				return redirect('admin/product');
			}
		}else{
			$company = new Company();
		}

		// $companylist = array(''=>'▼会社を選択してください') + Company::lists('name', 'id');
		// $this->form_input['company_id'] = $companylist;

		// search
		$input = $this->form_input;
		if($input){
			if(isset($input["company_id"])){
				// $company = Company::find($product->company_id);

				$table = $table->where('company_id', '=', $input["company_id"]);
			}

			if((isset($input["keyword"])) && !empty($input["keyword"])){
				$keyword = $input["keyword"];
				$this->model = $this->model->whereRaw('(
									(name LIKE \'%' . $keyword . '%\')
								 OR (url LIKE \'%' . $keyword . '%\')
								 OR (short_description LIKE \'%' . $keyword . '%\')
								 OR (description LIKE \'%' . $keyword . '%\')
							)'
						);
			}
			if((isset($input["status"])) && !empty($input["status"])){
				$this->model = $this->model->where('status', '=', $input["status"]);
			}
		}

		$this->model = $this->model->orderBy("updated_at", "DESC");

		return $this->search();
	}

	public function add()
	{
		$data = array();

		$companylist = Company::lists('name', 'id');
		$categorylist = Category::lists('name', 'id');

		$data['company_id'] = $companylist;
		$data['category_id'] = $categorylist;

		return $this->addBy(NULL, $data);
	}

	public function edit($id = NULL)
	{
		$data = array();

		$companylist = Company::lists('name', 'id');
		$categorylist = Category::lists('name', 'id');

		$data['company_id'] = $companylist;
		$data['category_id'] = $categorylist;

		return $this->editBy($id, NULL, $data);
	}

}
