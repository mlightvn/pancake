<?php

/**
 * 
 * @author 
 * @see http://www.saha.vn/utility/rss
 *
 */
class AC_scraping_saha_rss extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){
		$url = "http://www.saha.vn/utility/rss";
		$doc = new DOMDocument();
		$doc->load($url);

		$feed_rss = array();
		foreach ($doc->getElementsByTagName('item') as $node) {
			$this->data = array('link' =>  $node->getElementsByTagName('link')->item(0)->nodeValue);
			array_push($feed_rss, $this->data);
		}

		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";
		$i =1;
 		foreach ($feed_rss as $url) {

			$url = html_entity_decode($url['link']);
			echo $i++. " => <a href= ". $url ." target='_blank'>saha RSS: </a>: " . $url . "<br>";

			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "saha rss detail : file gets error.<br>";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
			//エリア名整形
			$this->url = $url;
			$this->data = array();
			$this->data["coupon_pref"] = $prefecture;
			$this->init();
			$this->data["site_id"]               = 12;
			$this->data["coupon_title"]          = $this->getTitle();
			$this->data["coupon_url"]            = $url;
			$this->data["coupon_untilldatetime"] =  $this->getUntillDatetime();
			$this->data["coupon_summary"]        = $this->getSummary();
			$this->data["category2_type_code"]   = $this->getCategory2($url);
			$this->data["coupon_teika"]          =  $this->getTeika();
			$this->data["coupon_kakaku"]         = $this->getKakaku();
			$this->data["coupon_shop"]           = $this->getShop();
			$this->data["coupon_addr"]           = $this->getAddress();
			$this->data["coupon_heed"]           = $this->getHeed();
			$this->data["coupon_access"]         = "-";
			$this->data["coupon_status"]         = self::STATUS;
			$this->data["coupon_sold"]           = "-";
			$this->data["_coupon_photo"]         = $this->getPhoto();

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
		preg_match("/<h1 class=\"product-title\">(.*?)<\/h1>/is", $this->buf, $match);
		$result_s = strip_tags($match[1]);
		return $result_s;
	}

	public function getSummary(){
		preg_match("/<div class=\"product-description\"><h2 class=\"sec-title\">(.*?)<\/h2>(.*?)<\/div>/is", $this->buf, $match);
		return '<div class="couponDetail">'.$match[2].'</div>';
	}

	public function getCategory2($url){
		$category2_arr = array(   
			"thoi-trang-nu"         => "thoi-trang"
			, "thoi-trang-nam"      => "thoi-trang"
			, "thoi-trang-tre-em"   => "thoi-trang"
			, "phu-kien-thoi-trang" => "thoi-trang"
			, "an-uong"             => "am-thuc"
			, "giai-tri"            => "giai-tri-va-the-thao"
			, "suc-khoe-lam-dep"    => "spa-va-lam-dep"
			, "cong-nghe"           => "cong-nghe"
			, "me-va-be"            => "me-va-be"
			, "gia-dung"            => "gia-dung-va-noi-that"
			, "sach-hay"            => "khac"
			);

		$filter_title = $this->filter;
		preg_match("/http:\/\/www\.saha\.vn\/(.*?)\/(.*?)\/(.*?)\/(.*?)\.aspx/is", $url, $match);
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
		preg_match("/<div class=\"list-price\">Giá gốc: (.*?)<sup>đ<\/sup>&nbsp;((.*?))<\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}

	public function getKakaku(){
		preg_match("/<div class=\"sell-price\">(.*?)<sup>đ<\/sup><\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}

	public function getShop(){
		return "Công ty CP Công Nghệ SAN HÀ";
	}

	public function getAddress(){
		return "141/17 Bàn Cờ̀, Phường 3, Quận 3, Tp.HCM";
	}

	public function getPhoto(){
		preg_match_all("/<li><img border=\"0\" alt=\"(.*?)\" src=\"(.*?)\" \/><\/li>/is", $this->buf, $match);
		return $match[2][0];
	}

	public function getHeed(){
		$data =  $this->getHeedFeature() . $this->getHeedNotice();
		return $data;
	}

	public function getHeedFeature(){
		preg_match("/<div class=\"span6 product-feature\"><h2 class=\"sec-title\">(.*?)<\/h2>(.*?)<\/div>/is", $this->buf, $match);
		return '<div class="couponFeature"><h4>Điểm nổi bật</h4>'.$match[2].'</div></div>';
	}

	public function getHeedNotice(){
		preg_match("/<div class=\"span6 product-conditions\"><h2 class=\"sec-title\">(.*?)<\/h2>(.*?)<\/div>/is", $this->buf, $match);
		return '<div class="couponNotice"><h4>Lưu ý khi mua</h4>'.$match[2].'</div></div></div>';
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}
}