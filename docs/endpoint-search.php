<?php
include('template/define.php');
$title.="エンドポイント :: 検索";
//$description="説明文章";
//$keyword="";
include('template/top.php');
?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1>search - 企画の検索を行います。</h1>

        <h2>エンドポイント</h2>

        <h3>GET : <code>/search</code></h3>
        <div class="param-table">
          <table class="table table-responsive">
            <thead>
            <tr>
              <th>パラメータ名</th>
              <th>型</th>
              <th>概要</th>
              <th>使用例</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>word</td>
              <td>[string]</td>
              <td>企画名・内容から指定されたwordを検索し、該当するものがある企画を返します。<br />"+"で検索文字列を結合することにより複数条件での検索が可能です</td>
              <td>word=高専+製作</td>
            </tr>
            <tr>
              <td>category</td>
              <td>[string]</td>
              <td>指定されたカテゴリの企画を返します。カテゴリの種類は以下の通りとなります。</td>
              <td>category=experience</td>
            </tr>
            <tr>
              <td>group</td>
              <td>[string]</td>
              <td>指定されたグループ種別の企画を返します。カテゴリのグループ種別は以下の通りとなります。ja_en.json</td>
              <td>group=circle</td>
            </tr>
            <tr>
              <td>price</td>
              <td>[string]</td>
              <td>指定された価格の範囲内にある企画を返します。価格の範囲指定は最小値と最大値を<code>-</code>で結合します。</td>
              <td>price=100-300</td>
            </tr>
            <tr>
              <td>min_price<br />max_price</td>
              <td>[int]</td>
              <td>指定された価格の範囲内にある企画を返します。上記の<code>price</code>と返り値は同じとなります。</td>
              <td>min_price=100&max_price=300</td>
            </tr>
            </tbody>
          </table>
        </div>

        <h3>パラメータ変換</h3>
        <p>以下の通りに、パラメータを指定します。
          <code class="language-javascript"><?php include ('../json/ja_en.json') ?></code>

        </p>
        <h5>note : 複数のパラメータは指定できません。並び順は企画番号となります。</h5>
      </div>
    </div>
  </div>
</div>
<!-- /#page-content-wrapper -->
<?php include('template/bottom.php'); ?>


