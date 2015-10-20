
<?php
include('./include/define.php');
$title.="検索";
//$description="説明文章";
//$keyword="";
include('./template/top.php');
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
          <option value="synthesis">総合教育棟</option>
          <option value="general">一般研究棟</option>
          <option value="first">第一研究棟</option>
          <option value="second">第二研究棟</option>
          <option value="third">第三研究棟</option>
        </select>
      </div>
    </form>

    <form action="./search-result" method="get">

      <div class="form-group">
        <label for="category">企画カテゴリ</label>
        <select name="category" id="category" class="form-control" onChange="this.form.submit()">
          <option value="" selected>カテゴリ検索</option>
          <option value="foods">食品</option>
          <option value="experience">体験</option>
          <option value="make">制作</option>
          <option value="introduce">研究室紹介</option>
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



  <h2 style="margin: 50px 0 30px" class="text-center">MAP検索</h2><!--クリックすると何か-->
  <object type="image/svg+xml" data="./img/campus-map.svg" width="100%" class="center-block" style="margin: 0"></object>
</div>

<?php include('./template/bottom.php'); ?>