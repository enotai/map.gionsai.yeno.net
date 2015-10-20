<?php
include('./include/define.php');
$title .= "タイムスケジュール";
//$description="説明文章";
//$keyword="";
include('./template/top.php');

?>

<style type="text/css">
  td.project{
    font-weight: bold;
    background-color: #ffffc0;
    text-align: center;
    font-size: 80%;
  }
</style>
<!-- Begin page content -->
<div class="container">
  <div class="page-header">
    <h1 class="text-center">タイムスケジュール</h1>
    <h4 class="text-center">発表系企画のタイムスケジュールです</h4>
  </div>

  <h2>1日目 (10/24)</h2>

  <div class="timeschesule">
    <table class="table">
      <thead>
        <tr>
          <th>時間</th>
          <th>第一体育館</th>
          <th>第二体育館</th>
          <th>ほか</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>10:00~10:30</th>
          <td></td>
          <td></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-01">ピアノ同好会 : ピアノ発表会</a></td>
        </tr>
        <tr>
          <th>10:30~11:00</th>
          <td class="project" rowspan="3"><a href="./project-detail?project=c-15">軽音楽部 : 祇園祭LIVE2015</a></td>
          <td></td>
        </tr>
        <tr>
          <th>11:00~11:30</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>11:30~12:00</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>12:00~12:30</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>12:30~13:00</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>13:00~13:30</th>
          <td class="project" rowspan="6"><a href="./project-detail?project=c-15">軽音楽部 : 祇園祭LIVE2015</a></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-05">ダンス同好会 : Dance showcase 2015</a></td>
          <td></td>
        </tr>
        <tr>
          <th>13:30~14:00</th>
          <td></td>
        </tr>
        <tr>
          <th>14:00~14:30</th>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-08">吹奏楽部 : 吹奏楽部コンサート</a></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-01">ピアノ同好会 : ピアノ発表会</a></td>
        </tr>
        <tr>
          <th>14:30~15:00</th>
        </tr>
        <tr>
          <th>15:00~15:30</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>15:30~16:00</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>16:00~16:40</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>16:40~18:00</th>
          <td class="project" colspan="3">中夜祭 1部<br>パフォーマンスコンテスト</td>
        </tr>
        <tr>
          <th>18:00~19:00</th>
          <td class="project" colspan="3">中夜祭 2部<br>軽音楽部ライブ</td>
        </tr>
      </tbody>
    </table>
  </div>

  <h2>2日目 (10/25)</h2>

  <div class="timeschesule">
    <table class="table">
      <thead>
        <tr>
          <th>時間</th>
          <th>第一体育館</th>
          <th>第二体育館</th>
          <th>ほか</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>10:00~10:30</th>
          <td></td>
          <td></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-01">ピアノ同好会 : ピアノ発表会</a></td>
        </tr>
        <tr>
          <th>10:30~11:00</th>
          <td class="project" rowspan="3"><a href="./project-detail?project=c-15">軽音楽部 : 祇園祭LIVE2015</a></td>
          <td></td>
        </tr>
        <tr>
          <th>11:00~11:30</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>11:30~12:00</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>12:00~12:30</th>
          <td></td>
          <td></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-13">大人のコンサート</a></td>
        </tr>
        <tr>
          <th>12:30~13:00</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>13:00~13:30</th>
          <td class="project" rowspan="6"><a href="./project-detail?project=c-15">軽音楽部 : 祇園祭LIVE2015</a></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-05">ダンス同好会 : Dance showcase 2015</a></td>
          <td></td>
        </tr>
        <tr>
          <th>13:30~14:00</th>
          <td></td>
        </tr>
        <tr>
          <th>14:00~14:30</th>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-08">吹奏楽部 : 吹奏楽部コンサート</a></td>
          <td class="project" rowspan="2"><a href="./project-detail?project=c-01">ピアノ同好会 : ピアノ発表会</a></td>
        </tr>
        <tr>
          <th>14:30~15:00</th>
        </tr>
        <tr>
          <th>15:00~15:30</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>15:30~16:00</th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>16:00~16:40</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>16:40~18:00</th>
          <td class="project" colspan="3">中夜祭 1部<br>パフォーマンスコンテスト</td>
        </tr>
        <tr>
          <th>18:00~19:00</th>
          <td class="project" colspan="3">中夜祭 2部<br>軽音楽部ライブ</td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

<?php include('./template/bottom.php'); ?>