<?php

/**
 * Shareeのデータを取得
 * @author
 * @see http://www.shareee.jp/help/9/
 *
 */
class AC_scraping_hotdeal_hcm extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url_a = array(
					"am-thuc" 				=> "http://www.hotdeal.vn/ho-chi-minh/an-uong/?sort_by=now_number&sort_order=desc",
					"spa-va-lam-dep" 		=> "http://www.hotdeal.vn/ho-chi-minh/spa-lam-dep/?sort_by=now_number&sort_order=desc",
					"giai-tri-va-the-thao" 	=> "http://www.hotdeal.vn/ho-chi-minh/dao-tao-giai-tri/?sort_by=now_number&sort_order=desc",
					"thoi-trang" 			=> "http://www.hotdeal.vn/ho-chi-minh/thoi-trang/?sort_by=now_number&sort_order=desc",
					"gia-dung-va-noi-that" 	=> "http://www.hotdeal.vn/ho-chi-minh/san-pham/?sort_by=now_number&sort_order=desc",
					"du-lich" 				=> "http://www.hotdeal.vn/ho-chi-minh/du-lich/?sort_by=now_number&sort_order=desc",
					"deal-moi" 				=> "http://www.hotdeal.vn/ho-chi-minh/",
				);

		foreach ($url_a as $url_key => $url) {

			$this->bufList = @file_get_contents($url);
			if(!$this->bufList){
				echo "hotdeal - hcm : File gets error.<br>";
				continue;
			}

			$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

			//2. クーポンの詳細ページのURLを取得する
			// preg_match_all("/<div class=\"span4product-item\">(.*?)<a href=\"(.*?)\"/is", $this->bufList, $all_coupon_urls);
			preg_match_all("/<h3 class=\"product__title\">(.*?)<a href=\"(.*?)\"/is", $this->bufList, $all_coupon_urls);

			$prefecture = self::DEFAULT_CITY;
			echo "Prefecture: " . $prefecture . "<br>";

			preg_match_all("/<div class=\"product__image\">(.*?)<img itemprop=\"image\" class=\"lazy\" (.*?)data-original=\"(.*?)\"/is", $this->bufList, $match);

			$this->photoList = $match[3];

			preg_match_all("/<div class=\"item__location\"><span class=\"glyphicon glyphicon-map-marker\"><\/span>(.*?)<\/div>/is", $this->bufList, $match);
			$district_arr = $match[1];

			$photo_i = 0;
			foreach($all_coupon_urls[2] AS $key => $url){
				$url = html_entity_decode($url);
				echo "<a href=\"http://www.hotdeal.vn" . $url . "\" target='_blank'>Coupon Url</a>: " . $url . "<br>";
				$url = "http://www.hotdeal.vn" . $url;

				$this->buf = @file_get_contents($url);
				if(!$this->buf){
					echo "hotdeal - hcm - coupon detail : File gets error.<br>";
					continue;
				}

				$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);

				//エリア名整形
				$this->url = $url;
				$this->data = array();
				$this->data["coupon_pref"] = $prefecture;
				$this->init();

				$this->data["site_id"] = 1;
				$this->data["coupon_title"] = $this->getTitle();
				if(!$this->data["coupon_title"]){
					echo "&nbsp;&nbsp;&gt;&nbsp;No title, this page is a list of products, not a detail page<br>";
					continue;
				}

				$this->data["coupon_url"] = $url;
				$this->data["coupon_untilldatetime"] = $this->getUntillDatetime();
				$this->data["coupon_summary"] = $this->getSummary();
				if($url_key == 'deal-moi'){
					$this->data["category2_type_code"] = $this->getCategory2($url, $this->data["coupon_title"]);
				}else{
					$this->data["category2_type_code"] = $url_key;
				}
				$this->data["coupon_teika"] = $this->getTeika();
				$this->data["coupon_kakaku"] = $this->getKakaku();
				$this->data["coupon_shop"] = $this->getShop();
				$this->data["coupon_addr"] = $this->getAddress();
				$this->data["coupon_district"] = $this->getDistrict($district_arr, $key);

				$this->data["coupon_access"] = "-";

				$this->data["coupon_status"] = self::STATUS;

				// $this->data["coupon_max"] = "";
				$this->data["coupon_sold"] = $this->getSold();

				preg_match_all("/<p style=\"text-align: center;\"><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);

				if(!count($match[2]))
				{
					preg_match_all("/<p><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);
				}

				if(!count($match[2]))
				{
					preg_match_all("/<p style=\"text-align: justify;\"><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);
				}

				if(!count($match[2]))
				{
					preg_match_all("/<p style=\"text-align: center;\"><em><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);
				}

				$this->data["_coupon_photo"] = "http:" . $this->photoList[$photo_i];

				$this->data["coupon_title"] = str_replace("'", "''", $this->data["coupon_title"]);
				$this->data["coupon_summary"] = str_replace("'", "''", $this->data["coupon_summary"]);
				$this->data["coupon_shop"] = str_replace("'", "''", $this->data["coupon_shop"]);
				$this->data["coupon_addr"] = str_replace("'", "''", $this->data["coupon_addr"]);

				$photo_i++;
				$this->savePhoto($this->data["_coupon_photo"]);
				$this->update();
				// if($this->is_update) {
				// 	echo "Stop scraping.<br>\n";
				// 	break;
				// }
			}
		}
	}

	/*
	 * Encode and decode:
	 * http://nadeausoftware.com/articles/2007/06/php_tip_how_decode_html_entities_web_page
	 *
	 */
	public function getTitle(){
		preg_match("/<h1 class=\"product__title\" itemprop=\"name\">(.*?)<\/h1>/is", $this->buf, $match);
		//d($match[1]);
		return $match[1];
	}

	public function getSummary(){
		$result_s  = "<div>";
		$result_s .= "<h3 class=\"product-well-title\">Điểm nổi bật</h3>";
		preg_match_all("/<h3 class=\"product-well-title\">(.*?)<\/h3><div class=\"wysiwyg\">(.*?)<\/div>/is", $this->buf, $match);
		$result_s .= $match[2][0];

		$result_s .= "<h3 class=\"product-well-title\">Điều kiện sử dụng</h3>";
		$result_s .= $match[2][1];

		preg_match_all("/<div class=\"block__headerclearfix\"><h3 class=\"block__title\">(.*?)<\/h3><\/div>(.*?)<div class=\"block__content clearfix\">(.*?)<div class=\"wysiwyg\">(.*?)<\/div>(.*?)<\/div>(.*?)/is", $this->buf, $match_info);
		$result_s .= "<h3 class=\"product-well-title\">Thông tin chi tiết</h3>";
		$result_s .= $match_info[4][1];

		preg_match_all("/<h4 class=\"panel-title\"><a role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" (.*?)>(.*?)<\/a><\/h4>/is", $this->buf, $math_address);
		$result_s .= "<h3 class=\"product-well-title\">ĐỊA ĐIỂM SỬ DỤNG</h3>";
		$address_ = '';
		if($math_address && is_array($math_address)){
			foreach ($math_address[2] as $key => $value) {
				$address_ .= "<p>".$value."</p>";
			}
		}

		if($address_ ==''){
			preg_match_all("/<div class=\"row product-address\"><div class=\"col-md-7\">(.*?)<\/div><div class=\"col-md-5\">(.*?)<\/div>/is", $this->buf, $math_address);
			$address_ .= "<p>".$math_address[2][0]."</p>";
		}
		$result_s .= $address_;

		$result_s .= "</div>";

		//d($result_s);
		return $result_s;
	}

	public function getCategory2($url, $title){
		$category2_arr = array(
								  "an-uong" 			=> "am-thuc"
								, "spa-lam-dep" 		=> "spa-va-lam-dep"
								, "my-pham" 			=> "spa-va-lam-dep"
								, "giai-tri-va-the-thao"	=> "giai-tri-va-the-thao"
								, "gia-dung" 			=> "gia-dung-va-noi-that"
								, "cong-nghe-dien-tu" 	=> "cong-nghe"
								, "me-be" 				=> "me-va-be"
								, "du-lich" 			=> "du-lich"
								, "tashuan" 			=> "khac"
								, "thuc-pham" 			=> "am-thuc"
								, "khac" 				=> "khac"
								, "thoi-trang" 			=> "thoi-trang"
								, "thoi-trang-nu" 		=> "thoi-trang"
								, "thoi-trang-nam" 		=> "thoi-trang"
								, "thoi-trang-tre-em"	=> "thoi-trang"
								, "phu-kien" 			=> "thoi-trang"
								, "thoi-trang-he" 		=> "thoi-trang"
								);

		preg_match("/http:\/\/www\.hotdeal\.vn\/ho-chi-minh\/(.*?)\//is", $url, $match);
		$category2_s = $match[1];

		//Check title to set category correctly
		if($category2_s == "dao-tao-giai-tri"){
			preg_match("/(khóa học|lớp|học|dạy|KH Anh Văn)/is", $title, $match);
			$category2_s = ($match[1] ? "khac" : "giai-tri-va-the-thao");
		}

		$result_s = $category2_arr[$category2_s];

		if (!$result_s) $result_s = "khac";

		return $result_s;
	}

	public function getTeika(){
		//preg_match("/<div class=\"list-price\">Giá gốc: (.*?)<sup>đ<\/sup>(.*?)<\/div>/is", $this->buf, $match);
		preg_match("/<div class=\"product__price product__price--list-price\"><span class=\"price price--list-price\"><span class=\"hidden-xs hidden-sm\">Giá gốc:&nbsp;<\/span><span class=\"price__value\">(.*?)<\/span><span class=\"price__symbol\">đ<\/span>(.*?)<\/span><\/div>/is", $this->buf, $match);
		$result_s = str_replace(",", "", $match[1]);
		//d($result_s);
		return $result_s;
	}

	public function getKakaku(){
		//preg_match("/<div class=\"sell-price\">(.*?)<sup>đ<\/sup><\/div>/is", $this->buf, $match);
		preg_match("/<span class=\"price\"><span class=\"price__value\" itemprop=\"price\">(.*?)<\/span><span class=\"price__symbol\">đ<\/span>(.*?)<\/span>/is", $this->buf, $match);
		$result_s = str_replace(",", "", $match[1]);
		//d($result_s);
		return $result_s;
	}

	public function getShop(){
		//preg_match("/<div class=\"address_merchant\"><a (.*?)>(.*?)<\/a><\/div>/is", $this->buf, $match);
		//dd($match);
		//return $match[2];
	}

	public function getAddress(){
		// preg_match("/<div class=\"address-box\"><div class=\"address\">(.*?)<\/div>(.*?)<hr\/>(.*?)<div class=\"phone\">(.*?)<\/div>(.*?)<\/div>/is", $this->buf, $match);
		// if($match[1] != NULL){
		// 	$result_s = $match[1];
		// }else{
		// 	preg_match("/<div class=\"address address-sub\">(.*?)<\/div>/is", $this->buf, $match);
		// 	$result_s = $match[1];
		// }
		// return $result_s;
	}

	public function getDistrict($district_arr, $key){
		//$result_s = ($district_arr[$key] == "Nhiều mẫu") ? "" : $district_arr[$key];
		//return $result_s;
	}

	public function getSold(){
		//preg_match("/<div class=\"buy-number\">(.*?)<br\/><span>đã mua<\/span><\/div>/is", $this->buf, $match);
		preg_match("/<div class=\"product__purchases\"><i class=\"fa fa-user\"><\/i>(.*)đã mua<\/div>/is", $this->buf, $match);
		//d($match[1]);
		return $match[1];
	}

	public function getUntillDatetime(){
		//preg_match("/<div class=\"remain-time\" rel=\"([0-9]+)\">/is", $this->buf, $match);
		preg_match("/<div class=\"product__availability\"><span><i class=\"hd hd-clock\"><\/i>&nbsp;<\/span><span id=\"timer-countdown\" data-time=\"([0-9]+)\"><\/span><\/div>/is", $this->buf, $match);
		$result_s = date("Y-m-d H:i:s", $match[1] );
		//d($result_s);
		return $result_s;
	}

	public function updateImage(){
		$DB_coupon = CB_Factory::getDbObject("coupon");
		$select = $DB_coupon->select(array("coupon_id", "coupon_url", "_coupon_photo", "coupon_photo"));
		$select->where("coupon_status = 1 and coupon_url like '%hotdeal%'");
		$coupon_s = $DB_coupon->fetchAll($select);

		for($i = 0 ; $i < count($coupon_s); $i++)
		{
			$url = $coupon_s[$i]["coupon_url"];
			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "hotdeal - hcm - coupon detail : File gets error.<br>";
				continue;
			}

			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);

			preg_match_all("/<p style=\"text-align: center;\"><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);

			if(!count($match[2]))
			{
				preg_match_all("/<p><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);
			}

			if(!count($match[2]))
			{
				preg_match_all("/<p style=\"text-align: justify;\"><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);
			}

			if(!count($match[2]))
			{
				preg_match_all("/<p style=\"text-align: center;\"><em><img(.*?)src=\"(.*?)\" alt=\"(.*?)\"/is", $this->buf, $match);
			}

			$coupon_s[$i]["_coupon_photo"] = $match[2][0];
			$this->savePhoto($coupon_s[$i]["_coupon_photo"]);
			$DB_coupon->autoIu($coupon_s[$i]);
			d($coupon_s[$i]);
		}
	}

	public function updateCategory()
	{
		$DB_coupon = CB_Factory::getDbObject("coupon");
		$select = $DB_coupon->select(array("coupon_id", "coupon_url", "category2_id", "coupon_title"));
		$select->where("coupon_status = 1");
		$coupon_s = $DB_coupon->fetchAll($select);

		$category2_id_arr = array(   "am-thuc" 				=> "1"
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
		$category2_arr = array(
								  "an-uong" 			=> "am-thuc"
								, "spa-lam-dep" 		=> "spa-va-lam-dep"
								, "my-pham" 			=> "spa-va-lam-dep"
								, "giai-tri-va-the-thao"	=> "giai-tri-va-the-thao"
								, "gia-dung" 			=> "gia-dung-va-noi-that"
								, "cong-nghe-dien-tu" 	=> "cong-nghe"
								, "me-be" 				=> "me-va-be"
								, "du-lich" 			=> "du-lich"
								, "tashuan" 			=> "khac"
								, "thuc-pham" 			=> "am-thuc"
								, "khac" 				=> "khac"
								, "thoi-trang" 			=> "thoi-trang"
								, "thoi-trang-nu" 		=> "thoi-trang"
								, "thoi-trang-nam" 		=> "thoi-trang"
								, "thoi-trang-tre-em"	=> "thoi-trang"
								, "phu-kien" 			=> "thoi-trang"
								, "thoi-trang-he" 		=> "thoi-trang"
								, "lam-dep" 		=> "spa-va-lam-dep"
								, "giai-tri-dao-tao" => "giai-tri-va-the-thao"
								, "cong-nghe" 		=> "cong-nghe"
								, "be-yeu" 			=> "me-va-be"
								, "an-uong" 		=> "am-thuc"
								, "giai-tri-va-the-thao"	=> "giai-tri-va-the-thao"
								,"me-va-be"            => "me-va-be"
								,"the-thao-giai-tri"   => "giai-tri-va-the-thao"
								,"do-dung-trong-nha"   => "gia-dung-va-noi-that"
								,"khong-gian-song"     => "khac"
								,"do-dien-gia-dung"    => "do-dien-gia-dung"
								,"dien-thoai-may-tinh" => "cong-nghe"
								, "ao-doi-khoac-doi"    => "thoi-trang"
								, "bao-tui-xach"        => "thoi-trang"
								, "cong-nghe-hitech"    => "cong-nghe"
								, "lam-dep-suc-khoe"    => "spa-va-lam-dep"
								, "gia-dung-thong-minh" => "gia-dung-va-noi-that"
								,"so-mi-nu"           => "thoi-trang"
								,"Ao-khoac-nu"        => "thoi-trang"
								,"Ao-thun-nu"         => "thoi-trang"
								,"vay-Dam"            => "thoi-trang"
								,"Ao-cap"             => "thoi-trang"
								,"so-mi-nam"          => "thoi-trang"
								,"Ao-khoac-nam"       => "thoi-trang"
								,"quan-nam"           => "thoi-trang"
								,"bo-quan-ao-nu"      => "thoi-trang"
								,"Ao-thun-nam"        => "thoi-trang"
								,"phu-kien-cong-nghe" => "cong-nghe"
								,"Do-gia-dung"        => "gia-dung-va-noi-that"
								);

		for($i = 0 ; $i < count($coupon_s); $i++)
		{
			$category2_s = "";
			$url = $coupon_s[$i]["coupon_url"];
			if(preg_match("/hotdeal\.vn/", $url))
			{
				preg_match("/http:\/\/www\.hotdeal\.vn\/ho-chi-minh\/(.*?)\//is", $url, $match);
				$category2_s = $match[1];
			}

			if(preg_match("/cungmua\.com/", $url))
			{
				preg_match("/http:\/\/www\.cungmua\.com\/ho-chi-minh\/(.*?)\//is", $url, $match);
				$category2_s = $match[1];
			}

			if(preg_match("/nhommua\.com\/ho-chi-minh/", $url))
			{
				preg_match("/http:\/\/www\.nhommua\.com\/ho-chi-minh\/(.*?)\//is", $url, $match);
				$category2_s = $match[1];
			}

			if(preg_match("/muahangvip\.vn/", $url))
			{
				preg_match("/http:\/\/muahangvip\.vn\/(.*?)\.html/is", $url, $match);
				$category2_s = $match[1];
			}

			if(preg_match("/muatichluy\.com/", $url))
			{
				preg_match("/http:\/\/www\.muatichluy\.com\/vn\/(.*?)\/(.*?)\/(.*?)\/(.*?)\/(.*?)\/(.*?)\/(.*?)\.html/is", $url, $match);
				$category2_s = $match[3];
			}

			if(preg_match("/sendo\.vn/", $url))
			{
				preg_match("/https:\/\/www\.sendo\.vn\/(.*?)\/(.*?)\//is", $url, $match);
				$category2_s = $match[2];
			}

			if($category2_s == "giai-tri-dao-tao"){
				preg_match("/(khóa học|lớp|học|dạy|Anh Văn|Tiếng Anh)/is", $coupon_s[$i]["coupon_title"], $match);
				$category2_s = ($match[1] ? "khac" : "giai-tri-va-the-thao");
			}

			$result_s = $category2_arr[$category2_s];
			if (!$result_s) $result_s = "khac";
			$coupon_s[$i]["category2_id"] = $category2_id_arr[$result_s];

			$DB_coupon->autoIu($coupon_s[$i]);
			d($coupon_s[$i]);
		}

	}
}
