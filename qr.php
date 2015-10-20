
<?php
include('./include/define.php');
$title.="Location";
//$description="説明文章";
//$keyword="";
include('./template/top.php');
?>

<!-- Begin page content -->
<div class="container">
  <div class="page-header">
    <h1 class="text-center">祇園祭 現在地案内</h1>
  </div>
  <div class="page-header">
    <h2 class="text-center">QRコードリーダを起動!!</h2>
  </div>


  <div class="container-fluid">
    <!--version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"-->
    <svg x="0px" y="0px" viewBox="0 0 680.906 592.184" enable-background="new 0 0 680.906 592.184" xml:space="preserve">


<?php include('./img/campus-map.svg.txt'); ?>

      <?php
      $cx1=8.539; $cy1=10.036; $r1=7.087;//初期設定
      $x11=1.859; $y11=12.39; $x21=8.674; $y21=31.485;
      $x12=15.043; $y12=12.852; $x22=8.674; $y22=31.485;
      $cx2=8.539; $cy2=10.036; $r2=2.126;



      $x=550; $y=400;//現在地座標

      $cx1+=$x; $cy1+=$y; $r1=7.087;//初期設定
      $x11+=$x; $y11+=$y; $x21+=$x; $y21+=$y;
      $x12+=$x; $y12+=$y; $x22+=$x; $y22+=$y;
      $cx2+=$x; $cy2+=$y; $r2=2.126;

      ?>

      <circle fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" cx="<?= $cx1 ?>" cy="<?= $cy1 ?>" r="<?= $r1 ?>"/>
      <line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="<?= $x11 ?>" y1="<?= $y11 ?>" x2="<?= $x21 ?>" y2="<?= $y21 ?>"/>
      <line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="<?= $x12 ?>" y1="<?= $y12 ?>" x2="<?= $x22 ?>" y2="<?= $y22 ?>"/>
      <circle fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="<?= $cx2 ?>" cy="<?= $cy2 ?>" r="<?= $r2 ?>"/>
    </svg>
  </div>
</div>

<?php include('./template/bottom.php'); ?>