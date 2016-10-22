<?php

/**
 * Shareeのデータを取得
 * @author 
 * @see http://www.shareee.jp/help/9/
 *
 */
class AC_scraping_nhommua_hcm extends AC_scraping_common{

	public function execute($url="", $area="", $hash = "", $sitename="", $tweet=false){

		$url_a = array(
					"am-thuc" 					=> "http://www.nhommua.com/ho-chi-minh/an-uong",
					"spa-va-lam-dep" 			=> "http://www.nhommua.com/ho-chi-minh/lam-dep",
					"giai-tri-va-the-thao" 		=> "http://www.nhommua.com/ho-chi-minh/giai-tri-dao-tao",
					"thoi-trang" 				=> "http://www.nhommua.com/ho-chi-minh/thoi-trang",
					"gia-dung-va-noi-that" 		=> "http://www.nhommua.com/ho-chi-minh/gia-dung",
					"cong-nghe" 				=> "http://www.nhommua.com/ho-chi-minh/cong-nghe/phu-kien",
					"me-va-be" 					=> "http://www.nhommua.com/ho-chi-minh/be-yeu/me-va-be",
					"deal-moi" 					=> "http://www.nhommua.com/ho-chi-minh/deal-moi",
				);

		foreach ($url_a as $key => $url) {
			$this->bufList = @file_get_contents($url);
			if(!$this->bufList){
				echo "nhommua : File gets error.<br>";
				continue;
			}

			$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

			//2. 病院の詳細ページのURLを取得する
			preg_match_all("/<div class=\"img\"><a href=\"(.*?)\"><img(.*?)<\/div><\/div>/is", $this->bufList, $all_coupon_urls);

			$prefecture = $this->getPrefecture();
			echo "Prefecture: " . $prefecture . "<br>";

			foreach($all_coupon_urls[1] AS $key => $url){
				$url = html_entity_decode($url);
				echo "<a href=\"http://www.nhommua.com" . $url . "\" target='_blank'>Coupon Url</a>: " . $url . "<br>";
				$url = "http://www.nhommua.com" . $url;

				$this->buf = @file_get_contents($url);
				if(!$this->buf){
					echo "nhommua - coupon detail : File gets error.<br>";
					continue;
				}
				
				$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);

				//エリア名整形
				$this->url = $url;
				$this->data = array();
				$this->data["coupon_pref"] = $prefecture;
				$this->init();

				$this->data["site_id"] = 20;
				$this->data["coupon_title"] = $this->getTitle();
				if(!$this->data["coupon_title"]){
					echo "&nbsp;&nbsp;&gt;&nbsp;No title, this page is a list of products, not a detail page<br><br>";
					continue;
				}

				$this->data["coupon_url"] = $url;
				$this->data["coupon_untilldatetime"] = $this->getUntillDatetime();
				$this->data["coupon_summary"] = $this->getSummary();
				$this->data["category2_type_code"] = $this->getCategory2($url);
				$this->data["coupon_teika"] = $this->getTeika();
				$this->data["coupon_kakaku"] = $this->getKakaku();
				$this->data["coupon_shop"] = $this->getShop();
				$this->data["coupon_addr"] = $this->getAddress();
				$this->data["coupon_heed"] = $this->getHeed();
				$this->data["coupon_district"] = $this->getDistrict($all_coupon_urls[2], $key);
				$this->data["coupon_access"] = "-";
				$this->data["coupon_status"] = self::STATUS;
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
					break;
				}
			}
		}

	}

	public function getPrefecture(){
		return self::DEFAULT_CITY;
	}

	/* 
	 * Encode and decode:
	 * http://nadeausoftware.com/articles/2007/06/php_tip_how_decode_html_entities_web_page
	 * 
	 */
	public function getTitle(){
		preg_match("/<h1 class=\"deal_detail_name\">(.*?)<\/h1>/is", $this->buf, $match);
		$result_s = mb_convert_encoding($match[1], "HTML-ENTITIES", "UTF-8"); //Must has this line for nhommua, to get full Title
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8"); //Then convert to string to insert into DB
		return $result_s;
	}

	public function getSummary(){
		preg_match("/<div class=\"deal_content\">(.*?)<\/div>/is", $this->buf, $match);
		return '<div class="couponDetail">'.$match[1].'</div>';
	}

	public function getCategory2($url){
		$category2_arr = array(   "an-uong" 		=> "am-thuc"
								, "du-lich" 		=> "du-lich"
								, "lam-dep" 		=> "spa-va-lam-dep"
								, "giai-tri-dao-tao" => "giai-tri-va-the-thao"
								, "thoi-trang" 		=> "thoi-trang"
								, "gia-dung" 		=> "gia-dung-va-noi-that"
								, "cong-nghe" 		=> "cong-nghe"
								, "be-yeu" 			=> "me-va-be"
							 );

		preg_match("/http:\/\/www\.nhommua\.com\/ho-chi-minh\/(.*?)\//is", $url, $match);
		$result_s = $category2_arr[$match[1]];

		if (!$result_s) $result_s = "khac";

		return $result_s;
	}

	public function getTeika(){
		preg_match("/<span data-name=\"marketprice\" class=\"detail_trueprice\"><del>(.*?)đ<\/del><\/span>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
	public function getKakaku(){
		preg_match("/<span data-name=\"price\" class=\"detail_price\">(.*?)đ<\/span>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}

	public function getShop(){
		preg_match("/<p class=\"map_name\">(.*?)<\/p>/is", $this->buf, $match);
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8");
		return $result_s;
	}

	public function getAddress(){
		preg_match("/<p class=\"map_phone\">(.*?)<br \/>(.*?)<\/p>/is", $this->buf, $match);
		$result_s = html_entity_decode ($match[1], ENT_QUOTES, "utf-8");
		return $result_s;
	}

	public function getDistrict($district_arr, $key){
		preg_match("/<p class=\"info_top_L\"><span class=\"ic_city\"><\/span>(.*?)<\/p>/is", $district_arr[$key], $match);
		$result_s = $match[1];
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
		preg_match("/<img id=\"imgBig\"(.*?)src=\"(.*?)\"/is", $this->buf, $match);
		return $match[2];
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}

	public function getHeed(){
		preg_match_all("/<div class=\"deal_detail_Hi\"><h4>(.*?)<\/h4>(.*?)<\/ul>/is", $this->buf, $match);	 
		$data =  '<div class="couponFeature">'.$match[0][0].'</div></div></div>';
		$data .=  '<div class="couponNotice">'.$match[0][1].'</div></div></div>';
		return $data;
	}
}