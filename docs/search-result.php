<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/11
 * Time: 0:41
 */
require_once('../include/define.php');
require_once('../include/form.php');

include('template/define.php');//かぶってる
$title.='企画検索結果';
$description.='API使用例';

if(isset($_GET['api'])) {// /search-result.phpが完成したらそちらを試用
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
  $api_url = (BASEURL . '/api/project/info?' . $query);
} else if(isset($_GET['min_price']) && isset($_GET['max_price'])) {//searchになげる
  $api_url = BASEURL . '/api/search?min_price=' . s($_GET['min_price']) . '&max_price=' . s($_GET['max_price']);//冗長

  $type = 'price';//下で使用してる
} else {
  $get_array = array();
  foreach($_GET as $key => $param) {
    $key = s($key);
    $param = s($param);
    $get_array += [$key];
  }
  if(count($get_array) === 1) $type = $get_array[0];
  else echo 'ひとつにしてくれ';
  $api_url = str_replace(' ', '+', BASEURL . '/api/search?' . $type . '=' . $param);//file_get_contents用にスペースを変換
}
$kikaku_json = file_get_contents($api_url);//jsonファイル取得

$kikaku_result = json_decode($kikaku_json);//配列へデコード

/*========================検索処理===============================*/
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


        $end = microtime();
        $load_time = ($end - $start) * 1000;
        ?>

        <?php if($debug) echo '<p>読み込み時間 : ' . $load_time . 'ms</p>'; ?>
      </div>
    </div>
  </div>
</div>
<?php include('template/bottom.php'); ?>