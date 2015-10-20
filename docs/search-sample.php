<?php
include('template/define.php');
$title.='企画検索サンプル';
$description.='APIの使用例';
include('template/top.php');
?>
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-10">
        <h1>各種検索</h1>

        <h2>企画検索 - Word</h2>

        <form action="search-result.php" method="get">
          <div class="form-group">
            <label for="word">検索Word</label>
            <input type="text" value="" name="word" id="word" class="form-control" placeholder="Word" />
            <br />
            <button type="submit" class="btn btn-lg btn-primary">Word検索</button>
          </div>
        </form>
        <hr />

        <h2>企画検索 - 場所</h2>

        <form action="search-result.php" method="get">
          <div class="form-group">
            <label for="place">企画場所</label>
            <select name="place" id="place" class="form-control">
              <option value="synthesis">総合教育棟</option>
              <option value="general">一般研究棟</option>
              <option value="first">第一研究棟</option>
              <option value="second">第二研究棟</option>
              <option value="third">第三研究棟</option>
            </select>
            <br />
            <button type="submit" class="btn btn-lg btn-primary">場所検索</button>
          </div>
        </form>
        <hr />

        <h2>企画検索 - カテゴリ</h2>

        <div class="col-md-6">
          <form action="search-result.php" method="get">
            <div class="form-group">
              <label for="category">カテゴリ - ジャンル</label>
              <select name="category" id="category" class="form-control">
                <option value="foods">食品</option>
                <option value="experience">体験</option>
                <option value="make">制作</option>
                <option value="introduce">研究室紹介</option>
              </select>
              <br />
              <button type="submit" class="btn btn-lg btn-primary">カテゴリ検索</button>
            </div>
          </form>
        </div>

        <div class="col-md-6">
          <form action="search-result.php" method="get">
            <div class="form-group">
              <label for="group">カテゴリ - 企画団体</label>
              <select name="group" id="group" class="form-control">
                <option value="club">部活動</option>
                <option value="circle">同好会</option>
                <option value="lab">研究室</option>
                <option value="class">クラス</option>
                <option value="volunteer">有志</option>
              </select>
              <br />
              <button type="submit" class="btn btn-lg btn-primary">カテゴリ検索</button>
            </div>
          </form>
        </div>
        <hr />

        <h2>企画検索 - 価格</h2>

        <form action="./search-result.php" method="get">
          <div class="form-inline">
            <div class="input-group">
              <div class="input-group-addon">¥</div>
              <input type="number" value="" placeholder="最小値" name="min_price" id="min_price" class="form-control" />
            </div>
            〜
            <div class="input-group">
              <div class="input-group-addon">¥</div>
              <input type="number" value="" placeholder="最大値" name="max_price" id="max_price" class="form-control" />
            </div>
          </div>
          <br />
          <button type="submit" class="btn btn-lg btn-primary">価格検索</button>

        </form>
      </div>
    </div>
  </div>
</div>
<?php include('template/bottom.php'); ?>