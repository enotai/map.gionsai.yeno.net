
<?php
include('./include/define.php');
$title.="検索";
//$description="説明文章";
//$keyword="";
include('./template/top.php');

//http://php.net/manual/ja/faq.html.php#faq.html.javascript-variableより、getに画面幅を渡す
//通常はページを遷移した後に画面サイズが変化することはない
if(isset($_GET['w'])) {
  $screen_width = $_GET['w'];
  //pcにも対応させる場合はbootstrapの仕様を読む必要がある
} else {
  // ジオメトリ変数を渡す
  // (元のクエリ文字列を保持する
  //   -- POST 変数は別の方法で扱う必要がある)

  echo "<script language='javascript'>\n";
  echo "  location.href=\"${_SERVER['SCRIPT_NAME']}?${_SERVER['QUERY_STRING']}"
    . "w=\" + window.innerWidth;\n";
  echo "</script>\n";
  exit();
}


$ja_en = json_decode(file_get_contents('./json/ja_en2.json'));
?>

<!-- Begin page content -->

<div class="container">
  <div class="page-header">
    <h1 class="text-center">祗園祭 出店企画検索</h1>
  </div>


  <div class="form-group form-group-lg" style="margin: auto 20px">

    <form action="./search-result" method="get">
      <div class="form-group">
        <label for="word">単語検索</label>
        <input type="text" value="" name="word" id="word" class="form-control" placeholder="Word" />
      </div>
    </form>

    <form action="./search-result" method="get">
      <div class="form-group">
        <label for="place">企画場所</label>
        <select name="place" id="place" class="form-control" onChange="this.form.submit()">
          <option value="" selected>建物名を選択</option>
          <<?php foreach($ja_en->place as $key => $value ){ ?>
            <option value="<?= $value ?>"><?= $key ?></option>
          <?php } ?>
        </select>
      </div>
    </form>

    <form action="./search-result" method="get">

      <div class="form-group">
        <label for="category">企画カテゴリ</label>
        <select name="category" id="category" class="form-control" onChange="this.form.submit()">
          <option value="" selected>カテゴリ検索</option>
          <?php foreach($ja_en->category as $key => $value ){ ?>
            <option value="<?= $value ?>"><?= $key ?></option>
          <?php } ?>
        </select>
      </div>
    </form>

    <!--とべない-->
    <!--<form action="./search-result" method="get">
      <div class="form-group">
        <label for="price">販売価格</label>
          <div class="input-group input-group-double">
            <span class="input-group-addon" id="sizing-addon2" style="font-size:24px">￥</span>
            <input type="text" class="form-control form-control-double" id="min_price" name="min_price" placeholder="この金額から" maxlength="4" size="4" onSubmit="this.form.submit()">
            <input type="text" class="form-control form-control-double" id="max_price" name="max_price" placeholder="この金額まで" maxlength="4" size="4" onSubmit="this.form.submit()">
          </div>
      </div>
    </form>-->
  </div>


  <h3 style="margin: 50px 0 30px" class="text-center">以下のマップから...</h3>
  <div class="container-fluid">
    <!--version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"-->
    <!--    <svg x="0px" y="0px" viewBox="0 0 680.906 592.184" enable-background="new 0 0 680.906 592.184" xml:space="preserve">


<?php /*include('./img/campus-map.svg.txt'); */?>
    </svg>--><!--png形式で٩( 'ω' )و-->
    <?php
    $map_coord = json_decode(file_get_contents('./json/all_map.json'));
    ?>

    <img src="./img/campus-map.png" alt="構内マップ" usemap="#canvas-map"
         border="0" style=""width="100%">
    <map name="canvas-map">

      <?php

      if($screen_width <= 768) $screen_width -= 60;//bootstrapがmobileでは30px左右空白を取る仕様のため
      elseif($screen_width <= 992) $screen_width = 750 - 60;//60を引くのは仕様
      elseif($screen_width <= 1200) $screen_width = 970 - 60;
      else $screen_width = 1170 - 60;

      if($debug) echo $screen_width;
      //昨年のデータから
      for($i = 0; $i < count($map_coord); $i++) {
        $coord = $map_coord[$i]->coords;//整形してもどす
        //画像画面幅初期値 : 1060px
        $coord_array = explode(',', $coord);
        for($j = 0; $j < count($coord_array); $j++) {
          if($j % 2 == 0) {//x軸を対象に右へ
            $coord_array[$j] += (1893 - 1060);//値の微調整が必要
          } else {//y軸を対象に下へ
            $coord_array[$j] -= 5;//値の微調整が必要
          }
          $coord_array[$j] *= $screen_width / 1893;//元の画像幅
        }
        $coord = implode(',', $coord_array);

        $place = $map_coord[$i]->alt;
        $shape = $map_coord[$i]->shape;
        if($shape == 'circle')  continue;
        $href = BASEURL. '/search-result?place=' . $place;
        echo '<area shape="' . $shape . '" coords="' . $coord . '" alt="' . $place . '" href="' . $href . '">';
      }
      ?>
    </map>
  </div>

</div>

<?php include('./template/bottom.php'); ?>