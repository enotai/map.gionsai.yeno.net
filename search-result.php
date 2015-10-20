<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 2015/09/24
 * Time: 10:35
 * Comment: カネの処理は後でやります。
 *          複数の条件が来た場合は、再帰呼び出しみたいなもので、がんばります。
 */
//http_refererを追加する?
$start = microtime();
$debug=1;
require_once('./include/define.php');
require_once('./include/form.php');

$page_max = 10;//1ページの最大件数

/*~~~~~~~~~~~~~~~~~~~ここから~~~~~~~~~~~~~~~~~~~~~~~~~~*/
$param_type = ['word', 'place', 'category', 'group', 'food', 'min_price', 'max_price'];//受け渡しされる可能性のあるtype

for($i = 0; $i < count($_GET); $i++) {
  if(isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $param[$i] = s($_GET['min_price']) . '-' . s($_GET['max_price']);
    $type = 'price';//下で使用してる
  }

    $param_count = 0;
    foreach($param_type as $value) {
      if(isset($_GET[$value])) {
        $type = $value;
        $param = s($_GET[$value]);
        $param_count++;
      }
    }


    if($param_count === 0) header("Location: " . $_SERVER['HTTP_REFERER']);//空文字列がパラメータとして送られてきたら元のページに戻す / onchange対策
    if($param_count !== 1) {
      echo 'ひとつにしてくれ';
      var_dump($type);
    }
  }
  /*$typeurl = $type;
  if($type == 'category' || $type == 'group') $typeurl = 'category';//クラス化で統合するとこんな処理はいらない//api/searchに置き換えたので不要*/
  /*~~~~~~~~~~~~~~~~~~~ここまで~~~~~~~$typeが帰ってくる~~~~~~~~~~~~~*/

  $api_url = str_replace(' ', '+', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '/../api/search?' . $type . '=' . $param);//file_get_contents用にスペースを変換
}
$kikaku_json = file_get_contents($api_url);//jsonファイル取得

$kikaku_result = json_decode($kikaku_json);//配列へデコード

/*========================検索処理===============================*/
/**
 * 検索対象: 企画名, 内容, 団体名
 * 複数の条件検索などに対応させる:結果が合わない
 * ↑もしかして、キーワード２つ目以降が遅れていない←検索文字列の結合が+か か
 */

$title.="Index";
//$description="説明文章";
//$keyword="";
include('./template/top.php');
?>
<div class="container">
  <div class="col-md-offset-1 col-md-10">
    <?php

    echo '<p>APIurl : '.$api_url.'</p>';
    if($debug) {
      echo '<p>APIurl : '.$api_url.'</p>';
      echo '<!--' ;
      echo var_dump($kikaku_result) . '-->';//apiの答えと異なる
    }


    if(isset($kikaku_result->errors)){//エラー存在時
      echo '
      <h3>エラーが発生しました</h3>
      <p>エラーコード: ' . $kikaku_result->errors->code . '<br>
        エラーメッセージ: ' . $kikaku_result->errors->message . '</p>
      </div></div>
    ';
    include('./template/bottom.php');
      //echo $a;
      exit(0);//強制終了
    }

    if($type == ''){//効いていない
      echo '<p>検索キーワードが指定されていません</p><p><a href="index.php">トップへ戻る</a></p></div></div></body></html>';
      exit(0);
    }
    else{

      /*===============================================================*/

      echo '<h2>検索結果</h2>';



      for($i = 0; $i < count($kikaku_result); $i++){//自身は飛ばす
  ?>
          <h3>
            <a href="./project-detail.php?proj_type=<?= $kikaku_result[$i]->project_type ?>&proj_number=<?= $kikaku_result[$i]->project_number ?>"><?= $kikaku_result[$i]->project_name ?><br>
            <span style="font-size:80%">@ <? echo $kikaku_result[$i]->building_name; if(isset($kikaku_result[$i]->room_name)) echo ' - '. $kikaku_result[$i]->room_name ?></span></a>
          </h3>
          <h4 style="margin-left: 20px">Organization : <?= $kikaku_result[$i]->group_name ?></h4>


        <div class="thumbnail">
          <div class="caption">
            <? if($kikaku_result[$i]->project_type == 'D' || $kikaku_result[$i]->project_type == 'E') :?>
              <p><span class="label label-info"><? if(isset($kikaku_result[$i]->category->sub)) echo $kikaku_result[$i]->category->sub ?></span></p>
              <div class="alert alert-success" role="alert">
                <?php
                foreach($kikaku_result[$i]->item as $food => $price){
                  echo $food .':' . $price .'円<br>';
                }
                ?>
              </div>
            <? endif; ?>
            <p><?= nl2br($kikaku_result[$i]->contents) ?></p>
          </div>
        </div>

 <?php
        if(!($i == count($kikaku_result)-1)) echo '<hr><hr>';
      }
    }
?>
    <div style="padding-bottom: 30px"></div>
  </div>
</div>
<?php include('./template/bottom.php'); ?>