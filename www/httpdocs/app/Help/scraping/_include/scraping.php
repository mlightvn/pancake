<?php
// namespace scraping;

// include_once("_include/product.php");

// base class with member properties and methods
class Scraping {

  protected $buffer;
  protected $data;
  protected $debug_mode    = true;
  var $url_a  = [];

  const UNKNOWN_LABEL     = 'Khác';
  const UNKNOWN_CODE      = 'khac';
  const STATUS        = 'Đang bán';
  const DEFAULT_CITY      = 'Tp. Hồ Chí Minh';

  public function __construct(){
    ini_set('user_agent', 'Laxanh Spider/1.0(+http://laxanh.vn/)');
    $this->execute();
  }

  function execute()
  {
    $this->init();
    // $this->data["product"] = new Product();
    $this->processData();
    $this->update();
  }

  // abstract public function getUrl();

  // public function getData(){
  //   return $this->data;
  // }

  abstract function init();

  // abstract public function getTitle();

  // abstract public function getPrice();

  // abstract public function getLat();

  // abstract public function getLng();

  public function processData(){
    foreach ($this->url_a as $url) {
      $product_url_a = $this->getUrlsInListpage($url);

      foreach ($product_url_a as $key => $product_url) {
        $this->product = $this->getProduct($product_url);
        $this->update($this->product);
      }
    }
  }

  public function update($product){
  }

  public function getUrlsInListpage($list_page_url){
    return array();
  }

  public function getProduct($url){
    return array();
  }

  public function savePhoto($path){

  //   if(!$path){
  //     return false;
  //   }

  //   if(is_array($path)){
  //     $path = preg_replace("/ /","%20",$path[1]);
  //   }else{
  //     $path = preg_replace("/ /","%20",$path);
  //   }

  //   //???
  //   $path = preg_replace_callback(
  //         "/[^_a-zA-Z0-9[:punct:]]/",
  //         create_function('$matches', 'return urlencode($matches);'),
  //         $path
  //       );

  //   $image_buf = @file_get_contents($path);
  //   if(!$image_buf){
  //     echo "画像取得エラー　{$path} ";
  //   }

  //   // pita ticketはパラメータ付きじゃないと画像が取れないので、パラメータ除外処理はスキップ
  //   if ($this->data['site_id'] != 23){
  //     $path = preg_replace("/\?.*?$/", "", $path);
  //   }

  //   preg_match("/([^\.]+)$/", $path, $match);

  //   // http://img.snjn.jp/deal/619/1/240 などの画像URLもあるため。拡張子とれない場合はとりあえずjpeg
  //   if( ! preg_match("/(jpeg|png|jpg|gif)$/", $match[1] ) ){
  //       $match[1]="jpeg";
  //   }

  //   @mkdir(dirname(__FILE__)."/../../public/img/pic/". date("Ym"));
  //   @mkdir(dirname(__FILE__)."/../../public/img/pic/m". date("Ym"));
  //   $this->data["coupon_photo"] = "/img/pic/". date("Ym") ."/".md5($path).".{$match[1]}";

  //   if(file_exists(dirname(__FILE__)."/../../public{$this->data["coupon_photo"]}") && !$this->photoReload){
  //     echo "Image already exists.<br>";
  //     return;
  //   }

  //   if(preg_match("/(jpeg|png|jpg|gif)$/",$this->data["coupon_photo"],$match)){
  //     $type = $match[1];
  //     $tmp_name = "/tmp/".md5(rand(0,9999999)."allcoupon_photo")."ac_photo";

  //     $buf = @file_get_contents($path);
  //     if(!$buf){
  //       $buf = @file_get_contents($path);
  //     }
  //     file_put_contents($tmp_name,$buf);

  //     //画像保存
  //     //▼imagemagick  GDより画質良い。ただし処理重い

  //     $local_path = dirname(__FILE__)."/../../public{$this->data["coupon_photo"]}";
  //     $image3 = new AC_ImageMagick($tmp_name);
  //     $image3->createResizedImage(300,500, $local_path);
  //     $local_path2 = str_replace("/img/pic/" , "/img/pic/m",$local_path);
  //     $image4 = new AC_ImageMagick($tmp_name);
  //     $image4->createResizedImage(345,500, $local_path2);

  //     if(file_exists($tmp_name)){
  //       unlink($tmp_name);
  //     }

  //   }

  }
} // end of class