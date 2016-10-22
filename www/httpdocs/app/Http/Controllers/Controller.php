<?php namespace App\Http\Controllers;

// use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;
use App\Http\Requests\FormRequest;

use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\Model;

abstract class Controller extends BaseController {

	use /*DispatchesCommands, */ValidatesRequests;

	protected $request;
	protected $data;
	protected $model;
	protected $url_pattern = NULL;

	protected $form_input;

	protected $IMAGE_RESIZE		= "FIT";
	protected $IMAGE_LOGO_WIDTH = 360;
	protected $IMAGE_LOGO_HEIGHT = 400;

	protected $IMAGE_THUMBNAIL_WIDTH = 180;
	protected $IMAGE_THUMBNAIL_HEIGHT = 40;

	protected function __construct(Request $request)
	{
		$this->request = $request;
		$this->form_input = $this->request->all();
		$this->form_input = array_filter($this->form_input);

		$this->init();
	}

	protected function authentication(){
		return true;
	}

	public function basicAuthentication($BasicRealm = "admin", $user = "nam@mincorp.com", $password = "L7h4Sovgrgr5m"){
		// if (env('APP_ENV', 'production') !== 'production') {
		// 	return false;
		// }

		if(isset($_SERVER['PHP_AUTH_USER'])){
			if(($_SERVER['PHP_AUTH_USER'] != $user) || ($_SERVER['PHP_AUTH_PW'] != $password)){
				header("WWW-Authenticate: Basic realm=\"" . $BasicRealm . "\"");
				header("HTTP/1.0 401 Unauthorized");
				exit();
				return false;
			}
		}else{
			header("WWW-Authenticate: Basic realm=\"" . $BasicRealm . "\"");
			header("HTTP/1.0 401 Unauthorized");
			exit();
			return false;
		}
		return true;
	}

	protected function init(){
		$this->IMAGE_RESIZE		= "FIT";
		$this->IMAGE_LOGO_WIDTH = env('IMAGE_LOGO_WIDTH');
		$this->IMAGE_LOGO_HEIGHT = env('IMAGE_LOGO_HEIGHT');

		$this->IMAGE_THUMBNAIL_WIDTH = env('IMAGE_THUMBNAIL_WIDTH');
		$this->IMAGE_THUMBNAIL_HEIGHT = env('IMAGE_THUMBNAIL_HEIGHT');
	}

	public function dateStandardFormat($input_date){
		if($input_date == NULL) return NULL;
		if($input_date == "") return "";

		$input_date = str_replace('/', '-', $input_date);
		return date("Y-m-d", strtotime($input_date));
	}

	public function sqlEscape(string $value)
	{
		return preg_replace("/\'/", "''", $value);
	}

	protected function search()
	{
		$search_result = [
							'list' => array(),
							'form_input' => array(),
							'pagination' => ['fromRecord' => 0, 'toRecord' => 0],
		];

		$list = $this->model;
		$list = $list->paginate(env('NUMBER_OF_RECORD_PER_PAGE'));

		// Pagination
		$fromRecord = (($list->currentPage() - 1) * $list->perPage()) + 1;
		$fromRecord = ($fromRecord < $list->total()) ? $fromRecord : $list->total();

		$toRecord = ($list->currentPage() * $list->perPage());
		$toRecord = ($toRecord > $list->total()) ? $list->total() : $toRecord;

		$pagination['fromRecord']		= $fromRecord;
		$pagination['toRecord']			= $toRecord;

		$search_result['list'] 			= $list;
		$search_result['form_input'] 	= $this->form_input;
		$search_result['pagination'] 	= $pagination;

		return view('admin.' . $this->url_pattern . '_list', ['search_result'=>$search_result]);

	}

	public function listData()
	{
		return $this->search();
	}

	protected function addBy(array $rules = NULL, array $data = array()){
		if($this->form_input){ //Confirm mode
			$form_input = $this->form_input;
			if(isset($rules) && count($rules) > 0){
				$validator = Validator::make($this->form_input, $rules);

				if ($validator->fails()) {
					return view('admin.' . $this->url_pattern . '_edit', ['model' => $this->model, 'data'=>$data])
								->withErrors($validator->messages());
				}
			}

			if(isset($form_input['password'])){
				$form_input['password'] = bcrypt($form_input['password']);
			}
			$this->form_input = $form_input;

			$this->model->fill($this->form_input);
			$this->model->save(); //insert

			return redirect('admin/' . $this->url_pattern);
		}else{
			$this->model->mode = "add";
			$this->model->mode_label = "新規作成";
		}

		return view('admin.' . $this->url_pattern . '_edit', ['model' => $this->model, 'data'=> $data]);
	}

	public function editBy($id, array $rules = NULL, array $data = array())
	{
		if(!$id){ //Add mode
			return redirect('admin/' . $this->url_pattern . '/add');
		}

		$this->model = $this->model->find($id);

		if(!$this->model){
			return redirect('admin/' . $this->url_pattern . '/add');
		}

		if($this->form_input){ // Update data
			$form_input = $this->form_input;
			$this->model->fill($this->form_input);

			if($rules != NULL){
				$validator = Validator::make($form_input, $rules);

				if ($validator->fails()) {
					$this->model->mode = "edit";
					$this->model->mode_label = "編集";

					return view('admin.' . $this->url_pattern . '_edit', ['model' => $this->model, 'data'=>$data])->withErrors($validator->messages());
				}
			}

			if(isset($form_input['password']) && !empty($form_input['password'])){
				$form_input['password'] = bcrypt($form_input['password']);
				$this->form_input = $form_input;
			}

			$this->model->fill($this->form_input);
			$this->model->update();

			return redirect('admin/' . $this->url_pattern);
		}

		$this->model->mode = "edit";
		$this->model->mode_label = "編集";

		return view('admin.' . $this->url_pattern . '_edit', ['model' => $this->model, 'data'=> $data]);
	}

	public function add()
	{
		$rules = FormRequest::rules(NULL, $this->url_pattern);

		return $this->addBy($rules);
	}

	public function edit($id = NULL)
	{
		$rules = FormRequest::rules($id, $this->url_pattern);

		return $this->editBy($id, $rules);
	}

	public function imageEditBy($id, array $images_arr, array $rules = NULL)
	{
		if($id){ //Edit mode
			$model = $this->model->find($id);

			if(!$model){
				return redirect('admin/' . $this->url_pattern);
			}

			$form_input = $this->form_input;
			if($form_input){ //upload & update DB
				if($rules){
					$validator = Validator::make($this->form_input, $rules);
					if ($validator->fails()) {
						$model["mode"] = "edit";
						$model["mode_label"] = "編集";

						return view('admin.' . $this->url_pattern . '_image' . '_edit', ['model' => $model])->withErrors($validator->messages());
					}
				}

				foreach ($images_arr as $image_filename => $image_properties) {

					if($this->request->hasFile($image_filename)) { //upload image/logo

						// http://image.intervention.io/
						$image_file_input = $this->request->file($image_filename);
						$image = \Image::make($image_file_input);

						$name = $id;

						$extension = $image_file_input->getClientOriginalExtension();
						$htmlFolder = "/image/" . $this->url_pattern . "/" . $id . '/';
						$destinationPath = public_path() . $htmlFolder;

						$htmlThumbnailPath = $htmlFolder . $name . '_thumbnail.' . $extension;
						$htmlLogoPath = $htmlFolder . $name . '_logo.' . $extension;

						if(!file_exists($destinationPath)){
							\File::makeDirectory($destinationPath, 0755, true, true);
						}

						$form_input["thumbnail"] = $htmlThumbnailPath;
						$form_input["logo"] = $htmlLogoPath;

						exec('rm -f ' . $destinationPath . $name . '.*');

						//Logo
						if($this->IMAGE_RESIZE == "RESIZE"){
							$image->resize($this->IMAGE_LOGO_WIDTH, $this->IMAGE_LOGO_HEIGHT); // resize & crop
						}else{
							$image->fit($this->IMAGE_LOGO_WIDTH, $this->IMAGE_LOGO_HEIGHT); // resize & crop
						}
						$image->save($destinationPath . $name . '_logo.' . $extension);

						// Thumbnail
						if($this->IMAGE_RESIZE == "RESIZE"){
							$image->resize($this->IMAGE_THUMBNAIL_WIDTH, $this->IMAGE_THUMBNAIL_HEIGHT);
						}else{
							$image->fit($this->IMAGE_THUMBNAIL_WIDTH, $this->IMAGE_THUMBNAIL_HEIGHT); // resize & crop
						}
						$image->save($destinationPath . $name . '_thumbnail.' . $extension);
					}

				}

				$model->update($form_input);
			}

			$model["mode"] = "edit";
			$model["mode_label"] = "編集";

			return view('admin.' . $this->url_pattern . '_image_edit', compact("model"));
		}

		return redirect('admin/' . $this->url_pattern);
	}

	public function imageDeleteBy($id, array $image_name_arr)
	{
		if($id){ //Edit mode
			$model = $this->model->find($id);

			if(!$model){
				return redirect('admin/' . $this->url_pattern);
			}

			$htmlFolder = "/image/" . $this->url_pattern . "/" . $id . '/';
			$destinationPath = public_path() . $htmlFolder;

			foreach ($image_name_arr as $image_name) {
				$name = $id . '_' . $image_name;

				exec('rm -f ' . $destinationPath . $name . '.*');

				$model[$image_name] = NULL;
				$model->save();
			}
			return redirect('admin/' . $this->url_pattern . '/' . $id . '/image/edit');
		}

		return redirect('admin/' . $this->url_pattern);
	}

	public function imageedit($id)
	{
		$rules = FormRequest::rules($id, "image");

		return $this->imageEditBy($id, ["logo"=>["thumbnail", "logo"]], $rules);
	}

	public function imagedelete($id, $image_name = NULL)
	{
		if (isset($image_name)) {
			if(!empty($image_name)){
				if(is_string($image_name)) {
					$image_name_arr = [$image_name];
				} else {
					$image_name_arr = $image_name;
				}
			} else {
				$image_name_arr = ['logo', 'thumbnail'];
			}
		}

		return $this->imageDeleteBy($id, $image_name_arr);
	}

	protected function exportCsv($fileName, array $fields = NULL, $csvHeader = NULL)
	{
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Description: File Transfer');
		header("Content-type: text/csv;charset=UTF-16LE");
		// header("Content-type:application/csv;charset=UTF-8");
		header("Content-Disposition: attachment; filename={$fileName}");
		header("Expires: 0");
		header("Pragma: public");

		$csv_file = fopen('php://output', 'w');

		$model = $this->model;
		if($fields && is_array($fields)){
			$model = $model->select($fields);
		}
		$model = $model->get();

		$results = $model->toArray();

		if(is_array($csvHeader)){
			fputcsv($csv_file, $csvHeader);
		}

		foreach ( $results as $data_record ) {
			// mb_convert_encoding($data_record, 'UTF-16LE', 'UTF-8');
			fputcsv($csv_file, $data_record);
		}
		// Close the file
		fclose($csv_file);
		// Make sure nothing else is sent, our file is done
		exit();
	}

	public function downloadCsv()
	{

		$fields = $this->model->getFillable();

		$this->exportCsv($this->url_pattern . "_list_" . time() . ".csv", $fields, $fields);
	}

	public function is_mobile(){
		$user_agent = $_SERVER['HTTP_USER_AGENT']; // get the user agent value - this should be cleaned to ensure no nefarious input gets executed
		$accept     = $_SERVER['HTTP_ACCEPT']; // get the content accept value - this should be cleaned to ensure no nefarious input gets executed

		return false
			|| (preg_match('/ipad/i',$user_agent))
			|| (preg_match('/ipod/i',$user_agent)||preg_match('/iphone/i',$user_agent))
			|| (preg_match('/android/i',$user_agent))
			|| (preg_match('/opera mini/i',$user_agent))
			|| (preg_match('/blackberry/i',$user_agent))
			|| (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent))
			|| (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent))
			|| (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i',$user_agent))
			|| ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0))
			|| (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE']))
			|| (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','hiba'=>'hiba','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',)))
		;
	}

	// Function to get the client ip address
	public function get_client_ip_env() {
		$ipaddress = '';

		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}

	// Function to get the client ip address
	public function getIP() {
		$ipaddress = '';

		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}
}
