<?php namespace App\Http\Controllers;


use App\Models\Video;
use App\Http\Requests\FormRequest;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AdminVideoController extends AdminController {

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

		$this->model = new Video();
		$this->url_pattern = "video";
	}

	// -----------------------------------------------------------------
	// 会社
	// -----------------------------------------------------------------
	public function listData()
	{
		// $this->model = $this->model->select(['categories.*', 'parent_cat.name AS parent_name']);
		// $this->model = $this->model->leftjoin('categories AS parent_cat', 'categories.parent_id', '=', 'parent_cat.id');

		// search
		$form_input = $this->form_input;
		if($form_input){

			if((isset($form_input["keyword"])) && !empty($form_input["keyword"])){
				$keyword = $form_input["keyword"];
				$this->model = $this->model->where('title', 'LIKE', '%' . $keyword . '%');
			}
			if((isset($form_input["status"])) && !empty($form_input["status"])){
				$this->model = $this->model->where('status', '=', $form_input["status"]);
			}
		}

		return $this->search();
	}

	// https://www.codetutorial.io/laravel-5-file-upload-storage-download/
	public function add()
	{
		if($this->form_input) { //upload image/logo
			$form_input = $this->form_input;

			$rules = FormRequest::rules(NULL, $this->url_pattern);

			if(isset($rules)){
				$validator = \Illuminate\Support\Facades\Validator::make($this->form_input, $rules);

				if ($validator->fails()) {
					return view('admin.' . $this->url_pattern . '_edit', ['model' -> $this->model, 'data'=>$data])
								->withErrors($validator->messages());
				}
			}

			$this->model->fill($this->form_input);
			$this->model->save(); //insert
			$id = $this->model->id;

			if($this->request->hasFile('path')) {
				$file = $this->request->file('path');

				$filename = $id;
				$extension = $file->getClientOriginalExtension();

				$htmlFolder = "/video/";
				$destinationPath = public_path() . $htmlFolder;
				$htmlPath = $htmlFolder . $filename . '.' . $extension;

				@unlink($destinationPath . $filename . '.*');

				$this->form_input['path'] = $htmlPath;
				$this->form_input['mime'] = $file->getClientMimeType();;

				$file->move($destinationPath, $filename . '.' . $extension);

				$this->model->fill($this->form_input);
				$this->model->update();

				return redirect('admin/' . $this->url_pattern);
			}
		}

		$this->model["mode"] = "add";
		$this->model["mode_label"] = "新規追加";

		return view('admin.' . $this->url_pattern . '_edit', ["model"=>$this->model]);
	}

	public function edit($id)
	{
		if(!$id){ //Add mode
			// https://laravel.com/docs/5.0/requests
			return redirect('admin/' . $this->url_pattern . '/add');
		}

		$this->model = $this->model->find($id);

		if(!$this->model){
			return redirect('admin/' . $this->url_pattern . '/add');
		}

		if($this->form_input) { //upload image/logo
			$form_input = $this->form_input;

			// Validation
			// $rules = FormRequest::rules($id, $this->url_pattern);

			// if(isset($rules)){
			// 	$validator = \Illuminate\Support\Facades\Validator::make($this->form_input, $rules);

			// 	if ($validator->fails()) {
			// 		return view('admin.' . $this->url_pattern . '_edit', ['model' -> $this->model])
			// 					->withErrors($validator->messages());
			// 	}
			// }

			if($this->request->hasFile('path')) {
				$file = $this->request->file('path');

				$filename = $id;
				$extension = $file->getClientOriginalExtension();

				$htmlFolder = "/video/";
				$destinationPath = public_path() . $htmlFolder;
				$htmlPath = $htmlFolder . $filename . '.' . $extension;

				exec('rm -f ' . $destinationPath . $filename . '.*');

				$this->form_input['path'] = $htmlPath;
				$this->form_input['mime'] = $file->getClientMimeType();;

				$file->move($destinationPath, $filename . '.' . $extension);
			}

			$this->model->fill($this->form_input);
			$this->model->update();

			return redirect('admin/' . $this->url_pattern);
		}

		$this->model["mode"] = "edit";
		$this->model["mode_label"] = "編集";

		return view('admin.' . $this->url_pattern . '_edit', ["model"=>$this->model]);
	}

}
