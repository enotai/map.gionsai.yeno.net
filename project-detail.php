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

foreach($get_array as $value){
  $$value = $_GET[$value];
}

$query = 'type=kikaku&proj_type=' . $proj_type . '&proj_number=' . $proj_number;

$kikaku_json = file_get_contents('http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'/../api/project/info?type=kikaku&'.$query);//jsonファイル取得
//複数なった時$param は使えないのでは

$kikaku_result = json_decode($kikaku_json);//配列へデコード




$map_number_arr = json_decode(file_get_contents('./json/project_map.json'));
foreach($map_number_arr->building_map as $key => $value){
  if($kikaku_result[0]->building_name == $key) $map_number = $value;
}
if(!isset($map_number)) $map_number = 'all';

/*========================企画イラストアドレス===============================*///apiにもっていかないか?
$img_dir = scandir('./img/project/'.strtoupper($proj_type));
for($i = 2; $i<count($img_dir); $i++) {//上位ディレクトリへのリンクはパス

  //番号の先頭に0がつくものがあるから分割処理
  $img_dir_format[$i] = explode('.', $img_dir[$i]);
  $img_dir_format[$i] = explode('-', $img_dir_format[$i][0]);
  if($img_dir_format[$i][1] == $proj_number) $img_dir_addr = $i;//緩やかな比較
}

$img_addr = isset($img_dir_addr) ? './img/project/'.strtoupper($proj_type).'/'.$img_dir[$img_dir_addr] : './img/project/noimg.png';

//現在地処理


$svg_map_building = json_decode(file_get_contents('./json/project_map.json'));//とりまmap名<->building

foreach($svg_map_building->building_coordinate as $key => $value){//またforeachをつかった検索です
  if($key == $kikaku_result[0]->building_name){
    $x = $value[0];
    $y = $value[1];
  }
}

if(!isset($x)){
  $x=0;$y=0;//消す
}

//もともと0..100で現在地を設定しているのでmapサイズに合わせて位置調整
$x *= 6.80906;
$y *= 6.80906*6.80906/5.92184; $y = 592.184 - $y;//y軸の計算が狂っているから調整する

//$cx1=8.539; $cy1=10.036; $r1=7.087;//初期設定
//$x11=1.859; $y11=12.39; $x21=8.674; $y21=31.485;
//$x12=15.043; $y12=12.852; $x22=8.674; $y22=31.485;
//$cx2=8.539; $cy2=10.036; $r2=2.126;

//$x=500; $y=300;//現在地座標

$cx1=8.539+$x; $cy1=10.036+$y; $r1=7.087;//初期設定
$x11=1.859+$x; $y11=12.39+$y; $x21=8.674+$x; $y21=31.485+$y;
$x12=15.043+$x; $y12=12.852+$y; $x22=8.674+$x; $y22=31.485+$y;
$cx2=8.539+$x; $cy2=10.036+$y; $r2=2.126;


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
          <img src="<?= $img_addr ?>" alt="hoge">
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

  <div class="container-fluid" style="zmargin-bottom: 30px"><!--全体を囲ってしまう?-->
<!--全画面表示-->
    <svg x="0px" y="0px" viewBox="0 0 680.906 592.184" enable-background="new 0 0 680.906 592.184" xml:space="preserve">

<?php include('./img/campus-map.svg.txt'); ?>

      <circle fill="#FF0000" stroke="#000000" stroke-miterlimit="10" cx="<?= $cx1 ?>" cy="<?= $cy1 ?>" r="<?= $r1 ?>"/>
      <line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="<?= $x11 ?>" y1="<?= $y11 ?>" x2="<?= $x21 ?>" y2="<?= $y21 ?>"/>
      <line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="<?= $x12 ?>" y1="<?= $y12 ?>" x2="<?= $x22 ?>" y2="<?= $y22 ?>"/>
      <circle fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="<?= $cx2 ?>" cy="<?= $cy2 ?>" r="<?= $r2 ?>"/>
    </svg>
  </div>
</div>
<?php include('./template/bottom.php');?>
