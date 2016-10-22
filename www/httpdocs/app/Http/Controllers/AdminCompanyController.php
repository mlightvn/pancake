<?php namespace App\Http\Controllers;


use App\Models\Company;
use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AdminCompanyController extends AdminController {

	public function __construct(Request $request, Guard $guard, Registrar $registrar)
	{
		// $this->middleware('admin');
		parent::__construct($request, $guard, $registrar);

		$this->model = new Company();
		$this->url_pattern = "company";
	}

	protected function init(){
		$this->IMAGE_RESIZE		= "RESIZE";

		$this->IMAGE_LOGO_WIDTH = env("IMAGE_COMPANY_LOGO_WIDTH");
		$this->IMAGE_LOGO_HEIGHT = env("IMAGE_COMPANY_LOGO_HEIGHT");

		$this->IMAGE_THUMBNAIL_WIDTH = env("IMAGE_COMPANY_THUMBNAIL_WIDTH");
		$this->IMAGE_THUMBNAIL_HEIGHT = env("IMAGE_COMPANY_THUMBNAIL_HEIGHT");
	}

	// -----------------------------------------------------------------
	// 会社
	// -----------------------------------------------------------------
	public function listData()
	{
		// search
		$input = $this->form_input;

		if((isset($input["name"])) && !empty($input["name"])){
			$this->model = $this->model->where('name', 'LIKE', '%' . $input["name"] . '%');
		}
		if((isset($input["status"])) && !empty($input["status"])){
			$this->model = $this->model->where('status', '=', $input["status"]);
		}
		return $this->search();
	}

	public function edit($id = NULL)
	{
		$form_input = $this->form_input;

		// if(!isset($form_input['contact_tel'])){
		// 	$this->form_input['contact_tel'] = NULL;
		// }

		return parent::edit($id);
	}

	public function downloadCsv()
	{
		$this->exportCsv("companylist_" . time() . ".csv", [
				'id',
				'name',
				'email',
				'president',
				'capital',
				'contact_tel',
				'contact_phone',
				'employee_number',
				'description',
				'logo',
				'note',
				'zip_code',
				'prefecture',
				'city',
				'address',
				'building',
				'status',
		], [
				'id',
				'Name',
				'email',
				'President',
				'Capital',
				'Contact_tel',
				'Contact phone',
				'Employee number',
				'Description',
				'Logo',
				'Note',
				'zip code',
				'Prefecture',
				'City',
				'Address',
				'Building',
				'Status',
		]);
	}

}
