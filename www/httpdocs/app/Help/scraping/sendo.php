<?php

/**
 * sendo.vn
 * @author 
 * @see http://www.sendo.vn/khuyen-mai
 *
 */
class AC_scraping_sendo extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url = "http://www.sendo.vn/khuyen-mai";

		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "sendo : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

		$pattern = "/<div class=\"content_item content_item_hover\"><div class=\"overflow_box\"> <div class=\"img_product productPreview\">(.*?)<a title=\"\" class=\"img_product\" href=\"(.*?)\">/is";
		preg_match_all($pattern, $this->bufList, $content);

		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";

		foreach ($content[2] as $url) {
			$url = html_entity_decode($url);
			echo "<a href= ". $url ." target='_blank'>Sendo</a>: " . $url . "<br>";

			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "sendo detail : File gets error.<br>";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
			//エリア名整形
			$this->url = $url;
			$this->data = array();
			$this->data["coupon_pref"] = $prefecture;
			$this->init();
			$this->data["site_id"] = 7;
			$this->data["coupon_title"] = $this->getTitle();
			$this->data["coupon_url"] = $url; 
			$this->data["coupon_untilldatetime"] =  $this->getUntillDatetime();
			$this->data["coupon_summary"] = $this->getSummary();
			$this->data["category2_type_code"] = $this->getCategory2($url);
			$this->data["coupon_teika"] =  $this->getTeika();
			$this->data["coupon_kakaku"] = $this->getKakaku();
			$this->data["coupon_shop"] = $this->getShop();
			$this->data["coupon_addr"] = '-';
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

	/* 
	 * Encode and decode:
	 * http://nadeausoftware.com/articles/2007/06/php_tip_how_decode_html_entities_web_page
	 * 
	 */
	public function getTitle(){
		preg_match("/<h1>(.*?)<\/h1>/is", $this->buf, $match);
		$result_s = strip_tags($match[1]);
		return $result_s;
	}

	public function getSummary(){
		preg_match("/<div class=\"content_tab active\" itemprop=\"description\" id=\"pr-detail-inf\"><!DOCTYPE html PUBLIC \"-\/\/W3C\/\/DTD HTML 4\.0 Transitional\/\/EN\" \"http:\/\/www\.w3\.org\/TR\/REC-html40\/loose\.dtd\"><html><body>(.*?)<\/body><\/html><\/div>(.*?)/is", $this->buf, $match);
		$result_s = $match[1];
		return $result_s;
	}

	public function getCategory2($url){
		$category2_arr = array( "thoi-trang-nu"        => "thoi-trang"
								,"thoi-trang-nam"      => "thoi-trang"
								,"me-va-be"            => "me-va-be"
								,"phu-kien-cong-nghe"  => "thoi-trang"
								,"the-thao-giai-tri"   => "giai-tri-va-the-thao"
								,"do-dung-trong-nha"   => "gia-dung-va-noi-that"
								,"khong-gian-song"     => "khac"
								,"do-dien-gia-dung"    => "do-dien-gia-dung"
								,"thuc-pham"           => "am-thuc"
								,"dien-thoai-may-tinh" => "cong-nghe"
								,"my-pham"			   => "spa-va-lam-dep"
								);

		
		$filter_title = $this->filter;

		preg_match("/https:\/\/www\.sendo\.vn\/(.*?)\/(.*?)\//is", $url, $match);
		$result_s = $category2_arr[$match[2]];

 		if ($result_s == NULL){
			preg_match("/https:\/\/www\.sendo\.vn\/(.*?)\/(.*?)\//is", $url, $match);
			$result_s = $category2_arr[$match[2]];

			foreach ($filter_title as $key => $value) {
				if (strpos($match[2], $key) !== false) {
				    $result_s = $value;
				}
			}
		}
		if (!$result_s) $result_s = "khac";
		return $result_s;
	}

	public function getTeika(){
		preg_match("/<div class=\"price\">(.*?)<div class=\"old_price\">Giá cũ: (.*?) VNĐ/is", $this->buf, $match);

		$result_s = str_replace(",", "", $match[2]);
		return $result_s;
	}
	public function getKakaku(){
		preg_match("/<div class=\"current_price\" ><span itemprop=\"price\">(.*?)<\/span> VNĐ<\/div>/is", $this->buf, $match);
		$result_s = str_replace(",", "", $match[1]);
		return $result_s;
	}

	public function getShop()
	{

		preg_match_all("/<div class=\"name_shop\">Sản phẩm bán từ shop:<a href=\"(.*?)\" title=\"(.*?)\">(.*?)<\/a>(.*?)<\/div>/is", $this->buf, $match);
		// Fix unicode
		mb_internal_encoding('UTF-8');
		if(!mb_check_encoding($match[2][0], 'UTF-8')
		    OR !($match[2][0] === mb_convert_encoding(mb_convert_encoding($match[2][0], 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {

		    $match[2][0] = mb_convert_encoding($match[2][0], 'UTF-8'); 
		}
		$result_s = strip_tags(mb_strtoupper($match[2][0],'UTF-8'));
		return $result_s;
	}

	public function getPhoto(){
		// preg_match_all("/<img class=\"lazydetail\" id=\"img_01\" alt=\"(.*?)\" src=\"(.*?)\" width=\"50\" height=\"50\" \/>(.*?)/is",$this->remove_html_comments($this->buf), $match);
		preg_match_all("/<div class=\"tab_detail_of_product\">(.*?)<img src=\"(.*?)\"/is",$this->remove_html_comments($this->buf), $match);
		return $match[2][0];
	}
	
	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}

 	function remove_html_comments($content = '') {
		return preg_replace('/<!--(.|\s)*?-->/', '', $content);
	}

}
