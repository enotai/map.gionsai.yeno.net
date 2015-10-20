<?php
include('template/define.php');
$title.='エンドポイント :: 企画';
$description.='/project の仕様';
include('template/top.php');
?>
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1>project - 企画についての情報や、関連される企画を表示します。</h1>

        <h2>エンドポイント</h2>

        <h3>GET : <code>/project/info</code></h3>
        <div class="param-table">
          <table class="table table-responsive">
            <thead>
            <tr>
              <th>type</th>
              <th>パラメータ名</th>
              <th>型</th>
              <th>概要</th>
              <th>使用例</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>kikaku</td>
              <td>proj_type<br />proj_number</td>
              <td>[string]<br />[int]</td>
              <td>パラメータで指定された企画を返します。<br /><code>proj_type</code>が企画種別、<code>proj_number</code>が企画番号になります。</td>
              <td>type=kikaku&proj_type=C&proj_number=13</td>
            </tr>
            <tr>
              <td>kikaku</td>
              <td>project</td>
              <td>[string]</td>
              <td>指定された企画の指定は企画種別と企画番号を<code>-</code>で結合します。</td>
              <td>type=kikaku&project=C-13</td>
            </tr>
            <tr>
              <td>list</td>
              <td>(なし)</td>
              <td></td>
              <td>全企画のJSONリストを返します。</td>
              <td>type=list</td>
            </tr>
            </tbody>
          </table>
        </div>


        <!-- <h3>GET : <code>/project/nearby</code></h3>
        <h4>パラメータで指定された座標に関する企画を近い順からすべて表示します。</h4>
        <h4>パラメータ</h4>
        <ul>
          <li>x : [int]</li>
          <li>y : [int]</li>
          <li>z : [int]</li>
        </ul>
        OR
        <ul>
          <li>coord : [string] -> [x],[y],[z]</li>
        </ul>

        <p>
          ex.<br/>
          <code>?x=3&y=12&z=2</code><br/>
          <code>?coord=3,12,2</code>
        </p> -->

      <h5>note : /project/info では、typeを指定しなければエラーを返します。大文字と小文字は区別をしません。</h5>
      </div>
    </div>
  </div>
</div>
<?php include('template/bottom.php'); ?>


