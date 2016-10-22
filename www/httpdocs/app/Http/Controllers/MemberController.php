<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class MemberController extends UserController {

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	protected $guard;
	protected $member;

	public function __construct(Request $request)
	{

		$this->guard = Auth::guard('member');
		// $this->registrar = $registrar;

		$this->middleware('member', ['except' => ['getLogout', 'login']]);

		parent::__construct($request);

		// Check logged-in
		$actual_link = $_SERVER['REQUEST_URI'];
		if(in_array($actual_link, ['/member/login', '/member/signup'])){
		}else{
			if($this->guard){
				if (!($this->guard->check()))
				{
					return redirect('/member/login')->send();
				}
			}
		}

		$this->model = $this->guard->user();
		$this->member = $this->model;

		$this->url_pattern = "member";
	}

	public function index()
	{
		return view($this->url_pattern . '.index', ['model'=>$this->model, 'member'=>$this->member]);

	}

	function login(){
		if($this->form_input){
			$form_input = $this->form_input;

			$credentials = [
				'email' 		=> $form_input['email'], 
				'password' 		=> $form_input['password'], //auto-encrypt
				'status' 		=> "Active",
			];
			if ($this->guard->attempt($credentials)) {

				return redirect()->intended('/' . $this->url_pattern);
			}
		}
		return view($this->url_pattern . '.login');
	}

	function signup(){
		$form_input = $this->form_input;
		if($form_input){

			$rules = FormRequest::rules(NULL, $this->url_pattern);
			if(isset($rules) && count($rules) > 0){
				$validator = Validator::make($form_input, $rules);

				if ($validator->fails()) {
					return view($this->url_pattern . '.signup', ['model' => $this->model])
								->withErrors($validator->messages());
				}
			}

			$this->form_input['password'] = bcrypt($form_input['password']);

			$this->model->fill($this->form_input);
			$this->model->save();

			$credentials = [
				'email' => $form_input['email'], 
				'password' => $form_input['password']
			];

			if ($this->guard->attempt($credentials)) {
				return redirect()->intended('/' . $this->url_pattern);
			}
			return view($this->url_pattern . '.signup')->withErrors("Cannot signup!");
		}
		return view($this->url_pattern . '.signup');
	}

	public function getLogout(){
		$this->guard->logout();
		return redirect("/");
	}

	public function create()
	{
		//
	}

	// update
	public function store(Request $request)
	{

		$this->form_input["birthday"] = $this->dateStandardFormat($this->form_input["birthday"]);

		if(isset($this->form_input["password"]) && empty($this->form_input["password"])) {
			unset($this->form_input["password"]);
		}
		if(isset($this->form_input["password_confirmation"]) && empty($this->form_input["password_confirmation"])) {
			unset($this->form_input["password_confirmation"]);
		}

		$this->form_input = array_filter($this->form_input);

		$this->model->fill($this->form_input);
		$this->model->update();

		return redirect("/" . $this->url_pattern);
	}

	public function show($id)
	{
		//
	}


	public function edit($id = NULL)
	{
		return view('member.edit', ['model'=>$this->model, 'member'=>$this->member]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function leave()
	{
		//
	}

}
