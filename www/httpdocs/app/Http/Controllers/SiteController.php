<?php namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;

use Illuminate\Http\Request;

class SiteController extends UserController {

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->model = new Company();
		$this->url_pattern = "site";
	}

	public function getDataForHome($slug = null)
	{
		$data = array();

		// カテゴリー
		$category_list = \DB::table('categories')->where('status','=','Active')->where('level','=','1')->get();

		// 会社
		$company_list = \DB::table('companies')->where('status','=','Active')->get();

		if($slug){
			$company_list = $company_list->where('slug', '=', $slug);
		}

		$data['category_list'] 		= $category_list;
		$data['company_list'] 		= $company_list;

		return $data;
	}

	public function searchCompany($slug = null)
	{

		// カテゴリー
		$category_list = \DB::table('categories')->where('status','=','Active')->where('level','=','1')->get();

		// 会社
		$table = \DB::table('companies');
		$table = $table->select(['companies.*', 
						// \DB::raw('CONCAT(SUBSTR(products.name, 1, 150), \' ...\') AS short_name'),
					]);

		// search
		$input = $this->form_input;
		if(!$input){
			$input = array();
			$input["keyword"] = "";
		}

		$company_form = new \App\Models\Company();

		if((isset($input["keyword"])) && !empty($input["keyword"])){
			$keyword						= $input["keyword"];
			$product_form->keyword			= $keyword;
			$keyword = preg_replace('/\'/', "''", $keyword); // SQL injection

			$table = $table->whereRaw(
				'(
					(name						LIKE \'%' . $keyword . '%\')
					OR (short_description 		LIKE \'%' . $keyword . '%\')
					OR (description				LIKE \'%' . $keyword . '%\')
				)'
				);
		}

		if((isset($slug)) && !empty($slug)){
			$company_form->slug		= $slug;

			$table = $table->where('slug', 'LIKE', '%' . $slug . '%');
		}

		$table = $table->where('status', '=', 'Active');

		$company_list = $table->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		// Pagination
		$fromRecord = (($company_list->currentPage() - 1) * $company_list->perPage()) + 1;
		$fromRecord = ($fromRecord < $company_list->total()) ? $fromRecord : $company_list->total();

		$toRecord = ($company_list->currentPage() * $company_list->perPage());
		$toRecord = ($toRecord > $company_list->total()) ? $company_list->total() : $toRecord;

		$company_form->fromRecord	= $fromRecord;
		$company_form->toRecord		= $toRecord;

		$this->data['category_list'] 		= $category_list;
		$this->data['company_list']			= $company_list;

		return view('site.index', ['data'=>$this->data]);
	}

}
