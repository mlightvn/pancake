<?php

/**
 * 
 * @author 
 * @see http://zanado.com
 *
 */
class AC_scraping_zanado_rss extends AC_scraping_common{

	var $rss_url = "http://zanado.com/rsssm/product_km/eway.php";
	var $file_path = "/var/www/vhosts/allcoupon.asia/var/data/";
	var $rss_name = 'zanado_rss.xml';

	public function execute($url="",$area="",$hash = "",$sitename="",$tweet=false){

		$this->execShell();

		$url = $this->file_path . $this->rss_name;
		$doc = new DOMDocument();
		$doc->load($url);

		$prefecture = $this->getPrefecture();
		echo "<br>\nPrefecture: " . $prefecture . "<br>";
		$this->data = array();
		foreach ($doc->getElementsByTagName('deal') as $node) {
			$url               = str_replace("'", "''",$node->getElementsByTagName('url')->item(0)->nodeValue);
			$highlight         = str_replace("'", "''",$node->getElementsByTagName('highlight')->item(0)->nodeValue);
			$short_description = str_replace("'", "''",$node->getElementsByTagName('short_description')->item(0)->nodeValue);
			$color             = str_replace("'", "''",$node->getElementsByTagName('color')->item(0)->nodeValue);
			$size              = str_replace("'", "''",$node->getElementsByTagName('size')->item(0)->nodeValue);
			$material          = str_replace("'", "''",$node->getElementsByTagName('material')->item(0)->nodeValue);
			$style             = str_replace("'", "''",$node->getElementsByTagName('style')->item(0)->nodeValue);
			$purpose_use       = str_replace("'", "''",$node->getElementsByTagName('purpose_use')->item(0)->nodeValue);
			$suitable_season   = str_replace("'", "''",$node->getElementsByTagName('suitable_season')->item(0)->nodeValue);
			$stock_count       = ($node->getElementsByTagName('stock_count')->item(0)->nodeValue > 0) ? 'CÒN HÀNG' :'-';

			$this->buf = @file_get_contents($url);
			echo "<a href=\"" . $url . "\" target='_blank'>Coupon Url</a>: " . $url . "<br>";
			if(!$this->buf){
				echo "zanado - detail : File gets error.<br>";
				continue;
			}
			$this->buf = str_replace(array("\n", "\r", "\t", "  "), "", $this->buf);

			$arr_imgs = $this->getImages();
			$summary = $this->getSummary($short_description,$color,$size,$material,$style,$purpose_use,$suitable_season,$stock_count,$arr_imgs);

			$this->init();
			$this->data["site_id"]               = 13;
			$this->data["coupon_title"]          =  str_replace("'", "''", $node->getElementsByTagName('name')->item(0)->nodeValue);
			$this->data["coupon_url"]            = $url;

			$this->data["coupon_summary"]        = $summary;
			$this->data["category2_type_code"]   = $this->getCategory2();
			$this->data["coupon_teika"]          = $this->getKakaku();
			$this->data["coupon_kakaku"]         = $this->getTeika();
			$this->data["coupon_shop"]           = $this->getShop();
			$this->data["coupon_addr"]           = $this->getAddress();
			$this->data["coupon_heed"]           = $this->getHeed($highlight); 
			$this->data["coupon_access"]         = "-";
			$this->data["coupon_status"]         = $stock_count;
			$this->data["coupon_sold"]           = $this->getSold();
			$this->data["_coupon_photo"]         = $node->getElementsByTagName('picture_url')->item(0)->nodeValue;
			$this->data["coupon_untilldatetime"] = $this->getUntillDatetime();

			$this->savePhoto($this->data["_coupon_photo"]);
			$this->update();

			// if($this->is_update) {
			// 	echo "Stop scraping.<br>\n";
			// 	exit; //stop all scraping
			// }
		}
	}

	/*
	 get rss file.
	 because it is heavy, so we should process in our server.
	 */
	public function execShell()
	{
		// move to data folder
		$cmd = 'sudo cd ' . $this->file_path;
		echo '[' . date('Y/m/d H:i:s') . ']' . $cmd . "<br>\n";
		$cmd = $this->file_path;
		chdir($cmd);

		// delete old files
		$cmd = 'sudo rm -f eway.php';
		echo '[' . date('Y/m/d H:i:s') . ']' . $cmd . "<br>\n";
		system($cmd);

		$cmd = 'sudo rm -f ' . $this->rss_name;
		echo '[' . date('Y/m/d H:i:s') . ']' . $cmd . "<br>\n";
		system($cmd);

		// get new files
		$cmd = 'sudo wget ' . $this->rss_url;
		echo '[' . date('Y/m/d H:i:s') . ']' . $cmd . "<br>\n";
		system($cmd);

		// rename to correct name
		$cmd = 'sudo mv eway.php ' . $this->rss_name;
		echo '[' . date('Y/m/d H:i:s') . ']' . $cmd . "<br>\n";
		system($cmd);
	}

	public function getPrefecture(){
		return self::DEFAULT_CITY;
	}

	//gia khuyen mai
	public function getTeika(){
		/*preg_match("/(.*?)₫/is",  $price, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;*/

		preg_match("/<div class=\"pricespecial\"><span>(.*?)₫<\/span><\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}

	//gia thuc te
	public function getKakaku(){
		/*preg_match("/(.*?)₫/is",  $price, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;*/
		preg_match("/<div class=\"priceold\"><span>(.*?)₫<\/span><\/div>/is", $this->buf, $match);
		$result_s = str_replace(".", "", $match[1]);
		return $result_s;
	}

	public function getSummary($short_description,$color,$size,$material,$style,$purpose_use,$suitable_season,$stock_count,$arr_imgs){
		$result_s ='';
		$result_s = '<table class="specification">
							<caption>Thông số kỹ thuật </caption>
							<tbody>
								<tr>
									<th>MÔ TẢ</th>
									<td>'.$short_description.'</td>
								</tr>
								<tr>
									<th>MÀU SẮC</th>
									<td>'.$color.'</td>
								</tr>
								<tr>
									<th>KÍCH THƯỚC</th>
									<td>'.$size.'</td>
								</tr>
								<tr>
									<th>CHẤT LIỆU</th>
									<td>'.$material.'</td>
								</tr>
								<tr>
									<th>KIỂU DÁNG</th>
									<td>'.$style.'</td>
								</tr>
								<tr>
									<th>MỤC ĐÍCH SD</th>
									<td>'.$purpose_use.'</td>
								</tr>
								<tr>
									<th>MÙA PHÙ HỢP</th>
									<td>'.$suitable_season.'</td>
								</tr>
								<tr>
									<th>TÌNH TRẠNG</th>
									<td class="warning">'.$stock_count.'</td>
								</tr>
							</tbody>
						</table>';
		if(is_array($arr_imgs)){
			foreach ($arr_imgs as $key => $value) {
				$result_s .= "<div>".$value."</div>";
			}
			
		}
		return $result_s;
	}

	public function getImages(){
		//get content
		preg_match("/<div class=\"block-description\" style=\"border-top:0;margin-top:0;\">(.*?)<div class=\"viewport product-highlight\"><div class=\"title\">Điểm nổi bật<\/div>(.*?)<div class=\"product-attributes\"><div class=\"title\">Thông số kĩ thuật<\/div>(.*?)<\/div>(.*?)<\/div>(.*?)<\/div>(.*?)<p>(.*?)<\/div>(.*?)<\/div>(.*?)<\/div>(.*?)/is", $this->buf, $match);

		preg_match_all('/<img .*>/U', $match[7], $arr_matches_img_s);

		if($arr_matches_img_s){
			return $arr_matches_img_s[0];
		}
		return false;
	}

	public function getCategory2(){
		return $result_s ="thoi-trang";
	}

	public function getShop(){
		return $result_s="CÔNG TY CP ZANADO";
	}

	public function getAddress(){
		return $result_s="233B Bùi Thị Xuân, P.1, Q.Tân Bình, TP.HCM";
	}

	public function getSold(){
		preg_match("/<div class=\"sprites soluongmua\"><span>(.*?)<\/span>đã mua<\/div>/is", $this->buf, $match);
		return $match[1];
	}

	public function getHeed($highlight){
		//preg_match("/<div class=\"block-description\" style=\"border-top:0;margin-top:0;\"><div class=\"viewport product-highlight\">(.*?)<\/div><\/div>(.*?)/is", $this->buf, $match);
		$data =  '<div class="couponFeature"><h4>Điểm nổi bật</h4>'.$highlight.'</div>';
		return $data;
	}
	public function getUntillDatetime(){
		return '2999-12-31 23:59:59';
	}
}