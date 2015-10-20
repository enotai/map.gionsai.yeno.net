<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/07/31
 * Time: 22:27
 * Comment: **複数来られた時の処理が適当すぎる / 複数条件に該当させたい**
 *          jsonOutput: 配列のインデックスを変えない
 */

require_once ('class-init.php');

require_once ('class-util.php');

require_once ('class-error.php');


/**
 * Class searchProject
 * 受け取るもの:value-右側, 全企画リスト(, page_max)
 * 選択:type-左側
 *
 * 出力:json_output
 */
class searchProject {//簡単な選択系から
  public $kikaku_all;
  public $page_max;

  public $type;//パラメータの種類
  public $value;//パラメータの値


  /**
   * 検索部分 / 条件と一致したものはkikaku_contentに入る
   * @return array
   * @throws Exception
   */
  public function matchProject() {//thisがおおすぎ / 引数をつかえ
    $kikaku_content = [];

    for($i = 0; $i < count($this->kikaku_all); $i++) {
      if(isset($this->kikaku_all[$i]->alias)) continue; //aliasとなったものの処理
      if($this->kikaku_all[$i]->{$this->type} == $this->value)//検索キーワードにマッチしたものを含むものを配列に挿入
        $kikaku_content += [$i => $this->type];//placeがなくてbuildingがある / groupも同様
    }

    if($kikaku_content == []) throw new Exception('該当なし', 402);

    $kikaku_json = $this->jsonOutput($kikaku_content);

    return $kikaku_json;
  }


  /**
   * @param $kikaku_content
   * jsonの出力 / 配列に入ったものを結合 / やり方がおかしい
   * @return string
   * @throws Exception
   */
  protected function jsonOutput($kikaku_content) {
    $i = 0;

    $json_output = '[' . "\n";
    foreach($kikaku_content as $key => $value) {
      /*仕上げ処理*/
      unset($this->kikaku_all[$key]->comment);//共通

      $this->kikaku_all[$key]->img_address = getImgUrl($this->kikaku_all[$key]->project_type, $this->kikaku_all[$key]->project_number);

      $i++;//カンマ挿入用にループ数をカウント
      $json_output .= json_encode($this->kikaku_all[$key]);
      if(!(count($kikaku_content) == $i)) $json_output .= ",\n";//最後の行にカンマを挿入しない
    }
    $json_output .= "\n" . ']';


    //必要か!?
    $json_util = new JsonUtil();
    return $json_util->jsonReFormat($json_output);

  }
}


class SearchProjectWord extends searchProject {

  /**
   * @return string
   * @throws Exception
   */
  public function matchProject() {//thisがおおすぎ / 引数をつかえ
    $kikaku_content = [];

    //this->value : 検索ワード
    if($this->value === '') throw new Exception('検索文字列がない', 301);
    for($i = 0; $i < count($this->kikaku_all); $i++) {
      $count = 0;
      $add_content = '';
      for($j = 0; $j < count($this->value); $j++) {
        if(isset($this->kikaku_all[$i]->alias)) continue; //aliasとなったものの処理

        $add_content = $this->kikaku_all[$i]->project_name . $this->kikaku_all[$i]->group_name . $this->kikaku_all[$i]->contents;//無理やりつなげて、検索対象としてぶっこむ
        if(is_int(strpos($add_content, $this->value))) //文字列が最初に登場する場所が整数か / 登場しなければfalseを返す
          $count++;//条件に一致した個数 / 複数検索用

      }
      if($count == count($this->value))
        $kikaku_content += [$i => $add_content];

    }
    if($kikaku_content == []) throw new Exception('該当なし', 402);

    $kikaku_json = $this->jsonOutput($kikaku_content);

    return $kikaku_json;
  }
}


class SearchProjectFood extends searchProject {

  /**
   * @return string
   * @throws Exception
   */
  public function matchProject() {//thisがおおすぎ / 引数をつかえ
    $kikaku_content = [];

    for($i = 0; $i < count($this->kikaku_all); $i++) {
      if(isset($this->kikaku_all[$i]->alias)) continue; //aliasとなったものの処理
      if($this->kikaku_all[$i]->project_type == 'E') {//食品のみ
        if($this->kikaku_all[$i]->category->main == $this->value)//検索キーワードにマッチしたものを含むものを配列に挿入
          $kikaku_content += [$i => $this->type];//placeがなくてbuildingがある / groupも同様
      }
    }

    if($kikaku_content == []) throw new Exception('該当なし', 402);

    $kikaku_json = $this->jsonOutput($kikaku_content);

    return $kikaku_json;
  }
}


class SearchProjectPrice extends searchProject {
  /**
   * @return string
   * @throws Exception
   */
  public function matchProject() {//thisがおおすぎ / 引数をつかえ
    $kikaku_content = [];
    $kikaku_all_tmp = $this->kikaku_all;

    $price_array = explode('-', $this->value);
    $min_price = $price_array[0];
    $max_price = $price_array[1];

    if($min_price && $max_price == false) throw new Exception('検索結果なし', 402);//他のページもまとめる場合、パラメータに基づいた判定も必要
    if($min_price == false) $min_price = 0;
    if($max_price == false) $max_price = 10000;
    if(!preg_match('/^[0-9]{0,4}$/', $min_price) || !preg_match('/^[0-9]{0,5}$/', $max_price)) throw new Exception('不正検出', -1);

    for($i = 0; $i < count($this->kikaku_all); $i++) {//元のkikaku_allをカウントに使用しないと、勝手に減ってしまう
      if(isset($kikaku_all_tmp[$i]->alias)) continue; //aliasとなったものの処理
      if($kikaku_all_tmp[$i]->project_type == 'D' || $kikaku_all_tmp[$i]->project_type == 'E') {
        foreach($kikaku_all_tmp[$i]->item as $goods => $price) {
          if(!($price >= $min_price && $price <= $max_price)) {
            unset($kikaku_all_tmp[$i]->item->$goods);
          }
        }

        if(json_decode(json_encode($kikaku_all_tmp[$i]->item), true) == []) unset($kikaku_all_tmp[$i]);//空オブジェクト判定できる方法が見つからないのでjson関数を使って配列変換;
        if(isset($kikaku_all_tmp[$i])){//isset使わないと文法エラー
          $kikaku_content[$i] = $kikaku_all_tmp[$i];
        }
      }
    }
    if($kikaku_content == []) throw new Exception('該当なし', 402);

    $kikaku_json = $this->jsonOutput($kikaku_content);

    return $kikaku_json;
  }
}

/**
 * 検索実行
 * typeに応じて処理を変化
 *
 * comment: price
 *          min_maxの処理で片方だけの場合、どこかにほぞんしておくか
 */
try {
  $init = new InitializeArray();//配列形式に移行
  $init->trans_param = ['place', 'category', 'group', 'food'];//パラメータを日本語に変換させるもの
  $init->assignParamArray(['word', 'place', 'category', 'group', 'food', 'price', 'min_price', 'max_price'], ['min_price', 'max_price']);
  //initializeを実行

  $search_result = '';
  $double = false;
  $search_value = '';
  $search_type = '';
  for($i = 0; $i < count($init->type); $i++) {//パラメータを左から見ていく
    $search = new SearchProject();

    if($init->type[$i] == 'min_price'){
      $tmp_min_price = $init->value[$i];
      if(!isset($tmp_max_price)) continue;
    }
    if($init->type[$i] == 'max_price'){
      $tmp_max_price = $init->value[$i];
      if(!isset($tmp_min_price)) continue;
    }

    if(isset($tmp_min_price) && isset($tmp_max_price)) {
      $search->type = 'price';

      $search_type = 'price';
      $search_value = $tmp_min_price . '-' . $tmp_max_price;
      $double = true;//パラメータが特殊なことを示すフラグ
    } else {
      $search->type = $init->type[$i];
      $search->value = $init->value[$i];//**つかえていない**
    }

    if(!$search->type) throw new Exception('検索対象ではない', 104);

    if($i == 0) $search->kikaku_all = $init->kikaku_all;//企画リスト
    else $search->kikaku_all = $search_result;

    switch($search->type) {//jsonのtypeに変換 / ja_enと同様の名前
      case 'place' :
        $search->type = 'building_name';
        break;

      case 'group' :
        $search->type = 'group_type';
        break;

      case 'food' :
        $search = new SearchProjectFood();//めんどくさいけど、とりま

        $search->type = $init->type[$i];
        $search->value = $init->value[$i];

        if($i == 0) $search->kikaku_all = $init->kikaku_all;
        else $search->kikaku_all = $search_result;
        break;

      case 'word' :
        $search = new SearchProjectWord();//複数条件できない


        $search->type = $init->type[$i];//インスタンス再生成
        $search->value = $init->value[$i];

        if($i == 0) $search->kikaku_all = $init->kikaku_all;
        else $search->kikaku_all = $search_result;
        break;

      case 'price' :
        $search = new SearchProjectPrice();//めんどくさいけど、とりま

        if($double){
          $search->type = $search_type;//インスタンス再生成
          $search->value = $search_value;

          if($i == 1) $search->kikaku_all = $init->kikaku_all;
          else $search->kikaku_all = $search_result;
        } else {
          $search->type = $init->type[$i];
          $search->value = $init->value[$i];

          if($i == 0) $search->kikaku_all = $init->kikaku_all;
          else $search->kikaku_all = $search_result;
        }
        break;

      default :
        break;
    }

    $search_result =  json_decode($search->matchProject());
  }
  echo $search->matchProject();
  if(count($init->type) == 0) throw new Exception('パラメータがない', 402);
/*  $search = new SearchProject();
  if($init->type[0] == 'min_price' || $init->type[0] == 'max_price') {//複数を検討…
    $search->type = 'price';
  } else {
    $search->type = $init->type[0];
    $search->value = $init->value[0];//**つかえていない**
  }

  if(!$search->type) throw new Exception('検索対象ではない', 104);

  $search->kikaku_all = $init->kikaku_all;

  switch($search->type){//jsonのtypeに変換 / ja_enと同様の名前
    case 'place' :
      $search->type = 'building_name';
      break;

    case 'group' :
      $search->type = 'group_type';
      break;

    case 'food' :
      $search = new SearchProjectFood();//めんどくさいけど、とりま

      $search->type = $init->type[0];
      $search->value = $init->value[0];

      $search->kikaku_all = $init->kikaku_all;
      break;

    case 'word' :
      $search = new SearchProjectWord();//複数条件できない

      $search->type = $init->type[0];//インスタンス再生成
      $search->value = $init->value[0];

      $search->kikaku_all = $init->kikaku_all;
      break;

    case 'price' :
      $search = new SearchProjectPrice();//めんどくさいけど、とりま

      if($init->type[0] == 'min_price' || $init->type[0] == 'max_price') {//複数を検討…
        $search->type = 'price';
        $search->value = $init->value[0] . '-' .$init->value[1];
      } else {
        $search->type = $init->type[0];
        $search->value = $init->value[0];
      }

      $search->kikaku_all = $init->kikaku_all;
      break;

    default :
      break;
  }

  echo $search->matchProject();*/

} catch(Exception $e) {//エラー回収
  $error = new Error();
  $error_message =  $error->outputError($e->getCode());

  $json_util = new JsonUtil();
  echo $json_util->jsonReFormat($error_message);
  //echo ($e->getMessage());
}