<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 2015/10/05
 * Time: 0:33
 * Description: 食品を表示 Ajax?
 */
include('./include/define.php');
$title.="買い物";
//$description="説明文章";
//$keyword="";
include('./template/top.php');

$ja_en = json_decode(file_get_contents('./json/ja_en2.json'));

?>

  <!-- Begin page content -->

  <div class="container">
    <div class="page-header">
      <h1 class="text-center">祗園祭 食品検索</h1>
    </div>


    <div class="form-group form-group-lg" style="margin: auto 20px">

      <form action="./search-result" method="get">
        <div class="form-group">
          <label for="price">販売価格</label>
          <div class="input-group input-group-double">
            <span class="input-group-addon" id="sizing-addon2" style="font-size:24px">￥</span>
            <input type="text" class="form-control form-control-double" id="min_price" name="min_price" placeholder="この金額から" maxlength="4" size="4" onSubmit="this.form.submit()">
            <input type="text" class="form-control form-control-double" id="max_price" name="max_price" placeholder="この金額まで" maxlength="4" size="4" onSubmit="this.form.submit()">
          </div>
        </div>

        <div class="form-group">
          <label for="foods">食品カテゴリ</label>
          <select name="food" id="food" class="form-control">
            <option value="all" selected>すべて</option>

            <?php foreach($ja_en->food as $key => $value ){ ?>
            <option value="<?= $value ?>"><?= $key ?></option>
            <?php } ?>
          </select>
        </div>

        <input type="submit" value="検索" class="btn btn-primary btn-lg center-block"/>
      </form>
    </div>

  </div>

<?php include('./template/bottom.php'); ?>