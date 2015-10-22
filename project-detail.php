<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 2015/09/24
 * Time: 10:35
 * Description: 指定された企画の詳細を表示
 * Comment: 要UI設計
 */
require_once('./include/define.php');
require_once('./include/form.php');


$get_array = ['proj_type', 'proj_number'];//get対象



if(isset($_GET['project'])) {
  $query = 'type=kikaku&project=' . s($_GET['project']);
} else {
  foreach($get_array as $value){
    $$value = $_GET[$value];
  }

  $query = 'proj_type=' . $proj_type . '&proj_number=' . $proj_number;
}

$kikaku_json = file_get_contents('http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'/../api/project/info?type=kikaku&'.$query);//jsonファイル取得
//複数なった時$param は使えないのでは

$kikaku_result = json_decode($kikaku_json);//配列へデコード




$map_number_arr = json_decode(file_get_contents('./json/project_map.json'));
foreach($map_number_arr->building_map as $key => $value){
  if($kikaku_result[0]->building_name == $key) $map_number = $value;
}
if(!isset($map_number)) $map_number = 'all';


$svg_map_building = json_decode(file_get_contents('./json/project_map.json'));//とりまmap名<->building


$area_x = 680.906;
$area_y = 592.184;
foreach($svg_map_building->building_coordinate as $key => $value){//またforeachをつかった検索です
  if($key == $kikaku_result[0]->building_name){
    $x = $value[0];
    $y = $area_y / $area_x *100 - $value[1];
  }
}

if(!isset($x)){
  $x=0;$y=0;//消す
}

echo $x ."\n". $y;

//もともと0..100で現在地を設定しているのでmapサイズに合わせて位置調整
$x *= 6.80906 - 0.24;//若干ずれているみたいだから調整
$y *= 5.92184;//下に下げる

//$x = 0;
//$y = 0;

//$cx1=8.539; $cy1=10.036; $r1=7.087;//初期設定
//$x11=1.859; $y11=12.39; $x21=8.674; $y21=31.485;
//$x12=15.043; $y12=12.852; $x22=8.674; $y22=31.485;
//$cx2=8.539; $cy2=10.036; $r2=2.126;


/*$cx1=8.539+$x; $cy1=10.036+$y; $r1=7.087;
$x11=1.859+$x; $y11=12.39+$y; $x21=8.674+$x; $y21=31.485+$y;
$x12=15.043+$x; $y12=12.852+$y; $x22=8.674+$x; $y22=31.485+$y;
$cx2=8.539+$x; $cy2=10.036+$y; $r2=2.126;*/


$svg_coords = 'x1="14.1732" y1="27.2169" x2="14.1732" y2="1.1295"';

$x1 = 14.1732 + $x;
$y1 = 27.2169 + $y;
$x2 = 14.1732 + $x;
$y2 = 1.1295 + $y;

$xm1 = 22.474 + $x;
$ym1 = 7.954 + $y;
$xm2 = 14.173 + $x;
$ym2 = 14.139 + $y;
$xc = 18.468 + $x;
$yc = 12.217 + $y;
$xs = 24.216 + $x;
$ys = 15.518 + $y;

$xz1 = 22.474 + $x;
$yz1 = 7.954 + $y;
$xz21 = 16.545 + $x;
$yz21 = 14.139 + $y;
$xz22 = 14.173 + $x;
$yz22 = 14.139 + $y;

$title.="Index";
//$description="説明文章";
//$keyword="";
include('./template/top.php');
?>
<div class="container">
  <div class="col-sm-offset-1 col-sm-10">
  <?php

  echo '<!--' ;
  echo var_dump($kikaku_result) . '-->';//2段表示

  if(isset($kikaku_result->errors)){//エラー存在時
    echo '
      <h3>エラーが発生しました</h3>
      <p>エラーコード: ' . $kikaku_result->errors->code . '<br>
        エラーメッセージ: ' . $kikaku_result->errors->message . '</p>
      </div>
    </div>
    ';
    include('./template/bottom.php');
    exit;//強制終了
  }

    /*===============================================================*/

    //svgで表現してもいいかも

    ?>
      <div class="col-md-12" style="padding-bottom: 30px">
        <h2>
         <?= $kikaku_result[0]->project_name ?><br>
          <span style="font-size:80%;padding-left:24px">@ <? echo $kikaku_result[0]->building_name; if(isset($kikaku_result[0]->room_name)) echo ' - '. $kikaku_result[0]->room_name ?></span>
        </h2>
        <h3>Organization :<?= $kikaku_result[0]->group_name ?></h3>





        <div class="thumbnail">
          <img src="<?= $kikaku_result[0]->img_address ?>">
          <div class="caption">
            <? if($kikaku_result[0]->project_type == 'E') :?>
              <p><span class="label label-info"><?= $kikaku_result[0]->category->sub ?></span></p>
              <div class="alert alert-success" role="alert">
                <?php
                foreach($kikaku_result[0]->item as $food => $price){
                  echo $food .':' . $price .'円<br>';
                }
                ?>
              </div>
            <? endif; ?>
            <p><?= nl2br($kikaku_result[0]->contents) ?></p>
          </div>
        </div>

     </div>

  </div>

  <div class="container-fluid" style="margin-bottom: 30px"><!--全体を囲ってしまう?-->
<!--全画面表示-->
    <svg x="0px" y="0px" viewBox="0 0 680.906 592.184" enable-background="new 0 0 680.906 592.184" xml:space="preserve">

<?php include('./img/campus-map.svg.txt'); ?>

      <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="<?= $x1 ?>" y1="<?= $y1 ?>" x2="<?= $x2 ?>" y2="<?= $y2 ?>">
        <stop  offset="0" style="stop-color:#E0770E"/>
        <stop  offset="0.002" style="stop-color:#E0770E"/>
        <stop  offset="0.3323" style="stop-color:#DF6415"/>
        <stop  offset="0.6646" style="stop-color:#DD5818"/>
        <stop  offset="1" style="stop-color:#DC5419"/>
      </linearGradient>
      <path fill="url(#SVGID_1_)" d="
      M<?= $xm1 ?>,
      <?= $ym1 ?>
      c -0.763 -3.889 -4.188 -6.825 -8.301 -6.825
      c -4.116,
      0 -7.542,
      2.94 -8.303,
      6.833c -1.733,
      7.565,
      8.303,
      19.254,
      8.303,
      19.254
      S<?= $xs ?>,<?= $ys ?>,
      <?= $xz1 ?>,
      <?= $yz1 ?>z

      M<?= $xm2 ?>,
      <?= $ym2 ?>
      c -2.372,
      0 -4.294 -1.923 -4.294 -4.294
      c 0 -2.372,
      1.923 -4.295,
      4.294 -4.295 s4.295,
      1.923,
      4.295,
      4.295
      C<?= $xc ?>,<?= $yc ?>,
      <?= $xz21 ?>,
      <?= $yz21 ?>,
      <?= $xz22 ?>,
      <?= $yz22 ?>
      z
      "/>


      <!--<path fill="url(#SVGID_1_)" d="
      M22.474,
      7.954c-0.763-3.889-4.188-6.825-8.301-6.825c-4.116,
      0-7.542,
      2.94-8.303,
      6.833c-1.733,
      7.565,
      8.303,
      19.254,
      8.303,
      19.254S24.216,
      15.518,
      22.474,
      7.954z M14.173,
      14.139c-2.372,
      0-4.294-1.923-4.294-4.294c0-2.372,
      1.923-4.295,
      4.294-4.295s4.295,
      1.923,
      4.295,
      4.295C18.468,
      12.217,16.545,
      14.139,
      14.173,
      14.139z
      "/>-->
<!--
      <circle fill="#FF0000" stroke="#000000" stroke-miterlimit="10" cx="<?/*= $cx1 */?>" cy="<?/*= $cy1 */?>" r="<?/*= $r1 */?>"/>
      <line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="<?/*= $x11 */?>" y1="<?/*= $y11 */?>" x2="<?/*= $x21 */?>" y2="<?/*= $y21 */?>"/>
      <line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="<?/*= $x12 */?>" y1="<?/*= $y12 */?>" x2="<?/*= $x22 */?>" y2="<?/*= $y22 */?>"/>
      <circle fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="<?/*= $cx2 */?>" cy="<?/*= $cy2 */?>" r="<?/*= $r2 */?>"/>-->
    </svg>
  </div>
</div>
<?php include('./template/bottom.php');?>
