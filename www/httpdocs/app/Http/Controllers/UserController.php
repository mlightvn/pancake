<?php namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;

use Illuminate\Http\Request;

class UserController extends Controller {

	const ITEM_NUMBER_PC = 8;
	const ITEM_NUMBER_SP = 3;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		// $this->url_pattern = "";
	}

	protected function init(){
		parent::init();

		$this->model = new Category();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data = $this->getDataForHome();

		$url = "";
		if($this->url_pattern){
			$url = $this->url_pattern . '.index';
		}else{
			$url = 'index';
		}

		$this->data['is_mobile'] = $this->is_mobile();

		return view($url, ['data'=>$this->data]);
	}

	public function getDataForHome()
	{
		$data = NULL;

		$category_list = \DB::table('categories')->where('status','=','Active')->where('level','=','1')->get();

		$company_list = \DB::table('companies')->where('status','=','Active')->orderby("id")->get();

		foreach ($category_list as $key => $category) {
			$table = new Product();
			$table = $table->select('products.*');
			$table = $table->join('companies'			, 'products.company_id', '=', 'companies.id');
			$table = $table->join('categories'			, 'products.category_id', '=', 'categories.id');

			$table = $table->where('products.status'	, '=', 'Active');
			$table = $table->where('companies.status'	, '=', 'Active');
			$table = $table->where('categories.status'	, '=', 'Active');

			$table = $table->orderby('products.created_at', 'DESC');
			$table = $table->orderby('products.price', 'ASC');
			$table = $table->orderby('products.market_price', 'DESC');
			if($this->is_mobile()){
				$table = $table->limit(self::ITEM_NUMBER_SP);
			}else{
				$table = $table->limit(self::ITEM_NUMBER_PC);
			}

			$category->product_list = $table;
			$category->product_list = $category->product_list->where('categories.id', '=', $category->id);
			$category->product_list = $category->product_list->get();
		}

		$data['category_list'] = $category_list;
		$data['company_list'] = $company_list;

		return $data;
	}

	public function searchCategory($category_id) {
		return $this->search($category_id);
	}

	public function searchCompanyProduct($company_slug) {
		return $this->search(NULL, $company_slug);
	}

	public function searchByKeyword($keyword) {
		return $this->search(NULL, NULL, $keyword);
	}

	//category_id or category_slug
	public function search($category_slug = NULL, $company_slug = NULL, $keyword = NULL)
	{
		$table = \DB::table('products');
		$table = $table->join('companies', 'products.company_id', '=', 'companies.id');
		$table = $table->join('categories', 'products.category_id', '=', 'categories.id');
		$table = $table->select(['products.*', 
						'categories.name AS category_name',
					]);

		$category_list = \DB::table('categories')->where('status','=','Active')->where('level','=','1')->get();

		// search
		$input = $this->form_input;
		if(!$input){
			$input = array();
		}

		$product_form = new \App\Models\Product();

		$keyword						= ((!empty($input["keyword"])) ? $input["keyword"] : $keyword);
		if($keyword){
			$product_form->keyword			= $keyword;
			$keyword = preg_replace('/\'/', "''", $keyword); // SQL injection

			$table = $table->orWhereRaw('(
							(products.name LIKE \'%' . $keyword . '%\')
						)'
					);
		}

		if((isset($category_slug)) && !empty($category_slug)){
			$product_form->category_slug			= $category_slug;

			$category = new Category();
			$category = $category->where('slug', '=', $category_slug);
			$category = $category->where('status', '=', 'Active');

			$product_form->category = $category->first();

			$table = $table->where('categories.slug', '=', $category_slug);

		}

		if((isset($company_slug)) && !empty($company_slug)){
			$product_form->company_slug			= $company_slug;

			$table = $table->whereRaw('(
						(companies.slug LIKE \'' . $company_slug . '\')
					)');

			$company = new Company();
			$company = $company->where('slug', '=', $company_slug);

			$record			= $company->select("name")->first();
			$product_form->company_name			= $record->name;
		}

		$table = $table->where('products.status', '=', 'Active');
		$table = $table->where('companies.status', '=', 'Active');
		$table = $table->where('categories.status', '=', 'Active');

		if((isset($input["sort_by"])) && !empty($input["sort_by"])){
			$sort_by = $input["sort_by"];
			switch ($sort_by) {
				case 'gia_tang':
					$table = $table->orderBy('products.price', 'ASC');
					break;

				case 'gia_giam':
					$table = $table->orderBy('products.price', 'DESC');
					break;

				case 'moi_nhat':
					$table = $table->orderBy('products.created_at', 'DESC');
					break;

				default:
					$table = $table->orderBy('products.created_at', 'DESC');
					break;
			}
		}else{
			$table = $table->orderBy('products.created_at', 'DESC');
		}

		$table = $table->groupBy('products.id');
		$table = $table->orderBy('products.market_price', 'DESC');

		$product_list = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));
		//URL process
		$product_list->sortBy = $this->sortByUrl();

		// Pagination
		$fromRecord = (($product_list->currentPage() - 1) * $product_list->perPage()) + 1;
		$fromRecord = ($fromRecord < $product_list->total()) ? $fromRecord : $product_list->total();

		$toRecord = ($product_list->currentPage() * $product_list->perPage());
		$toRecord = ($toRecord > $product_list->total()) ? $product_list->total() : $toRecord;

		$product_form->fromRecord	= $fromRecord;
		$product_form->toRecord		= $toRecord;

		return view('search', compact('product_list', 'product_form', 'category_list'));
	}

	private function sortByUrl(){
		$fullUrl = $this->request->url();

		$input = $this->form_input;
		if(isset($input['sort_by']))unset($input["sort_by"]);
		$s = "";
		foreach ($input as $key => $value) {
			if(!empty($s)){
				$s .= "&";
			}
			$s .= $key . "=" . urlencode($value);
		}

		if(empty($s)){
			$fullUrl .= "?sort_by=";
		}else{
			$fullUrl .= "?" . $s . "&sort_by=";
		}

		$arr = array();
		$arr["Giá tăng"] = $fullUrl . "gia_tang";
		$arr["Giá giảm"] = $fullUrl . "gia_giam";
		$arr["Mới nhất"] = $fullUrl . "moi_nhat";

		return $arr;
	}

}
