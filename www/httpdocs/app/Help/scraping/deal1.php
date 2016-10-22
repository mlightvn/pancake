<?php

/**
 * deal1.vn
 * @author 
 * @see http://deal1.vn/
 *
 */
class AC_scraping_deal1 extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$url = "http://deal1.vn/";

		$this->bufList = @file_get_contents($url);
		if(!$this->bufList){
			echo "deal1.vn : File gets error.<br>";
			return;
		}

		$this->bufList = str_replace(array("\n", "\r", "\t", "  "), "", $this->bufList);

 		preg_match_all("/<figure><a href=\"(.*?)\" class=\"\"><img src=\"(.*?)\" alt=\"(.*?)\" class=\"img-responsive\"><\/a><\/figure>/is", $this->bufList, $content);

 		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>\n";

		$i = 0;

		$content[1] = array_unique($content[1]);
 		foreach ($content[1] as $url) {
			$url = html_entity_decode($url);
			echo ++$i . "<br/><a href= ". $url ." target='_blank'>Detail</a>: " . $url . "<br>\n";

			$this->buf = @file_get_contents($url);
			if(!$this->buf){
				echo "deal1.vn detail : File gets error.<br>\n";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
			//エリア名整形
			$this->url = $url;
			$this->data = array();
			$this->data["coupon_pref"] = $prefecture;
			$this->init();

			$this->data["site_id"] = 9;
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
				exit; 
			}
		}

	}
	public function getPrefecture(){
		return self::DEFAULT_CITY;
	}

	public function getTitle(){
		preg_match("/<h1 class=\"title-product\">(.*?)<\/h1>/is", $this->buf, $match); 
		$result_s = strip_tags($match[1]);
		return $result_s;
	}

	public function getSummary(){
		preg_match("/<p class=\"des-product\">(.*?)<\/p><div class=\"fb-comments\"/is", $this->buf, $match);
		$result_s = $match[1];
		$result_s = preg_replace("/ src=\"\/uploads\/products\/images/is", " src=\"http://titishop.vn/uploads/products/images", $result_s);
		return $result_s;
	}

	public function getCategory2($url){
		$category2_arr = array( 
							//Thoi-trang-Nam-Fashion-2015
							"Ao-khoac-Vest-Nam"           => "thoi-trang"
							,"Ao-khoac-Da"                => "thoi-trang"
							,"Ao-khoac-Jean"              => "thoi-trang"
							,"Ao-khoac-Kaki"              => "thoi-trang"
							,"Ao-khoac-ni-the-thao"       => "thoi-trang"
							,"Ao-khoac-du-Nam-the-thao"   => "thoi-trang"
							,"Ao-thun-tay-ngan-cho-nam"   => "thoi-trang"
							,"Ao-thun-tay-dai-cho-nam"    => "thoi-trang"
							,"ao-so-mi-tay-dai-cho-nam"   => "thoi-trang"
							,"Ao-so-mi-tay-ngan-cho-nam"  => "thoi-trang"
							,"Quan-Sort"                  => "thoi-trang"
							,"Bo-quan-ao-the-thao"        => "thoi-trang"
							,"Quan-dai-the-thao"          => "thoi-trang"
							,"Quan-nam-tap-GYM"           => "thoi-trang"
							//Thoi-trang-Nu-Fashion-2015
							,"dam-vay"                    => "thoi-trang"
							,"Ao-thun-tay-dai-cho-nu"     => "thoi-trang"
							,"Ao-thun-tay-ngan-cho-nu"    => "thoi-trang"
							,"Ao-so-mi-tay-ngan-cho-nu"   => "thoi-trang"
							,"Ao-so-mi-tay-dai-cho-nu"    => "thoi-trang"
							,"Quan-Bo-quan-ao"            => "thoi-trang"
							,"Ao-khoac-vest-nu"           => "thoi-trang"
							,"Ao-khoac-the-thao-nu"       => "thoi-trang"
							,"Ao-khoac-JEAN-nu"           => "thoi-trang"
							//Thoi-trang-doi-Style-2015
							,"Ao-thun-doi"                => "thoi-trang"
							,"Ao-khoac-doi"               => "thoi-trang"
							,"Phu-kien-do-doi"            => "thoi-trang"
							//Balo-Tui-xach-Tui-deo-cheo
							,"Balo-Nam"                   => "thoi-trang"
							,"Balo-Nu"                    => "thoi-trang"
							,"Tui-xach-nu"                => "thoi-trang"
							,"Tui-deo-cheo-nu"            => "thoi-trang"
							,"Vi-Cam-tay"                 => "thoi-trang"
							//PHu-KIeN-dIeN-THOaI-MaY-TiNH
							,"Phu-kien-APPLE"             => "cong-nghe"
							,"Phu-kien-Samsung"           => "cong-nghe"
							,"Phu-kien-HTC"               => "cong-nghe"
							,"Phụ kiện Nokia LUMIA"       => "cong-nghe"
							,"Phu-kien-sony"              => "cong-nghe"
							,"Phu-kien-LG"                => "cong-nghe"
							,"Phu-kien-SKY"               => "cong-nghe"
							,"Phu-kien-Blackbery"         => "cong-nghe"
							,"Phu-kien-Asus-Zenfone"      => "cong-nghe"
							,"Phu-kien-oppo"              => "cong-nghe"
							,"do-choi-dien-thoai-da-nang" => "cong-nghe"
							,"WEBCAM"                     => "cong-nghe"
							,"Chuot-Ban-phim"             => "cong-nghe"
							,"Fan-tan-nhiet"              => "cong-nghe"
							,"do-choi-Laptop"             => "cong-nghe"
							,"Thiet-bi-WIFI"              => "cong-nghe"
							,"Loa-may-tinh"               => "cong-nghe"
							,"dau-doc-the"                => "cong-nghe"
							//THIeT-Bi-LuU-TRu-USB-THe-NHo
							,"USB-Du-lieu"                => "cong-nghe"
							,"o-Cung-di-dong"             => "cong-nghe"
							,"o-Cung-SSD"                 => "cong-nghe"
							,"USB-OTG-2-daU"              => "cong-nghe"
							,"The-nho-dien-thoai-4G"      => "cong-nghe"
							,"The-nho-dien-thoai-8G"      => "cong-nghe"
							,"The-nho-dien-thoai-16G"     => "cong-nghe"
							,"The-nho-dien-thoai-32G"     => "cong-nghe"
							,"The-nho-dien-thoai-64G"     => "cong-nghe"
							,"The-nho-dien-thoai-128G"    => "cong-nghe"
							,"The-nho-may-anh-4G"         => "cong-nghe"
							,"The-nho-may-anh-8G"         => "cong-nghe"
							,"The-nho-may-anh-16G"        => "cong-nghe"
							,"The-nho-may-anh-32G"        => "cong-nghe"
							,"The-nho-may-anh-64G"        => "cong-nghe"
							,"The-nho-may-anh-128G"       => "cong-nghe"
							,"dau-doc-the"                => "cong-nghe"
							//TAI-NGHE-BLUETOOTH
							,"Bluetooth-OPPO-New"         => "cong-nghe"
							,"Bluetoooth-YINCINE"         => "cong-nghe"
							,"Bluetooth-LG"               => "cong-nghe"
							,"Bluetooth-Jabra"            => "cong-nghe"
							,"Bluetooth-Bluedio"          => "cong-nghe"
							,"Bluetooth-Sony-Ericsson"    => "cong-nghe"
							,"Bluetooth-Gblue"            => "cong-nghe"
							,"Bluetooth-Samsung"          => "cong-nghe"
							,"Bluetooth-Nokia"            => "cong-nghe"
							,"Bluetooth-IPHONE"           => "cong-nghe"
							//THIeT-Bi-aM-THANH-LOA-MP3
							,"Loa-the-nho-USB"            => "cong-nghe"
							,"Loa-bluetooth"              => "cong-nghe"
							,"Phu-kien-loa"               => "cong-nghe"
							,"Tai-nghe-may-tinh"          => "cong-nghe"
							,"Tai-nghe-dien-thoai"        => "cong-nghe"
							,"May-nghe-nhac-IPOD"         => "cong-nghe"
							//Lam-dep-My-pham-Thuc-pham
							,"Kem-duong-trang"            => "spa-va-lam-dep"
							,"Kem-tri-nam-va-duong-trang" => "spa-va-lam-dep"
							,"Kem-tri-mun-va-duong-da"    => "spa-va-lam-dep"
							,"Kem-chong-nhan-va-lao-hoa"  => "spa-va-lam-dep"
							,"Kem-duong-trang-body"       => "spa-va-lam-dep"
							,"Kem-chong-nang-SPF"         => "spa-va-lam-dep"
							,"Kem-duong-vung-kin"         => "spa-va-lam-dep"
							,"Kem-massage-Nguc"           => "spa-va-lam-dep"
							,"Tam-trang-nhanh"            => "spa-va-lam-dep"
							,"Kem-triet-long"             => "spa-va-lam-dep"
							,"Maccara-mi-day"             => "spa-va-lam-dep"
							,"Bo-phan-trang-diem"         => "spa-va-lam-dep"
							,"Kem-nen-BB"                 => "spa-va-lam-dep"
							,"Sua-rua-mat-tay-trang"      => "spa-va-lam-dep"
							,"Co-trang-diem-chi-ke-mat"   => "spa-va-lam-dep"
							,"Son-moi-goi-cam"            => "spa-va-lam-dep"
							,"Mat-na-mat-gel-lot-mun"     => "spa-va-lam-dep"
							,"Cham-soc-toc"               => "spa-va-lam-dep"
							,"Dung-cu-lam-dep"            => "spa-va-lam-dep"
							,"Giam-can-chinh-hang"        => "spa-va-lam-dep"
							,"Kem-tan-mo-bung"            => "spa-va-lam-dep"
							,"Nuoc-hoa-nam"               => "spa-va-lam-dep"
							,"Nuoc-hoa-nu"                => "spa-va-lam-dep"
							//Me-va-be-do-choi-cho-be
							,"do-cho-me-va-be"            => "me-va-be"
							//Gia-dung-Thong-minh-den-pin
							,"do-dung-nha-bep"            => "gia-dung-va-noi-that"
							,"Thiet-bi-sua-chua"          => "gia-dung-va-noi-that"
							,"do-dung-khac"               => "gia-dung-va-noi-that"
							,"den-pin-co-lon"             => "gia-dung-va-noi-that"
							,"den-pin-sieu-nho"           => "gia-dung-va-noi-that"
							,"Phu-kien-den-pin"           => "gia-dung-va-noi-that"
							//Qua-tang-luu-niem
							,"Qua-tang-doc-dao"           => "khac"
							);

		preg_match("/http:\/\/deal1\.vn\/(.*?)\/(.*?)\.html/is", $url, $match);
		$category2_s = $match[1];
		$result_s = $category2_arr[$category2_s];
		if (!$result_s) $result_s = "khac";
		return  $result_s;
	}

	public function getTeika(){
		preg_match("/<p class=\"sale-price\">(.*?) VNĐ<\/p>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
	public function getKakaku(){
		preg_match("/<p class=\"old-price\">(.*?) VNĐ<\/p>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}
 
	public function getShop(){
		return "CỬA HÀNG DEAL1.VN";
	}

	public function getAddress(){
		preg_match("/<p class=\"info-address icon_method\">(.*?) : (.*?)<a style=\"font-style: italic\" href=\"(.*?)\">(.*?)<\/p>/is", $this->buf, $match);
		
		// Fix unicode
		mb_internal_encoding('UTF-8');
		if(!mb_check_encoding($match[0], 'UTF-8')
		    OR !($match[0] === mb_convert_encoding(mb_convert_encoding($match[0], 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {

		    $match[0] = mb_convert_encoding($match[0], 'UTF-8'); 
		}
		$result_s = strip_tags(mb_strtoupper($match[0],'UTF-8'));

		return  str_replace( '( XEM BẢN ĐỒ )', '',  $result_s);
	}

	public function getPhoto(){
		preg_match_all("/<img class=\"changle\" onclick=\"(.*?)\" id=\"img_01\" idkey=\"(.*?)\" style=\"width: 58px; height: 80px;\" src=\"(.*?)\" \/>/is", $this->buf, $match);
		return $match[3][0];
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}
}