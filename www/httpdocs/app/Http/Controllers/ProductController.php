<?php namespace App\Http\Controllers;


use App\Models\Product;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class ProductController extends Controller {

	protected $guard;
	protected $member;

	public function __construct(Request $request)
	{
		$this->guard = Auth::guard('member');
		if($this->guard) {
			$this->member = $this->guard->user();
		}

		parent::__construct($request);

		$this->model = new Product();
		$this->url_pattern = "product";
	}

	public function index($id)
	{
		$data = array();

		// $product = new Product();
		$product = $this->model;
		$product = $product->select(['products.*', 
			'companies.name AS company_name',
			'companies.slug AS company_slug',
			'companies.thumbnail AS company_thumbnail',
			]);
		$product = $product->join('companies', 'products.company_id', '=', 'companies.id');
		$this->model = $product->find($id);

		$category_list = \DB::table('categories')->where('status','=','Active')->where('level','=','1')->get();

		$data['category_list'] = $category_list;

		$data['product'] = $this->model;

		return view('product.index', ['data'=>$data, 'model'=>$this->model, 'category_list'=>$category_list, 'member'=>$this->member]);
	}

}
