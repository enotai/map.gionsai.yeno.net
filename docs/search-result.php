<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/11
 * Time: 0:41
 */
require_once('../include/define.php');

include('template/define.php');//かぶってる
$title .= "企画検索結果";
//$description="説明文章";
//$keyword="";

$start = microtime();

require_once('../include/form.php');

$page_max = 10;//1ページの最大件数


/*$debug = s($_GET['debug']);//デバッグモード中止
if($debug) echo $debug;*/

if(isset($_GET['api'])) {
  switch(s($_GET['api'])){
    case 'list' :
      $query = 'type=list';
      break;

    case 'union' :
      $project = s($_GET['project']);
      $query = 'type=kikaku&project=' . $project;
      break;

    case 'div' :
      $proj_type = s($_GET['proj_type']);
      $proj_number = s($_GET['proj_number']);
      $query = 'type=kikaku&proj_type=' . $proj_type . '&proj_number=' . $proj_number;
      break;

    default :
      $query = '';

  }
  $type = 'project';
  $api_url = (BASEURL . '/api/project/info?' . $query);//jsonファイル取得
}
//センス無いやり方
/*~~~~~~~~~~~~~~~~~~~ここから~~~~~~~~~~~~~~~~~~~~~~~~~~*/
else if(isset($_GET['min_price']) && isset($_GET['max_price'])) {//searchになげる
  $api_url = BASEURL . '/api/search?min_price=' . s($_GET['min_price']) . '&max_price=' . s($_GET['max_price']);//冗長

  $type = 'price';//下で使用してる
} else {
  $get_array = [];
  foreach($_GET as $key => $param) {
    $key = s($key);
    $param = s($param);
    $get_array += [$key];
  }
  if(count($get_array) === 1) $type = $get_array[0];
  else echo 'ひとつにしてくれ';

  /*$typeurl = $type;
  if($type == 'category' || $type == 'group') $typeurl = 'category';//クラス化で統合するとこんな処理はいらない//api/searchに置き換えたので不要*/
  /*~~~~~~~~~~~~~~~~~~~ここまで~~~~~~~$typeが帰ってくる~~~~~~~~~~~~~*/


  $api_url = str_replace(' ', '+', BASEURL . '/api/search?' . $type . '=' . $param);//file_get_contents用にスペースを変換
}
$kikaku_json = file_get_contents($api_url);//jsonファイル取得

//複数なった時$param は使えないのでは


$kikaku_result = json_decode($kikaku_json);//配列へデコード

/*========================検索処理===============================*/
/**
 * 検索対象: 企画名, 内容, 団体名
 * 複数の条件検索などに対応させる:結果が合わない
 * ↑もしかして、キーワード２つ目以降が遅れていない←検索文字列の結合が+か か
 */
include('./template/top.php');
?>

<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <?php

        echo '<p>APIurl : ' . $api_url . '</p>';

        echo '<!--';
        echo var_dump($kikaku_result) . '-->';//apiの答えと異なる

        if(isset($kikaku_result->errors)) {//エラー存在時
          echo '
    <h3>エラーが発生しました</h3>
    <p>エラーコード: ' . $kikaku_result->errors->code . '<br>
      エラーメッセージ: ' . $kikaku_result->errors->message . '</p>
    </div>
  </div>
  </body>
  </html>
    ';
          exit;//強制終了
        }

        if($type == '') {
          echo '<p>検索キーワードが指定されていません</p><p><a href="index.php">トップへ戻る</a></p></div></div></body></html>';
          exit;
        } else {

          /*===============================================================*/

          echo '
   <h2>検索結果</h2>
    <table class="table table-striped table-bordered table-hover">
    <tbody>';


          echo '<tr>';
          foreach($kikaku_result[0] as $key => $value) {//表示
            if($key == 'coordinate' || $key == 'item' || $key == 'comment' || $key == 'contents' || $key == 'img_address') continue;
            echo '<th>' . $key . '</th>' . "\n";
          }
          echo '</tr>';

          for($i = 0; $i < count($kikaku_result); $i++) {//自身は飛ばす
            echo '<tr>';
            foreach($kikaku_result[$i] as $key => $value) {//表示
              if($key == 'coordinate' || $key == 'item' || $key == 'comment' || $key == 'contents' || $key == 'img_address') continue;
              if(isset($kikaku_result[$i]->category->main) && $key == 'category') echo '<td>' . $value->main . ' / ' . $value->sub . '</td>' . "\n";
              else echo '<td>' . $value . '</td>' . "\n";
            }
            echo '</tr>' . "\n";
            foreach($kikaku_result[$i] as $key => $value) {//表示

              if($key == 'contents') {
                echo '<tr><td colspan="10"><div class="row"><div class="col-lg-8">';
                echo '<strong>Image Address : </strong><textarea rows="1" cols="80">' . $kikaku_result[$i]->img_address . "</textarea><br />\n";
                echo '<strong>Comment : </strong>' . nl2br($value) . "<br />\n";//nl2br : 改行→br

                if(!is_null($kikaku_result[$i]->item)) {
                  echo '<ul>';
                  foreach($kikaku_result[$i]->item as $item => $price) {
                    echo '<li>' . $item . ' : ' . $price . '円</li>';
                  }
                  echo '</ul>';
                }
                echo '</div><div class="col-lg-4">';
                echo '<img width="300" src="' . $kikaku_result[$i]->img_address . '">';
                echo '</div></div></td></tr>' . "\n";
              }
            }
          }


          echo '
    </tbody>
    </table>';
        }


        $end = microtime();
        $loadtime = ($end - $start) * 1000;
        ?>

        <? //if($debug == true) echo '<p>読み込み時間 : ' . $loadtime . 'ms</p>'; ?>
        <? echo '<p>読み込み時間 : ' . $loadtime . 'ms</p>'; ?>
      </div>
    </div>
  </div>
</div>


  <!-- /#page-content-wrapper -->
<?php include('template/bottom.php'); ?>