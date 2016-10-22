<?php

/**
 * Shareeのデータを取得
 * @author 
 * @see http://www.shareee.jp/help/9/
 *
 */
class AC_scraping_seven_deal extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url = "http://www.7deal.vn/";

		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "seven deal : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

		//2. 病院の詳細ページのURLを取得する
		preg_match_all("/<div class=\"hinh-anh\"><a href=\"(.*?)\">/is", $this->bufList, $all_coupon_urls);

		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";

		foreach($all_coupon_urls[1] AS $url){
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
			$this->data["coupon_pref"] = $prefecture;
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
		preg_match("/<h1 class=\"name\">(.*?)<\/h1>/is", $this->buf, $match);
		$result_s = mb_convert_encoding($match[1], "HTML-ENTITIES", "UTF-8"); //Must has this line for nhommua, to get full Title
		$result_s = html_entity_decode($match[1], ENT_QUOTES, "utf-8"); //Then convert to string to insert into DB
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
		$category2_arr = array( 
								"dong-ho-nam-nu" 		=> "cong-nghe"
								, "deal" 				=> "cong-nghe");

		preg_match("/http:\/\/www\.7deal\.vn\/(.*?)\//is", $url, $match);
		$result_s = $category2_arr[$match[1]];
		if (!$result_s) $result_s = "etc";

		return $result_s;
	}

	public function getTeika(){
		preg_match("/<div class=\"gia-cu\"><span>(.*?)<\/span><span>(.*?)<\/span><\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
	public function getKakaku(){
		preg_match("/<div class=\"gia-moi\"><span>(.*?)<\/span><span(.*?)>(.*?)<\/span><\/div>/is", $this->buf, $match);
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

	public function getPhone(){
		preg_match("/<p class=\"map_phone\">(.*?)<br \/>(.*?)<\/p>/is", $this->buf, $match);
		return $match[2];
	}

	public function getSold(){
		preg_match("/<span class=\"panel_icon\"><\/span><span class=\"panel_text\">(.*?)<\/span>/is", $this->buf, $match);
		return $match[1];
	}

	public function getPhoto(){
		preg_match("/<div class=\"hinh-anh col-md-6\"><img src=\"(.*?)\"/is", $this->buf, $match);
		return $match[1];
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}

}