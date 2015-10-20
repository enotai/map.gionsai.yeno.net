<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/12
 * Time: 13:17
 */

/**
 * @param $proj_type
 * @param $proj_number
 * 企画番号に応じて画像のurlをもってきてくれるやつ
 *
 * define.phpが必要<-class-init.phpを読み込み
 * @return string
 */
function getImgUrl($proj_type, $proj_number){
  $img_dir = scandir(dirname(__FILE__) . '/../img/project/' . $proj_type);

  for($j = 2; $j < count($img_dir); $j++) {//上位ディレクトリへのリンクはパス

    //番号の先頭に0がつくものがあるから分割処理
    $img_dir_format[$j] = explode('.', $img_dir[$j]);
    $img_dir_format[$j] = explode('-', $img_dir_format[$j][0]);
    if($img_dir_format[$j][1] == $proj_number) $img_dir_addr = $j;//緩やかな比較
  }
  $img_addr = isset($img_dir_addr) ?
    BASEURL . '/img/project/' . $proj_type . '/' . $img_dir[$img_dir_addr] :
    BASEURL . '/img/project/noimg.png';

  return $img_addr;
}


/**
 * Class jsonUtil
 * jsonに関するユーティリティ
 */
class JsonUtil{
  public $json_code;

  function jsonReFormat($json_code){//テキストjsonの整形
    return json_encode(json_decode($json_code), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }

}