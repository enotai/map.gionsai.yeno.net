<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 2015/07/11
 * Time: 0:53
 * Description: パラメータ(座標)で指定された場所に対して近いものからソートした企画を返します。
 * Parameters: x(int), y(int), z(int) (,option[max_kikaku(int)]) or coord(string)
 * Return: JSON - 近い順の企画一覧(10件程度!?)
 * Comment: 座標の計算方法を幾つか!? QRコードのアレに使用予定
 *          *is_int*
 *          **座標が直接かかれなくなったので、変更が必要**
 *
 * class化: distanceを引数として、getKikakuNearbyをクラス化
 */

/*==============================各種設定================================*/
require_once('../../include/define.php');
require_once('../../include/form.php');
require_once('../../include/errorparam.php');//エラーコード格納

/*header('Access-Control-Allow-Origin:*');//クロスドメイン*/
header('Content-Type: application/json; charset=utf-8');

$kikaku_json = '../../json/gionsai2014kikaku_pre.json';//企画db取得
$kikaku_all = json_decode(file_get_contents($kikaku_json));



$x = $y = $z = $coord = $param_type = '';//検索キーワード

if(isset($_GET['coord'])) $coord = s($_GET['coord']);

if(isset($_GET['x']) && is_numeric($_GET['x'])) $x = (int)s($_GET['x']);//数値かどうかの判定
if(isset($_GET['y']) && is_numeric($_GET['y'])) $y = (int)s($_GET['y']);
if(isset($_GET['z']) && is_numeric($_GET['z'])) $z = (int)s($_GET['z']);


/*=====================================================================*/
function checkParam(){
  global $x, $y, $z, $coord, $param_type;


  if(preg_match('/^[0-9]{1,2},[0-9]{1,2},[0-9]{1,2}/', $coord)){//coordエラーを記述させる
    $coord = explode(',', $coord);

    $param_type = 'coord';//coordかxyzか
  } //elseはswitch

  if($x || $y || $z){
    if(!($param_type === '')) {
      $param_type = 'double';
    }else if($x && $y && $z){
      $param_type = 'xyz';
    } else{
      throw new Exception('xyzが足りない', 103);
    } //elseはswitch
  }

  switch($param_type){
    case 'double' :
      throw new Exception('複数type', 105);

    case 'coord' :
      if(!$coord) throw new Exception('座標が存在しない', 106);
      break;

    case 'xyz' :
      if($x == '' || $y == '' || $z == '') throw new Exception('', 103);//xらがintでない時もこのエラー
      break;

    default :
      throw new Exception('typeがおかしい', 104);//すべてが空の時もこれ
  }
}


function getKikakuNearby(){
  checkParam();

  global $x, $y, $z, $coord, $type, $kikaku_all;

  if($type == 'coord'){
    $x = $coord[0];
    $y = $coord[1];
    $z = $coord[2];
  }

  for($i = 0; $i < count($kikaku_all); $i++){//全件の現在地と企画との距離を算出
    $distance = pow($kikaku_all[$i]->coordinate[0] - $x, 2) + pow($kikaku_all[$i]->coordinate[1] - $y, 2) + pow($kikaku_all[$i]->coordinate[2] - $z, 2);//二乗して距離取得
    $dist_all[$i] = $distance;//連想配列作成
  }

  asort($dist_all);//近い順に配列をソート→JSONの順番入れ替え

  $json_output = '[' . "\n";
  foreach($dist_all as $key => $val){//JSON出力
    $json_output .= json_encode($kikaku_all[$key], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if(!(end($dist_all) == $val)) $json_output .= ",\n";//最後の行にカンマを挿入しない
  }
  $json_output .= "\n" . ']';

  return $json_output;
}


try{
  echo getKikakuNearBy();
} catch(Exception $e){
  echo outputError($e->getCode());
}