<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/12
 * Time: 13:14
 */

/**
 * Class initialize
 *
 * 呼び出し時にassignParamを実行させる : 引数は受け入れたいパラメータの配列
 */
class Initialize {
  public $kikaku_all;
  public $page_max;

  public $type;//パラメータの種類
  public $value;//パラメータの値

  public $trans_param;//変換しなければいけないもの


  /**
   * 必要ファイルの取得
   */
  function __construct() {
    require_once(dirname(__FILE__) . '/../include/define.php');
    require_once(dirname(__FILE__) . '/../include/form.php');

    header('Content-Type: application/json; charset=utf-8');

    $kikaku_json = dirname(__FILE__) . '/../json/gionsai2015kikaku_make3.json';//企画db取得
    $this->kikaku_all = json_decode(file_get_contents($kikaku_json));

    $this->page_max = 10;//1ページの最大件数
  }

  /**
   * パラメータの英語->日本語変換
   * あまり良くないけど、このクラス内でしか使わないから$typeと$valueにしぼる
   */
  protected function transJaEn(){
    $need_trans = 0;
    foreach($this->trans_param as $value){
      if($value == $this->type) $need_trans = 1;
    }

    if($need_trans) {
      $ja_en_json = dirname(__FILE__) . '/../json/ja_en2.json';//ja->en db取得
      $ja_en_all = json_decode(file_get_contents($ja_en_json));//変数名にセンスあるものを

      $trans_type = $ja_en_all->{$this->type};

      foreach($trans_type as $key => $val) {//en_ja変換
        if($val == $this->value) $this->value = $key;
      }
    }
  }

  /**
   * @param $param
   * パラメータからget
   *
   * @return string
   */
  protected function getParam($param) {
    if(isset($_GET[$param])) $param = s($_GET[$param]);

    return $param;
  }


  /**
   * @param $query
   * typeを代入
   * 使用していない
   *
   * @return string
   * @throws Exception
   */
  function assignParam($query) {
    $param_count = 0;//パラメータがいくつだけ送られたか
    foreach($query as $key) {
      if($this->getParam($key) != $key) {//パラメータが送られてきたものか
        $this->type = $key;
        $this->value = $this->getParam($key);

        $param_count++;
      }
    }

    if($param_count === 0) throw new Exception('パラメータがない', -1);
    if($param_count > 1) throw new Exception('パラメータ多すぎ', -1);
    $this->transJaEn();//英語パラメータを日本語に変換
  }
}

class InitializeArray extends Initialize{//元は手動変換だけど、こっちは自動変換
  function transJaEnArray(){
    $ja_en_json = dirname(__FILE__) . '/../json/ja_en2.json';//ja->en db取得
    $ja_en_all = json_decode(file_get_contents($ja_en_json));//変数名にセンスあるものを

    for($i = 0; $i<count($this->type); $i++) {
      if(isset($ja_en_all->{$this->type[$i]})) $trans_type[$i] = $ja_en_all->{$this->type[$i]};

      if(isset($trans_type[$i])) {
        foreach($trans_type[$i] as $key => $val) {//en_ja変換
          if($val == $this->value[$i]) $this->value[$i] = $key;
        }
      }
    }
  }

  function assignParamArray($query) {
    $param_count = 0;//配列へ
    foreach($query as $key) {
      if($this->getParam($key) != $key) {//パラメータが送られてきたものか / これはなんだ
        $this->type[$param_count] = $key;
        $this->value[$param_count] = $this->getParam($key);
        $this->transJaEnArray();//英語パラメータを日本語に変換

        $param_count++;
      }
    }
  }
}