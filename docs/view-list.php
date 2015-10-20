<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/10
 * Time: 23:32
 */

include('template/define.php');//かぶってる
$title .= "企画検索サンプル";
//$description="説明文章";
//$keyword="";

$start = microtime();

require_once('../include/define.php');
require_once('../include/form.php');

$kikaku_json = file_get_contents(BASEURL . '/api/project/info?type=list');//jsonファイル取得

$kikaku_list = json_decode($kikaku_json);//配列へデコード
include('template/top.php');
?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">

        <h1>企画一覧</h1>

        <ul style="text-decoration: none">
          <li><a href="#A">A企画 : 専門</a></li>
          <li><a href="#B">B企画 : 低学年</a></li>
          <li><a href="#C">C企画 : 一般</a></li>
          <li><a href="#D">D企画 : 一般販売</a></li>
          <li><a href="#E">E企画 : 食品販売</a></li>
        </ul>
        <?php
        echo '
  <table class="table table-striped table-bordered table-hover col-lg-10">
  <tbody>
  ';


        for($i = 0; $i < count($kikaku_list); $i++) {
          if($i % 10 == 0) {
            echo '<tr>' . "\n";

            foreach($kikaku_list[0] as $key => $value) {//表示
              if($key == 'coordinate' || $key == 'item' || $key == 'contents' || $key == 'comment' || $key == 'img_address' ) continue;
              echo '<th>' . $key . '</th>' . "\n";
            }
            echo '</tr>' . "\n";
          }

          if($kikaku_list[$i]->project_number == 1) echo '<tr id="' . $kikaku_list[$i]->project_type . '">' . "\n";
          else echo '<tr>' . "\n";

          foreach($kikaku_list[$i] as $key => $value) {//表示
            if($key == 'coordinate' || $key == 'item' || $key == 'contents' || $key == 'comment' || $key == 'img_address' ) continue;
            if(isset($kikaku_list[$i]->category->main) && $key == 'category') echo '<td>' . $value->main . ' / ' . $value->sub . '</td>' . "\n";
            else echo '<td>' . $value . '</td>' . "\n";
          }
          echo '</tr>' . "\n";

          foreach($kikaku_list[$i] as $key => $value) {//表示

            if($key == 'contents') {
              echo '<tr><td colspan="10"><div class="row"><div class="col-lg-8">';
              echo '<strong>Image Address : </strong><textarea rows="1" cols="80">' . $kikaku_list[$i]->img_address . "</textarea><br />\n";
              echo '<strong>Comment : </strong>' . nl2br($value) . "<br />\n";//nl2br : 改行→br

              if(!is_null($kikaku_list[$i]->item)) {
                echo '<ul>';
                foreach($kikaku_list[$i]->item as $item => $price) {
                  echo '<li>' . $item . ' : ' . $price . '円</li>';
                }
                echo '</ul>';
              }
              echo '</div><div class="col-lg-4">';
              echo '<img width="300" src="' . $kikaku_list[$i]->img_address . '">';
              echo '</div></div></td></tr>' . "\n";
            }
          }
        }
        echo '
  </tbody>
  </table>';

        $end = microtime();
        $loadtime = ($end - $start) * 1000;
        ?>
      </div>
    </div>
  </div>
</div>


<? if($debug == true) echo '<p>読み込み時間 : ' . $loadtime . 'ms</p>'; ?>
  <!-- /#page-content-wrapper -->
<?php include('template/bottom.php'); ?>