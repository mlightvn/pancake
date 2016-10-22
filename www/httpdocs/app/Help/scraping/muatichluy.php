<?php

/**
 * muatichluy.com
 * @author 
 * @see http://www.muatichluy.com/vn/hcm/homnay.html
 *
 */
class AC_scraping_muatichluy extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false)
	{
		$url = "http://www.muatichluy.com/vn/hcm/homnay.html";
 
		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "muatichluy_today : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

 		preg_match_all("/<div id=\"products-index-inc\"><h2><a href=\"(.*?)\">/is", $this->bufList, $content);

  		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";
 

 		foreach ($content[1] as $url) {
			$url = html_entity_decode($url);
			echo "<a href= ". $url ." target='_blank'>muatichluy_today</a>: " . $url . "<br>";
			$url = $url;
			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "muatichluy_today detail : File gets error.<br>";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
			//エリア名整形
			$this->url = $url;
			$this->data = array();
			$this->data["coupon_pref"] = $prefecture;
			$this->init();

			$this->data["site_id"] = 8;
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
		preg_match("/<div id=\"title\">(.*?)<\/div>/is", $this->buf, $match);
		$result_s = mb_convert_encoding($match[1], "HTML-ENTITIES", "UTF-8"); //Must has this line for nhommua, to get full Title
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8"); //Then convert to string to insert into DB
		return $result_s;
	}

	public function getSummary(){
		preg_match_all("/<div id=\"body\">(.*?)<div id=\"left\">(.*?)<div id=\"content\">(.*?)<div id=\"cbg-condition\">(.*?)<div id=\"cbg-title\">Thông tin<\/div><div id=\"cbg-info\">(.*?)<\/div>(.*?)/is", $this->buf, $match);
		$result_s = $match[5][0];
		return $result_s;
	}

	public function getCategory2($url){
		$category2_arr = array( 
								"vay-Dam"             => "thoi-trang"
								,"so-mi-nu"           => "thoi-trang"
								,"Ao-khoac-nu"        => "thoi-trang"
								,"Ao-thun-nu"         => "thoi-trang"
								,"vay-Dam"            => "thoi-trang"
								,"bo-quan-ao-nu"      => "thoi-trang"
								,"phu-kien"           => "thoi-trang"
								,"Ao-cap"             => "thoi-trang"
								,"so-mi-nam"          => "thoi-trang"
								,"Ao-khoac-nam"       => "thoi-trang"
								,"quan-nam"           => "thoi-trang"
								,"bo-quan-ao-nu"      => "thoi-trang"
								,"Ao-thun-nam"        => "thoi-trang"
								,"phu-kien-cong-nghe" => "cong-nghe"
								,"Do-gia-dung"        => "gia-dung-va-noi-that"
								);

		preg_match("/http:\/\/www\.muatichluy\.com\/vn\/(.*?)\/(.*?)\/(.*?)\/(.*?)\/(.*?)\/(.*?)\/(.*?)\.html/is", $url, $match);
		$category2_s = $match[3];
		$result_s = $category2_arr[$category2_s];
		if (!$result_s) $result_s = "khac";
		return $result_s;
	}

	public function getTeika(){
		preg_match("/<span class=\"damua\">(.*?)đ/is", $this->buf, $match);
		$result_s = str_replace(",", "", $match[1]);
		return $result_s;
	}
	
	public function getKakaku(){
		preg_match("/<span class=\"pricesKM\">(.*?) đ/is", $this->buf, $match);
		$result_s = str_replace(",", "", $match[1]);
		return $result_s;
	}

	public function getShop(){
		return "Công ty TNHH Dịch Vụ Khang Minh";
	}

	public function getAddress(){
		return "12/26 Đào Duy Anh, P. 9, Q. Phú Nhuận, Tp.HCM";
	}

	public function getPhoto(){
		preg_match_all("/<div id=\"crinfo\"><b>(.*?)<\/b><br \/>-&nbsp;(.*?)<br \/>-&nbsp;Tel:&nbsp;(.*?)<br \/>-&nbsp;E:&nbsp;(.*?)<br \/>0-&nbsp;W:&nbsp;<a href=\"(.*?)\" target=\"_blank\">(.*?)<\/a><br \/><br \/><\/div>/is", $this->buf, $match);
		return $match[2][0];
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}
}

