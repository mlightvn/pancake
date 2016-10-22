<?php namespace App\Http\Controllers;


use App\Models\Administrator;
use Illuminate\Http\Request;
use App\Http\Requests\FormRequest;

use Illuminate\Support\Facades\Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AdminAdministratorController extends AdminMemberController {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request, Guard $guard, Registrar $registrar)
	{
		parent::__construct($request, $guard, $registrar);

		$this->model = new Administrator();
		$this->url_pattern = "administrator";
	}

	// public function login()
	// {
	// 	if($this->form_input){ // Update data
	// 		$this->form_input['password'] = bcrypt($this->form_input['password']);

	// 		$form_input = $this->form_input;

	// 		$rules = FormRequest::rules(NULL, "admin.login");

	// 		if($rules != NULL){
	// 			$validator = Validator::make($form_input, $rules);

	// 			if ($validator->fails()) {
	// 				return view('admin.login', ['model' => $this->model])->withErrors($validator->messages());
	// 			}
	// 		}

	// 		$this->model->fill($this->form_input);
	// 		$resultset = $this->model->get();
	// 		if($resultset->count() > 0 ){
	// 			return redirect('admin');
	// 		}
	// 	}

	// 	return view('admin.login', ['model' => $this->model]);
	// }
}
