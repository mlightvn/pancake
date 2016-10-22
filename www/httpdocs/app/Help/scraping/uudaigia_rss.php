<?php

/**
 *
 * @author
 * @see http://uudaigia.com
 *
 */
class AC_scraping_uudaigia_rss extends AC_scraping_common{

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){
		//link rss
		$url = "http://uudaigia.com/Datafeed.aspx?action=daily&shopname=allcoupon1";
		$doc = new DOMDocument();
		$doc->load($url);

		$prefecture = $this->getPrefecture();
		echo "Prefecture: " . $prefecture . "<br>";
		$this->data = array();

		foreach ($doc->getElementsByTagName('ProductDataFeed') as $node) {
			// $coupon_heed =  '<div class="couponFeature"><h4>Điểm nổi bật</h4>'.$node->getElementsByTagName('highlight')->item(0)->nodeValue.'</div>';
			 $Url   = $node->getElementsByTagName('Url')->item(0)->nodeValue;
			 echo "<a href=\"" . $Url . "\" target='_blank'>Coupon Url</a>: " . $Url . "<br>";
			 $this->buf = $this->http_response($Url);

			 if(!$this->buf){
				echo "uudaigia detail : gets content error.<br>";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);
 
			 $Description   = $node->getElementsByTagName('Description')->item(0)->nodeValue;
			 $this->init();
			 $this->data["site_id"]               = 14;
			 $this->data["coupon_title"]          = $node->getElementsByTagName('Product_Name')->item(0)->nodeValue;
			 $this->data["coupon_url"]            = $node->getElementsByTagName('Url')->item(0)->nodeValue;

			 $this->data["coupon_summary"]        = $this->getSummary();
			 $this->data["category2_type_code"]   = $this->getCategory2();
			 $this->data["coupon_teika"]          = $this->getKakaku($node->getElementsByTagName('Price')->item(0)->nodeValue);
			 $this->data["coupon_kakaku"]         = $this->getTeika($node->getElementsByTagName('Discounted_Price')->item(0)->nodeValue);
			 $this->data["coupon_shop"]           = $this->getShop();
			 $this->data["coupon_addr"]           = $this->getAddress();
			 $this->data["coupon_area"]           = $prefecture;
			 $this->data["coupon_heed"]           = $this->getHeed();
			 $this->data["affiliate_fixing_rate"]         = str_replace(',', '', $node->getElementsByTagName('Bonus')->item(0)->nodeValue);
			 $this->data["coupon_access"]         = "-";
			 $this->data["coupon_status"]         = self::STATUS;
			// $this->data["coupon_sold"]           = $node->getElementsByTagName('purchased')->item(0)->nodeValue;
			 $this->data["_coupon_photo"]         = $node->getElementsByTagName('Picture_Url')->item(0)->nodeValue;
			 $this->data["coupon_untilldatetime"] = $this->getUntillDatetime();

			 $this->savePhoto($this->data["_coupon_photo"]);
			 $this->update();

			// if($this->is_update) {
			// 	echo "Stop scraping.<br>\n";
			// 	exit; //stop all scraping
			// }

		}
	}

	public function getPrefecture(){
		return self::DEFAULT_CITY;
	}

	public function getSummary(){
		//preg_match("/<div class=\"content\"(.*?)><span (.*?)>(.*?)<\/span>(.*?)<div (.*?)>(.*?)/is", $this->buf['content'], $match);
		preg_match("/<div class=\"content\"(.*?)><span (.*?)>(.*?)<\/span>(.*?)<div (.*?)/is", $this->buf['content'], $match);
		//d($match[0]);
		return '<div class="couponDetail">'.$match[0].'</div>';
	}

	//gia thuc te
	public function getTeika($price){
		preg_match("/(.*?)₫/is",  $price, $match);
		$result_s = str_replace(",", "", $price);
		return $result_s;
	}

	//gia khuyen mai
	public function getKakaku($price){
		preg_match("/(.*?)₫/is",  $price, $match);
		$result_s = str_replace(",", "", $price);
		return $result_s;
	}

	public function getCategory2(){
		return $result_s ="thoi-trang";
	}

	public function getShop(){
		return $result_s="Công ty TNHH Thương Mại Dịch Vụ Minaland";
	}

	public function getAddress(){
		return $result_s="18/42/9 Dân Ý, phường 6, quận Tân Bình, Thành phố Hồ Chí Minh";
	}

	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}

	public function getHeed(){
		preg_match("/(.*?)<div class=\'boxcontent5a1\'>(.*?)<h2 (.*?)>Điểm nổi bật<\/h2>(.*?)<\/div>(.*?)<div class=\'boxcontent5a2\'>(.*?)<h2 (.*?)>Điều kiện áp dụng<\/h2>(.*?)<\/div>/is", $this->buf['content'], $match);
		$data =  '<div class="couponFeature"><h4>Điểm nổi bật</h4>'.$match[4].'</div>';
		$data .=  '<div class="couponFeature"><h4>Điều kiện áp dụng</h4>'.$match[8].'</div>';
		return $data;
	}

	function http_response($url)
	{
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['content'] = $content;
        return $header;
    }
}