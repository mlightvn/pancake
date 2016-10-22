<?php

/**
 * Shareeのデータを取得
 * @author 
 * @see http://www.shareee.jp/help/9/
 *
 */
class AC_scraping_kay extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url = "http://kay.vn/sale/";

		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "seven deal : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

		//2. 病院の詳細ページのURLを取得する
		preg_match_all("/<div class=\'banner-khuyenmai small\'><a target='_blank' href=\'(.*?)\'>/is", $this->bufList, $all_coupon_url_small);
		// d($all_coupon_url_small);
		preg_match_all("/<div class=\'banner-khuyenmai long\'><a target='_blank' href=\'(.*?)\'>/is", $this->bufList, $all_coupon_url_long);
		// dd($all_coupon_url_long);
		
		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";

		foreach($all_coupon_url_small[1] AS $url){
			$this->bufListDetail = @file_get_contents($url);
			$this->bufListDetail = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufListDetail);
			preg_match_all("/<div class=\'one-deal\'><a href=\'(.*?)\' class=\'one-deal-item\'>(.*?)<\/div>/is", $this->bufListDetail, $all_coupon_url_small_detail);
			if(!empty($all_coupon_url_small_detail)){
				foreach ($all_coupon_url_small_detail[1] as $url_detail) {
					$this->getDetail($url_detail);
				}
			}else{
				$this->getDetail($url);
			}
		}		

		foreach($all_coupon_url_long[1] AS $url){
			$this->bufListDetail = @file_get_contents($url);
			$this->bufListDetail = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufListDetail);
			preg_match_all("/<div class=\'one-deal\'><a href=\'(.*?)\' class=\'one-deal-item\'>(.*?)<\/div>/is", $this->bufListDetail, $all_coupon_url_long_detail);
			if(!empty($all_coupon_url_long_detail)){
				foreach ($all_coupon_url_long_detail[1] as $url_detail) {
					$this->getDetail($url_detail);
				}
			}else{
				$this->getDetail($url);
			}			
		}

	}

	public function getDetail($url){
		$url = html_entity_decode($url);
		echo "<a href= ". $url ." target='_blank'>Coupon Url</a>: " . $url . "<br>";
		$url = $url;

		$this->buf = @file_get_contents($url);
		if(!$this->buf){
			echo "seven deal - coupon detail : File gets error.<br>";
			continue;
		}
		
		$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
		//エリア名整形
		$this->url = $url;
		$this->data = array();
		$this->data["coupon_pref"] = $this->getPrefecture();
		$this->init();

		$this->data["site_id"] = 20;
		$this->data["coupon_title"] = $this->getTitle();
		$this->data["coupon_url"] = $url;
		$this->data["coupon_untilldatetime"] = $this->getUntillDatetime();
		$this->data["coupon_summary"] = $this->getSummary($url);
		$this->data["category2_type_code"] = $this->getCategory2($url);
		$this->data["coupon_teika"] = $this->getTeika();
		$this->data["coupon_kakaku"] = $this->getKakaku();
		$this->data["coupon_shop"] = $this->getShop();
		$this->data["coupon_addr"] = $this->getAddress();

		$this->data["coupon_access"] = "-";

		$this->data["coupon_status"] = self::STATUS;

		// $this->data["coupon_max"] = "";
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
			break;
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
		preg_match("/<h1 itemprop=\'name\'>(.*?)<\/h1>/is", $this->buf, $match);
		$result_s = mb_convert_encoding($match[1], "HTML-ENTITIES", "UTF-8"); 
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8"); 
		return $result_s;
	}

	public function getSummary($url){
		$tags = get_meta_tags($url);
		return $tags['description'];
	}

	/*
	 * category2 original code
		1	gourmet		Ẩm thực
		2	beauty		Làm đẹp
		3	leisure		Thể thao và giải trí
		4	travel		Du lịch
		5	goods		Mua sắm
		6	etc			Khác
	 *
	 */
	public function getCategory2($url){
		$category2_arr = array(   "an-uong" 		=> "gourmet"
								, "lam-dep" 		=> "beauty"
								, "giai-tri-dao-tao" => "etc"
								, "du-lich" 		=> "travel"
								, "thoi-trang" 		=> "goods"
								, "gia-dung" 		=> "etc" );


		preg_match("/http:\/\/www\.kay\.vn\/(.*?)\//is", $url, $match);
		$result_s = $category2_arr[$match[1]];

		if (!$result_s) $result_s = "etc";

		return $result_s;
	}

	public function getTeika(){
		preg_match("/<p class=\'text\'><span class=\'left\'>(.*?)<\/span><del id=\'realprice_14820\' data-real=\'(.*?)\'>(.*?)<\/del><u>(.*?)<\/u><\/p>/is", $this->buf, $match);
		return $match[2];
	}
	public function getKakaku(){
		preg_match("/<i id=\'soldprice_14820\' data-sold=\'(.*?)\'>(.*?)<\/i>/is", $this->buf, $match);
		return $match[1];
	}

	public function getShop(){
		preg_match("/<p class=\"map_name\">(.*?)<\/p>/is", $this->buf, $match);
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8");
		return $result_s;
	}

	public function getAddress(){
		preg_match("/<div class=\'list-points-inner\'><p><span>(.*?)<\/span><span>(.*?)<\/span><span>(.*?)<a target=\'_blank\' rel=\'nofollow\' href=\'(.*?)\' title=\'(.*?)\'>(.*?)<\/a><\/span><i>(.*?)<\/i><\/p><\/div>/is", $this->buf, $match);
		$result_s = html_entity_decode ($match[1], ENT_QUOTES, "utf-8");
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
		preg_match("/<div class=\'thongtin thongtin-4\'>(.*?)<div class=\'thongtin-img\'>(.*?)<span class=\'f-img-wrap\'>(.*?)<img alt=\'(.*?)\' src=\'(.*?)\'>(.*?)<\/span>(.*?)<\/div>(.*?)<\/div>/is", $this->buf, $match);
		return $match[1];
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}

}