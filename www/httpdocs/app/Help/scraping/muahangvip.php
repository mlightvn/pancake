<?php

/**
 * Shareeのデータを取得
 * @author 
 * @see http://www.muahangvip.vn
 *
 */
class AC_scraping_muahangvip extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url = "http://muahangvip.vn/";

		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "muahangvip : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

 		preg_match_all("/<div class=\"btn-buy\"><a href=\"(.*?)\">(.*?)<\/a><\/div>/is", $this->bufList, $content);
 
 		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";

 		foreach ($content[1] as $url) {
			$url = html_entity_decode($url);
			echo "<a href= ". $url ." target='_blank'>muahangvip</a>: " . $url . "<br>";

			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "muahangvip detail : File gets error.<br>";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
			//エリア名整形
			$this->url = $url;
			$this->data = array();
			$this->data["coupon_pref"] = $prefecture;
			$this->init();

			$this->data["site_id"] = 10;
			$this->data["coupon_title"] = $this->getTitle();
			$this->data["coupon_url"] = $url;
			$this->data["coupon_untilldatetime"] =  $this->getUntillDatetime();
			$this->data["coupon_summary"] = $this->getSummary();

			$this->data["category2_type_code"] = $this->getCategory2($url);

			$this->data["coupon_teika"] =  $this->getTeika();
			$this->data["coupon_kakaku"] = $this->getKakaku();
			$this->data["coupon_shop"] = $this->getShop();
			$this->data["coupon_addr"] = $this->getAddress();
			$this->data["coupon_access"] = "-";
			$this->data["coupon_status"] = self::STATUS;

 
			$this->data["coupon_sold"] = $this->getSold();
			$this->data["_coupon_photo"] = $this->getPhoto();

			$this->data["coupon_title"] = str_replace("'", "''", $this->data["coupon_title"]);
			$this->data["coupon_summary"] = str_replace("'", "''", $this->data["coupon_summary"]);
			$this->data["coupon_shop"] = str_replace("'", "''", $this->data["coupon_shop"]);
			$this->data["coupon_addr"] = str_replace("'", "''", $this->data["coupon_addr"]);

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
		preg_match("/<h1>(.*?)<a href=\"(.*?)\">(.*?)<\/a><\/h1>/is", $this->buf, $match);
		$result_s = strip_tags($match[3]);
		return $result_s;
	}

	public function getSummary(){
		preg_match_all("/<div class=\"box_product_detail box_product_description\"><div class=\"text_info_detail\">(.*?)<\/div><\/div>/is", $this->buf, $match);
		$result_s = $match[1][1];
		$result_s .= '</div>';
		return $result_s;
	}

	public function getCategory2($url){
		$category2_arr = array(   
							"thoi-trang-nu"         => "thoi-trang"
							, "thoi-trang-nam"      => "thoi-trang"
							, "ao-doi-khoac-doi"    => "thoi-trang"
							, "bao-tui-xach"        => "thoi-trang"
							, "cong-nghe-hitech"    => "cong-nghe"
							, "lam-dep-suc-khoe"    => "spa-va-lam-dep"
							, "gia-dung-thong-minh" => "gia-dung-va-noi-that"
							);

		$filter_title = $this->filter;
		preg_match("/http:\/\/muahangvip\.vn\/(.*?)\.html/is", $url, $match);
		$result_s = $category2_arr[$match[1]];

		if ($result_s == NULL){
			foreach ($filter_title as $key => $value) {
				if (strpos($match[1], $key) !== false) {
				    $result_s = $value;
				}
			}
		}

		if (!$result_s) $result_s = "khac";
		return $result_s;
	}

	public function getTeika(){
		preg_match("/<div class=\"bt_price_detail\">(.*?)&nbsp;VNĐ<\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
	public function getKakaku(){
		preg_match("/<div class=\"price_old\"><p class=\"text\">Giá gốc: (.*?)&nbsp;VNĐ<\/p>(.*?)<\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
 
	public function getShop(){
		return "Cửa hàng TITISHOP";
	}

	public function getAddress(){
		return "319 Nguyễn Trọng Tuyển, Phường 10, Quận Phú nhuận, Tp.HCM";
	}

	public function getPhoto(){
		preg_match("/<img src=\"http:\/\/muahangvip\.vn\/uploads\/tmp\/images\/product(.*?)\"/is", $this->buf, $match);
		$result_s = $match[1];
		if($result_s) {
			$result_s = "http://muahangvip.vn/uploads/tmp/images/product" . $result_s;
		}
		return $result_s;
	}

	/*public function getPhoto(){
		preg_match("/<img width=\"95\" class=\"zoom-tiny-image\" src=\"(.*?)\" alt=\"(.*?)\" \/> /is", $this->buf, $match);
		return $match[1];
	}*/

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}
}
