<?php

/**
 * Shareeのデータを取得
 * @author 
 * @see http://www.shareee.jp/help/9/
 *
 */
class AC_scraping_cungmua_hcm extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url = "http://www.cungmua.com/deal-moi";

		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "cungmua : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

		//2. 病院の詳細ページのURLを取得する
		preg_match_all("/<div class=\"img\">(.*?)<a href=\"(.*?)\">(.*?)<div class=\"listdeal_hover_B\">/is", $this->bufList, $all_coupon_urls);

		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";

		// $count = count($all_coupon_urls) - 1;
		foreach($all_coupon_urls[2] AS $key => $url){
			$url = html_entity_decode($url);
			echo "<a href=\"http://www.cungmua.com" . $url . "\">Coupon Url</a>: " . $url . "<br>";
			$url = "http://www.cungmua.com" . $url;

			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "cungmua - coupon detail : File gets error.<br>";
				continue;
			}
			
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);

			//エリア名整形
			$this->url = $url;
			$this->data = array();
			$this->data["coupon_pref"] = $prefecture;
			$this->init();

			$this->data["site_id"] = 4;
			$this->data["coupon_title"] = $this->getTitle();
			$this->data["coupon_url"] = $url;
			$this->data["coupon_untilldatetime"] = $this->getUntillDatetime();
			$this->data["coupon_summary"] = $this->getSummary();
			$this->data["category2_type_code"] = $this->getCategory2($url, $this->data["coupon_title"]);
			$this->data["coupon_teika"] = $this->getTeika();
			$this->data["coupon_kakaku"] = $this->getKakaku();
			$this->data["coupon_shop"] = $this->getShop();
			$this->data["coupon_addr"] = $this->getAddress();
			$this->data["coupon_heed"] = $this->getHeed();
			$this->data["coupon_district"] = $this->getDistrict($all_coupon_urls[3], $key);

			$this->data["coupon_access"] = "-";
			
			$this->data["coupon_status"] = "Đang bán";

			// $this->data["coupon_max"] = "";
			$this->data["coupon_sold"] = $this->getSold();
			$this->data["_coupon_photo"] = $this->getPhoto();

			$this->data["coupon_title"] = str_replace("'", "''", $this->data["coupon_title"]);
			$this->data["coupon_summary"] = str_replace("'", "''", $this->data["coupon_summary"]);
			$this->data["coupon_shop"] = str_replace("'", "''", $this->data["coupon_shop"]);
			$this->data["coupon_addr"] = str_replace("'", "''", $this->data["coupon_addr"]);
			$this->data["coupon_heed"] = str_replace("'", "''", $this->data["coupon_heed"]);

			$this->savePhoto($this->data["_coupon_photo"]);

			$this->update();
			if($this->is_update) {
				echo "Stop scraping.<br>\n";
				exit; //stop all scraping
			}
		}

	}

	public function getPrefecture(){
		return self::DEFAULT_CITY;
	}

	public function getTitle(){
		preg_match("/<h1 class=\"deal_detail_name\">(.*?)<\/h1>/is", $this->buf, $match);
		$result_s = mb_convert_encoding($match[1], "HTML-ENTITIES", "UTF-8"); //Must has this line for nhommua, to get full Title
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8"); //Then convert to string to insert into DB		
		return $result_s;
	}

	public function getSummary(){
		//preg_match("/<h2 class=\"deal_detail_name_long\">(.*?)<\/h2>/is", $this->buf, $match);<div id="description" class="deal_content">
		preg_match("/<div id=\"description\" class=\"deal_content\">(.*?)<\/div>/is", $this->buf, $match);
		//$result_s = html_entity_decode ($match[1]) ;
		return '<div class="couponDetail">'.$match[1].'</div>';
	}

	public function getCategory2($url, $title){
		$category2_arr = array(
								  "thoi-trang" 		=> "thoi-trang"
								, "an-uong" 		=> "am-thuc"
								, "lam-dep" 		=> "spa-va-lam-dep"
								, "du-lich" 		=> "du-lich"
								// , "giai-tri-dao-tao"		=> "khac" //No need
								, "giai-tri-va-the-thao"	=> "giai-tri-va-the-thao"
								, "gia-dung" 		=> "gia-dung-va-noi-that"
								, "cong-nghe" 		=> "cong-nghe"
								, "be-yeu"			=> "me-va-be"
							 );

		preg_match("/http:\/\/www\.cungmua\.com\/ho-chi-minh\/(.*?)\//is", $url, $match);
		$category2_s = $match[1];

		//Check title to set category correctly
		if($category2_s == "giai-tri-dao-tao"){
			preg_match("/(khóa học|lớp|học|dạy|Anh Văn|Tiếng Anh)/is", $title, $match);
			$category2_s = ($match[1] ? "khac" : "giai-tri-va-the-thao");
		}

		$result_s = $category2_arr[$category2_s];

		if (!$result_s) $result_s = "khac";

		return $result_s;
	}

	public function getTeika(){
		preg_match("/<span id=\"detail_trueprice\" class=\"detail_trueprice\">(.*?)đ<\/span>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
	public function getKakaku(){
		preg_match("/<span id=\"price\" class=\"detail_price\">(.*?)đ<\/span>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}

	public function getShop(){
		preg_match("/<p class=\"map_name\">(.*?)<\/p>/is", $this->buf, $match);
		$result_s = html_entity_decode ($match[1]) ;
		return $match[1];
	}

	public function getAddress(){
		preg_match("/<p class=\"map_phone\">(.*?)<br \/>(.*?)<\/p>/is", $this->buf, $match);
		$result_s = html_entity_decode ($match[1]) ;
		return $match[1];
	}

	public function getDistrict($district_arr, $key){
		preg_match("/<p class=\"num_product_hover_T\">(.*?)<\/p>/is", $district_arr[$key], $match);
		$result_s = html_entity_decode ($match[1]) ;

		preg_match("/Có (.*?) lựa chọn/is", $result_s, $match2);
		$result_s = ($match2[1]) ? "" :  $result_s;

		return $result_s;
	}

	public function getPhone(){
		preg_match("/<p class=\"map_phone\">(.*?)<br \/>(.*?)<\/p>/is", $this->buf, $match);
		return $match[2];
	}

	public function getSold(){
		preg_match("/<span class=\"panel_icon\"><\/span><span class=\"panel_text\">(.*?)<\/span>/is", $this->buf, $match);
		return $match[1];
	}

	public function getPhoto(){
		preg_match("/<div class=\"deal_img_big\"><img (.*?) src=\"(.*?)\"/is", $this->buf, $match);
		$result_s = html_entity_decode ($match[2]) ;
		return $result_s;
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}
 
	public function getHeed(){
		preg_match_all("/<div class=\"deal_detail_Hi\"><h4>(.*?)<\/h4>(.*?)<\/div/is", $this->buf, $match);	 
		$data =  '<div class="couponFeature">'.$match[0][0].'</div></div></div>' ;
		$data .=  '<div class="couponNotice">'.$match[0][1].'</div></div></div>';
		return $data;
	}
}