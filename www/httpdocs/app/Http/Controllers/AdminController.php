<?php namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminController extends Controller {

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	protected $redirectTo = '/admin';

	protected $guard;
	protected $administrator;

	private $maxLoginAttempts = 10;

	public function __construct(Request $request)
	{
		$this->guard = Auth::guard('admin');

		$this->middleware('admin', ['except' => 'getLogin']);

		// Check logged-in
		$actual_link = $_SERVER['REQUEST_URI'];
		$this->basicAuthentication();

		parent::__construct($request);
		$this->administrator = new Administrator();
	}

	public function index()
	{
		if($this->url_pattern){
			return redirect('admin/'. $this->url_pattern);
		}

		$this->data['member'] = $this->guard->user()['attributes'];
		return view('admin.index', ['data' => $this->data]);
	}

	protected function validator(array $data)
	{
		return Validator::make($data, [
			'email' => 'required|email|max:100|unique:administrators,email',
			'password' => 'required|min:8',
		]);
	}

	public function getLogin(){
		return redirect("/admin");
	}

	public function getLogout(){
		// Auth::guard('admin')->logout();
		$_SERVER['PHP_AUTH_USER'] = NULL;
		$_SERVER['PHP_AUTH_PW'] = NULL;

		return redirect("/admin");
	}

	public function authenticate() {
		$form_input = $this->form_input;

		$credentials = [
			'email' 		=> $form_input['email'], 
			'password' 		=> $form_input['password'], //auto-encrypt
			'status' 		=> "Active",
			];

		if ($this->guard->attempt($credentials)) {
			return redirect()->intended('/admin');
		} else {
			return redirect('/admin');
		}
	}
}
