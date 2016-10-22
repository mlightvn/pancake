<?php
// namespace scraping;

include_once("_include/scraping.php");

class Zanado extends Scraping{

	function init(){
		$this->url_a	= [
			// "http://zanado.com/hot-deal-18.html",
			"/var/www/vhosts/laxanh.vn/tmp/scraping/zanado_hotdeal.html",
		];
	}

	public function getUrlsInListpage($list_page_url){
		$product_list_url_a = array();

		$this->buffer = @file_get_contents($list_page_url);
		if(!$this->buffer){
			echo "url: " . $list_page_url . " =&gt; cannot read.<br>\n";
			continue;
		}

		$this->buffer = str_replace(array("\n", "\r", "\t", "  "), "", $this->buffer);

		$this->buffer = preg_match("/<ul class=\"products-grid first last odd\">(.*?)<a class=\"product-content\" rel=\"nofollow\" href=\"(.*?)\"(.*?)<\/li><\/uk>/", subject);

echo htmlspecialchars($this->buffer);exit;

		// $this->buffer = preg_replace("/(\n|\t| )/", "", $this->buffer);

		// $product_list_url_a["url"] = ;

		return $product_list_url_a;
	}

	public function getProduct($url){
		// $product = array();

		foreach ($url_a as $url) {
			$this->buffer = @file_get_contents($url);
			if(!$this->buffer){
				echo "url: " . $url . " =&gt; cannot read.<br>\n";
				continue;
			}

			$product = $this->data['product'];

			$product["company_id"]     = "3";
			$product["category_id"]    = "1"; // 1: temporary
			$product["url"]            = $this->getUrl();
			$product["name"]          = $this->getTitle();
			// $product["untilldatetime"] = $this->getUntillDate();
			$product["short_description"]    = $this->getShortDescription();
			$product["description"]    = $this->getDescription();
			$product["price"]          = $this->getPrice();
			$product["market_price"]   = $this->getmarketPrice();

			// $product["address"]    = $this->getAddr();
			// $product["lat"]     = $this->getLat();
			// $product["lng"]     = $this->getLng();
			// $product["max"]     = $this->getMax();
			// $product["sold"]    = $this->getSold();
			$product["_photo"]  = $this->getPhoto();
			$product["status"]  = $this->getStatus();
		}

		return $product;
	}

}



$child = new Zanado();
// $child->execute();


