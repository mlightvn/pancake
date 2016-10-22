<?php

require_once (CB_FW_ROOT . "/library/CB/library/CB/ImageEditor.php");

/**
 * スクレイピングのコモンファイル
 * @author yuki.hamada
 *
 */
class AC_scraping_common extends AC_Action{
	public $buf;
	public $data;
	public $debug				= false; //未使用
	public $is_update			= false; //追加・更新
	public $DB_coupon;

	public $filter = array(
						"ao"                    => "thoi-trang"
						, "ao-khoac"            => "thoi-trang"
						, "ao-tam"              => "thoi-trang"
						, "ao-thun"             => "thoi-trang"
						, "ao-ren"              => "thoi-trang"
						, "ao-so-mi"            => "thoi-trang"
						, "ao-khoac"            => "thoi-trang"
						, "ao-nam"              => "thoi-trang"
						, "chan-vay"            => "thoi-trang"
						, "day-nit"             => "thoi-trang"
						, "thoi-trang"          => "thoi-trang"
						, "quan-lot"            => "thoi-trang"
						, "quan-dai"            => "thoi-trang"
						, "quan-ao"             => "thoi-trang"
						, "tui"                 => "thoi-trang"
						, "tui-xach"            => "thoi-trang"
						, "tui-hop"             => "thoi-trang"
						, "ba-lo"               => "thoi-trang"
						, "vi-cam-tay"          => "thoi-trang"
						, "dam-thoi-trang"      => "thoi-trang"
						, "dam-voan"            => "thoi-trang"
						, "balo"                => "thoi-trang"
						, "vay"                 => "thoi-trang"
						, "mat-kinh"            => "thoi-trang"
						, "vest"                => "thoi-trang"
						, "bo-do"               => "thoi-trang"
						, "dam-da-tiec"         => "thoi-trang"
						, "dam-dao-pho"         => "thoi-trang"
						, "dam-bo-eo"           => "thoi-trang"
						, "dam-cong-so"         => "thoi-trang"
						, "set-do-bo"           => "thoi-trang"
						, "do-doi-nu"           => "thoi-trang"
						, "noi-y"               => "thoi-trang"
						, "quan-nam"            => "thoi-trang"
						, "quan-nu"             => "thoi-trang"
						, "bo-do-the-thao-nam"  => "thoi-trang"
						, "do-doi-nam"          => "thoi-trang"
						, "jumpsuit"            => "thoi-trang"
						, "dam-yem"             => "thoi-trang"
						, "bo-do"               => "thoi-trang"
						, "giay"                => "thoi-trang"
						, "dam"                 => "thoi-trang"
						, "quan-jeans"          => "thoi-trang"
						, "set-bo"              => "thoi-trang"
						, "me-be"               => "thoi-trang"
						, "day-chuyen"          => "thoi-trang"
						, "bikini"        		=> "thoi-trang"
						, "dong-ho"             => "cong-nghe"
						, "chuot"               => "cong-nghe"
						, "ban-phim"            => "cong-nghe"
						, "day-cap"             => "cong-nghe"
						, "the-nho"             => "cong-nghe"
						, "vi-tinh"             => "cong-nghe"
						, "lcd"                 => "cong-nghe"
						, "usb"                 => "cong-nghe"
						, "dvd"                 => "cong-nghe"
						, "cd"                  => "cong-nghe"
						, "tai-nghe"            => "cong-nghe"
						, "pin-sac"             => "cong-nghe"
						, "coc-sac"             => "cong-nghe"
						, "but-trinh-chieu"     => "cong-nghe"
						, "wifi"                => "cong-nghe"
						, "pin"                 => "cong-nghe"
						, "camera"              =>"cong-nghe"
						," dien-thoai"          =>"cong-nghe"
						, "tri-lieu"            => "cong-nghe"
						, "day-sac"             => "cong-nghe"
						, "laptop"              => "cong-nghe"
						, "gay-chup-hinh"       => "cong-nghe"
						, "bo-sac"              => "cong-nghe"
						, "am-thanh"            => "cong-nghe"
						, "tivi"                => "cong-nghe"
						, "audio"               => "cong-nghe"
						, "video"               => "cong-nghe"
						, "op-lung"             => "cong-nghe"
						, "bao-da"              => "cong-nghe"
						, "may-tinh-bang"       => "cong-nghe"
						, "hdmi"                => "cong-nghe"
						, "iphone"              => "cong-nghe"
						, "thiet-bi-android"    => "cong-nghe"
						, "dau-doc-the"         => "cong-nghe"
						, "du-lich"             => "du-lich"
						, "tour"                => "du-lich"
						, "nghi-duong"          => "du-lich"
						, "khach-san"           => "du-lich"
						, "nha-hang"            => "du-lich"
						, "resort"              => "du-lich"
						, "holiday"             => "du-lich"
						, "buffet"              => "am-thuc"
						, "an-uong"             => "am-thuc"
						, "may-xay-sinh-to"     => "gia-dung-va-noi-that"
						, "cay-vot-muoi"        => "gia-dung-va-noi-that"
						, "thot-go"             => "gia-dung-va-noi-that"
						, "hop-dung-com"        => "gia-dung-va-noi-that"
						, "hop-com"             => "gia-dung-va-noi-that"
						, "tam-tham"            => "gia-dung-va-noi-that"
						, "noi-dat"             => "gia-dung-va-noi-that"
						, "dung-cu"             => "gia-dung-va-noi-that"
						, "noi-ap-suat"         => "gia-dung-va-noi-that"
						, "chao-chong-dinh"     => "gia-dung-va-noi-that"
						, "hop-nhua"            => "gia-dung-va-noi-that"
						, "am-dun-nuoc"         => "gia-dung-va-noi-that"
						, "gas"                 => "gia-dung-va-noi-that"
						, "noi"                 => "gia-dung-va-noi-that"
						, "may-ep"              => "gia-dung-va-noi-that"
						, "lo-nuong"            => "gia-dung-va-noi-that"
						, "lo-vi-song"          => "gia-dung-va-noi-that"
						, "quat"                => "gia-dung-va-noi-that"
						, "quat-may"            => "gia-dung-va-noi-that"
						, "quat-sac"            => "gia-dung-va-noi-that"
						, "may-hut-bui"         => "gia-dung-va-noi-that"
						, "ban-ui"              => "gia-dung-va-noi-that"
						, "voi-tam-hoa-sen"     => "gia-dung-va-noi-that"
						, "electronic"          => "gia-dung-va-noi-that"
						, "den-led"             => "gia-dung-va-noi-that"
						, "bon-cau"             => "gia-dung-va-noi-that"
						, "tre-em"              => "me-va-be"
						, "me-va-be"            => "me-va-be"
						, "dam-me-be"           => "me-va-be"
						, "but-chi-mau"         => "me-va-be"
						, "bo-mau-ve"           => "me-va-be"
						, "hop-mau"             => "me-va-be"
						, "nuoc-hoa"            => "spa-va-lam-dep"
						, "my-pham"             => "spa-va-lam-dep"
						, "kem-tay"             => "spa-va-lam-dep"
						, "sua-tam"             => "spa-va-lam-dep"
						, "kem-duong"           => "spa-va-lam-dep"
						, "wax"                 => "spa-va-lam-dep"
						, "mat-na"              => "spa-va-lam-dep"
						, "massage"             => "spa-va-lam-dep"
						, "trang-diem"          => "spa-va-lam-dep"
						, "nhu-hoa"             => "spa-va-lam-dep"
						, "bo-kem-cat-mong-tay" => "spa-va-lam-dep"
						, "may-hut-mun"         => "spa-va-lam-dep"
						, "dung-cu-lam-mong"    => "spa-va-lam-dep"
						, "nang-nguc"           => "spa-va-lam-dep"
						, "triet-long"          => "spa-va-lam-dep"
						, "hap-trang"           => "spa-va-lam-dep"
						, "kem-tri-tham"        => "spa-va-lam-dep"
						, "chong-nang"          => "spa-va-lam-dep"
						, "may-cao-rau"         => "khac"
						, "bo-giac-hoi"         => "khac"
						, "tong-do"             => "khac"
						, "luoi-dem"            => "khac"
						, "bo-voi-sen"          => "khac"
						, "cat-mau"             => "khac"
						, "goi"                 => "khac"
						, "hot-quet-bat-lua"    => "khac"
						, "quat"                => "khac"
						, "bo-co-tuong"         => "khac");

	const UNKNOWN_LABEL			= 'Khác';
	const UNKNOWN_CODE			= 'khac';
	const STATUS				= 'Đang bán';
	const DEFAULT_CITY			= 'Tp. Hồ Chí Minh';

	public function __construct($url = "",$area="",$hash = "",$sitename=""){
		ini_set('user_agent', 'Allcoupon Spider/1.0(+http://vn.allcoupon.asia/)');
		$this->DB_coupon = CB_Factory::getDbObject("coupon");
		$this->execute($url,$area="",$hash = "",$sitename="");
	}

	public function execute($url,$area="",$hash = "",$sitename=""){
		$this->buf = @file_get_contents($url);
		if(!$this->buf){
			return;
		}

		$this->url = $url;
		$this->data=array();
		$this->data["coupon_hash"] = $hash;
		$this->data["coupon_area"] = $area;
		$this->init();

		if(!$this->data["coupon_site"]){
			if($sitename){
				// サイト名はsetSiteIdandRateメソッド内で入れる。仮仕様。
				$this->data["coupon_site"]=$sitename;
			}
		}


		$this->data["coupon_title"]          = $this->getTitle();
		$this->data["coupon_url"]            = $this->getUrl();
		$this->data["coupon_untilldatetime"] = $this->getUntillDate();
		$this->data["coupon_summary"]        = $this->getSummary();
		$this->data["coupon_teika"]          = $this->getTeika();
		$this->data["coupon_kakaku"]         = $this->getKakaku();

		$shop = $this->getShop();
		if( strrpos( $shop,"&") !==false && strrpos( $shop,";") !==false ){
			$this->data["coupon_shop"] = mb_convert_encoding($shop, 'UTF-8', 'HTML-ENTITIES');
		}else{
			$this->data["coupon_shop"] = $shop;
		}

		$this->data["coupon_addr"]    = $this->getAddr();
		$this->data["coupon_access"]  = $this->getAccess();
		$this->data["coupon_lat"]     = $this->getLat();
		$this->data["coupon_lng"]     = $this->getLng();
		$this->data["coupon_status"]  = $this->getStatus();
		$this->data["coupon_max"]     = $this->getMax();
		$this->data["coupon_sold"]    = $this->getSold();
		$this->data["_coupon_photo"]  = $this->getPhoto();

		$this->data["coupon_title"]   = str_replace("'", "''", $this->data["coupon_title"]);
		$this->data["coupon_summary"] = str_replace("'", "''", $this->data["coupon_summary"]);
		$this->data["coupon_shop"]    = str_replace("'", "''", $this->data["coupon_shop"]);
		$this->data["coupon_addr"]    = str_replace("'", "''", $this->data["coupon_addr"]);

		$this->savePhoto($this->getPhoto());
		$this->update();

		unset($this->buf);
	}

	abstract public function getUrl();

	public function getData(){
		return $this->data;
	}

	public function init(){
	}

	abstract public function getTitle();

	abstract public function getPrice();

	abstract public function getLat();

	abstract public function getLng();

	public function savePhoto($path){

		if(!$path){
			return false;
		}
		if(is_array($path)){
			$path = preg_replace("/ /","%20",$path[1]);
		}else{
			$path = preg_replace("/ /","%20",$path);
		}

		//???
		$path = preg_replace_callback(
					"/[^_a-zA-Z0-9[:punct:]]/",
					create_function('$matches', 'return urlencode($matches);'),
					$path
				);

		$image_buf = @file_get_contents($path);
		if(!$image_buf){
			echo "画像取得エラー　{$path} ";
		}

		// pita ticketはパラメータ付きじゃないと画像が取れないので、パラメータ除外処理はスキップ
		if ($this->data['site_id'] != 23){
			$path = preg_replace("/\?.*?$/", "", $path);
		}

		preg_match("/([^\.]+)$/", $path, $match);

		// http://img.snjn.jp/deal/619/1/240 などの画像URLもあるため。拡張子とれない場合はとりあえずjpeg
		if( ! preg_match("/(jpeg|png|jpg|gif)$/", $match[1] ) ){
				$match[1]="jpeg";
		}

		@mkdir(dirname(__FILE__)."/../../public/img/pic/". date("Ym"));
		@mkdir(dirname(__FILE__)."/../../public/img/pic/m". date("Ym"));
		$this->data["coupon_photo"] = "/img/pic/". date("Ym") ."/".md5($path).".{$match[1]}";

		if(file_exists(dirname(__FILE__)."/../../public{$this->data["coupon_photo"]}") && !$this->photoReload){
			echo "Image already exists.<br>";
			return;
		}

		if(preg_match("/(jpeg|png|jpg|gif)$/",$this->data["coupon_photo"],$match)){
			$type = $match[1];
			$tmp_name = "/tmp/".md5(rand(0,9999999)."allcoupon_photo")."ac_photo";

			$buf = @file_get_contents($path);
			if(!$buf){
				$buf = @file_get_contents($path);
			}
			file_put_contents($tmp_name,$buf);

			//画像保存
			//▼imagemagick  GDより画質良い。ただし処理重い

			$local_path = dirname(__FILE__)."/../../public{$this->data["coupon_photo"]}";
			$image3 = new AC_ImageMagick($tmp_name);
			$image3->createResizedImage(300,500, $local_path);
			$local_path2 = str_replace("/img/pic/" , "/img/pic/m",$local_path);
			$image4 = new AC_ImageMagick($tmp_name);
			$image4->createResizedImage(345,500, $local_path2);

			if(file_exists($tmp_name)){
				unlink($tmp_name);
			}

		}

	}

	public function update(){
		//エリアの整形
		$this->areaClearing( $this->data["coupon_pref"]);

		if($this->data["coupon_area"] == self::UNKNOWN_LABEL){
			//エリア再取得
			if((!$this->data["coupon_lat"] || !$this->data["coupon_lng"]) && $this->data["coupon_addr"]){
				$json = @file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".urlencode($this->data["coupon_addr"])."&sensor=false");
				$geo = json_decode($json, true);
				$this->data["coupon_lat"] = $geo["results"][0]["geometry"]["location"]["lat"];
				$this->data["coupon_lng"] = $geo["results"][0]["geometry"]["location"]["lng"];
			}

			$this->getAreaFromLatLng($this->data["coupon_lat"], $this->data["coupon_lng"]);
		}

		if( ! $this->data["coupon_status"] ){
			$this->data["coupon_status"] = self::STATUS;
		}

		// カテゴリーの設定
		$this->category2Clearing($this->data["category2_type_code"]);

		// //デバッグなら終了
		// if( defined('DEBUG') && DEBUG ) {
		// 	$this->debug();
		// 	return;
		// }

		// d($this->data);

		//クーポンURL、都道府県をキーに同一クーポンかチェック
		$select = $this->DB_coupon->select()
			->where("coupon_url = ?", $this->DB_coupon->quote($this->data["coupon_url"]));

		$row = $this->DB_coupon->fetchRow($select);

		// 新規
		if(!$row){

			if($this->data["coupon_title"]){

				if((!$this->data["coupon_lat"] || !$this->data["coupon_lng"]) && $this->data["coupon_addr"]){
					echo  "Đang lấy kinh độ vĩ độ ...";
					$json = @file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".urlencode($this->data["coupon_addr"])."&sensor=false");
					$geo = json_decode($json, true);
					$this->data["coupon_lat"] = $geo["results"][0]["geometry"]["location"]["lat"];
					$this->data["coupon_lng"] = $geo["results"][0]["geometry"]["location"]["lng"];
					echo  " Hoàn tất<br>";
				}

				//緯度経度情報からエリア名取得
				if($this->data["coupon_area"] ==self::UNKNOWN_LABEL){
					$this->getAreaFromLatLng($this->data["coupon_lat"], $this->data["coupon_lng"]);
				}

				//キュー新規作成
				$this->data["coupon_sold_queue"] = serialize(array($this->data["coupon_sold"]));

				//サイトIDとサイト名とデフォルトレートの設定
				$this->setSiteIdNameRate( true );

				$this->data['groupby_id'] = $this->data['site_id']*10000000;
				//新規クーポンデータの挿入
				unset($this->data["coupon_id"]);
				$this->data["coupon_id"] = $this->DB_coupon->autoIu($this->data);
				echo "&gt; ADD ID:{$this->data["coupon_id"]}, {$this->data["coupon_area"]}, {$this->data["coupon_url"]}<br>";

				// API検索 group_by 用のidをセット　サイトID4ケタ、クーポンID7ケタ。（titleでのgroupbyは重いため。）
				if( $this->data['coupon_title'] && $this->data['site_id'] ){
					$select = $this->DB_coupon->select()->where( "coupon_title=?", $this->data['coupon_title'] )->where( "site_id=?", $this->data['site_id'] )->order("coupon_id")->limit(1);
					$tmp = $this->DB_coupon->fetchRow($select);
					$this->data['groupby_id'] = $tmp['site_id']*10000000 + $tmp['coupon_id'];
					$this->DB_coupon->autoIu($this->data);
				}
			}

			// 更新
		}elseif($row["coupon_id"]){
			$this->is_update = true;

			// //Because data is existing, stop scraping to save processing
			// return;

			 $this->data["coupon_id"] = $row["coupon_id"];

			// //サイトIDとサイト名の設定
			// $this->setSiteIdNameRate( true );

			// //ロックされていたらアフィリエートレートは更新しない。
			// if($row["is_rate_locked"]){
			// 	$this->data["affiliate_rate"] = $row["affiliate_rate"];
			// }
// dd(htmlspecialchars($this->data["coupon_heed"]));
// dd($this->data->coupon_heed);

			 $this->DB_coupon->autoIu($this->data);
			 echo "&gt; UPDATE ID:{$this->data["coupon_id"]}, {$this->data["coupon_area"]}, {$this->data["coupon_url"]}<br>";

		}else {
			echo "<font color='red'><b>Did not insert or update</b></font><br>\n";
			echo "select<br>\n";
			d($select[0]);
			echo "data:<br>\n";
			d($this->data);
			echo "<br>\n";
		}
		/*
		// API検索 group_by 用のidをセット　サイトID4ケタ、クーポンID7ケタ。（titleでのgroupbyは重いため。）
		$select = $this->DB_coupon->select()->where( "coupon_title=?", $this->data['coupon_title'] )->where( "site_id=?", $this->data['site_id'] )->order("coupon_id")->limit(1);
		$tmp = $this->DB_coupon->fetchRow($select);
		$this->data['groupby_id'] = $tmp['site_id']*10000000 + $tmp['coupon_id'];
		$this->DB_coupon->autoIu($this->data);

		echo date("i:s");
		*/
	}


	public function debug(){
		//foreach($this->data AS $key=>$val){
		//	$this->data[$key] = trim(strip_tags($val));
		//}

		$validate = $this->validate();

		if(!$validate){
			echo "<font color=red>Error: Validate {$this->data["coupon_url"]} Class: ".get_class($this)."</font>\n";

			$img_path2 = str_replace("/img/pic/" , "/img/pic/m",$this->data['coupon_photo']);
			$this->data['debug_coupon_photo'] = "<img src='{$this->data['coupon_photo']}' ><img src='{$img_path2}' >";
			d($this->data);
			return false;
		}

		if( ( defined('DEBUG') && DEBUG ) || (defined("SC_DEBUG") && SC_DEBUG)){

			$img_path2 = str_replace("/img/pic/" , "/img/pic/m",$this->data['coupon_photo']);
			$this->data['debug_coupon_photo'] = "<img src='{$this->data['coupon_photo']}' ><img src='{$img_path2}' >";
			d($this->data);


		}
	}

	public function validate(){

		$keys = array(
				"coupon_title",
		//		"coupon_summary",
		//		"coupon_teika",
		//		"coupon_kakaku",
		//		"coupon_photo",
		//		"coupon_sold",
		//		"coupon_max",
		);

		foreach($keys AS $key){
			if(!$this->data[$key]){

				/*
				// 空は不許可だが、0円は許可する場合。
				if( $key == "coupon_kakaku"   && !is_numeric( $this->data[$key] ) ) {
					echo "<font color=red>Error: no {$key}  {$this->data["coupon_url"]}</font>\n";
					return;
				}
				*/

				echo "<font color=red>Error: no {$key}  {$this->data["coupon_url"]}</font>\n";
				return;

			}
		}

		if(!strtotime($this->data["coupon_untilldatetime"])){
			echo "Warning: Can't Get coupon_untilldatetime {$this->data["coupon_url"]}\n";
			//$this->data["coupon_untilldatetime"] = date("Y-m-d H:i:s", time()+3600*24*2); //2日後をセット
			$this->data["coupon_untilldatetime"] = date("Y-m-d 00:00:00"); //終了したクーポンで日付を取れないものがあるため、日付がなければ、、、本日にセット。
		}

		return true;
	}

	//都道府県エリアの整形
	public function areaClearing( $coupon_area ){
		$this->data["coupon_area"] = $coupon_area;
	}

	//緯度経度から都道府県を取得
	public function getAreaFromLatLng($lat, $lng){
		$url = "http://maps.google.com/maps/geo?ll={$lat},{$lng}&output=xml&key=GOOGLE_MAPS_API_KEY&hl=ja&oe=UTF8";

		$xml = @file_get_contents($url);
		if(!$xml){
			return;
		}

		require_once "XML/Unserializer.php";
		$options = array("parseAttributes" => true,);
		$parser = new XML_Unserializer($options);
		$status = $parser->unserialize($xml);

		if(PEAR::isError($status)){
			$status->getMessage();
			d("pearエラー".$status->getMessage());
			return false;
		}

		$geo = $parser->getUnserializedData();
		$state = $geo["Response"]["Placemark"][0]["AddressDetails"]["Country"]["AdministrativeArea"]["AdministrativeAreaName"];
		preg_match("/(.*?)(都|府|県)$/is", $state, $match);
		if($match[1]){
			$this->data["coupon_area"] = $match[1];
		}
	}

	/*
	 *
		1	am-thuc					Ẩm thực
		2	spa-va-lam-dep			Spa và Làm đẹp
		3	giai-tri-va-the-thao	Giải trí và thể thao
		4	du-lich					Du lịch
		5	thoi-trang				Thời trang
		6	cong-nghe				Công nghệ
		7	gia-dung-va-noi-that	Gia dụng & Nội thất
		8	thuoc-va-suc-khoe		Thuốc & Sức khoẻ
		9	me-va-be				Mẹ và bé
		10	khac					Khác
	 *
	 */
	public function category2Clearing( $category2_code = "khac" ){
		$category2_arr = array(   "am-thuc" 				=> "1"
								, "spa-va-lam-dep" 			=> "2"
								, "giai-tri-va-the-thao" 	=> "3"
								, "du-lich" 				=> "4"
								, "thoi-trang" 				=> "5"
								, "cong-nghe" 				=> "6"
								, "gia-dung-va-noi-that" 	=> "7"
								, "thuoc-va-suc-khoe" 		=> "8"
								, "me-va-be" 				=> "9"
								, "khac" 					=> "10"
								);

		$category2_id = $category2_arr[$category2_code];
		if (!$category2_id) $category2_id	= "10"; //Default: other category
		$this->data["category2_id"]		= $category2_id;
	}

	public function error($body,$title="エラー"){
		$mail = new CB_Zend_Mail();
		$mail->setBodyText($body)
		->setFrom("error_report@laxanh.vn","オールクーポン")
		->addTo("error_report@laxanh.vn")
		->setSubject("【オールクーポン】{$title}")
		->send();
	}

	public function msg($body,$title=""){
		$mail = new CB_Zend_Mail();
		$mail->setBodyText($body)
		->setFrom("error_report@laxanh.vn","オールクーポン")
		->addTo("error_report@laxanh.vn")
		->setSubject("【オールクーポン】{$title}")
		->send();
	}



}



//------------------------------------------------------------------------------------
// function
//------------------------------------------------------------------------------------


if ( !function_exists('json_decode') ){
	function json_decode($content, $assoc=false){
		require_once 'Services/JSON.php';
		if ( $assoc ){
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		} else {
			$json = new Services_JSON;
		}
		return $json->decode($content);
	}
}

if ( !function_exists('json_encode') ){
	function json_encode($content){
		require_once 'Services/JSON.php';
		$json = new Services_JSON;

		return $json->encode($content);
	}
}


// post して返り値取得する関数
function file_post_contents( $url , $data=array()){

	if( $url && $data ){

		$data = http_build_query($data, "", "&");

		$header = array(
		    "Content-Type: application/x-www-form-urlencoded",
		    "Content-Length: ".strlen($data)
		);

		$context = array(
		    "http" => array(
		        "method"  => "POST",
		        "header"  => implode("\r\n", $header),
		        "content" => $data
		)
		);

		return file_get_contents($url, false, stream_context_create($context));
	}

}
