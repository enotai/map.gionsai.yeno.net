<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 2015/10/20
 * Time: 1:15
 */
include('./include/define.php');
$title.="Index";
//$description="説明文章";
//$keyword="";
include('./template/top.php');
?>

  <div class="container">
    <div class="page-header">
      <h1 class="text-center" style="display: inline">祇園祭2015 企画案内<a href="./beginner"><img src="./img/beginner.png" width="50"></a></h1>
    </div>

    <h3>こちらでは<a href="//gionsai.yeno.net">木更津高専祗園祭2015</a>での企画紹介をしています。<br />カテゴリ別や金額別に検索することが可能です。</h3>

    <div class="form-group form-group-lg" style="margin: auto 20px">

      <form action="./search-result" method="get">
        <label for="category"></label>
        <select name="category" id="category" class="form-control" onChange="this.form.submit()">
          <option value="" selected>カテゴリ検索</option>
          <option value="foods">食品</option>
          <option value="experience">体験</option>
          <option value="make">制作</option>
          <option value="introduce">研究室紹介</option>
        </select>
      </form>

      <div style="margin-top: 30px"><!--なにか入れる?--></div>
      <form action="./search-result" method="get">
        <div class="input-group">
          <span class="input-group-addon" id="sizing-addon2" style="font-size:24px">￥</span>
          <input type="text" class="form-control" id="max_price" name="max_price" placeholder="この金額以下から検索" maxlength="4" size="4">
        </div>
      </form>

    </div>
    </div>
<?php include('./template/bottom.php'); ?>