<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/10
 * Time: 23:05
 */

include('template/define.php');
$title .= "企画検索サンプル";
//$description="説明文章";
//$keyword="";
include('template/top.php');
?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-12">

        <h1>/project使用例</h1>

        <h2>/project/info</h2>

        <form action="search-result.php" method="get">
          <div class="form-group">
            <div class="radio">
              <label>
                <input type="radio" name="api" id="kikakulist" value="list">
                <code>type = list</code>
              </label>
            </div>

            <div class="radio">
              <label>
                <input type="radio" name="api" id="kikakuDiv" value="div">
                <code>type = kikaku & proj_type, proj_number</code>
              </label>

              <div class="form-inline" style="padding-left: 20px">
                <input type="text" class="form-control" id="proj_type" name="proj_type" placeholder="C" maxlength="1" size="3">&nbsp;-&nbsp;
                <input type="text" class="form-control" id="proj_number" name="proj_number" placeholder="13" maxlength="2" size="3">
              </div>
            </div>

            <div class="radio">
              <label>
                <input type="radio" name="api" id="kikakuUnion" value="union">
                <code>type = kikaku & project</code>
              </label>

              <div class="form-inline" style="padding-left: 20px">
                <input type="text" class="form-control" id="project" name="project" placeholder="C-13" maxlength="4" size="5">
              </div>
            </div>

            <button type="submit" class="btn btn-lg btn-primary">Go</button>
          </div>

        </form>
        <hr />
      </div>


      <!--<div class="col-md-10 col-md-offset-1">
        <h2>/api/project/nearby</h2>

        <form action="test-show.php" method="get">
          <div class="form-group">
            <div class="radio">
              <label>
                <input type="radio" name="api" id="mapXYZ" value="nearby-xyz">
                x, y, z
              </label>
              <div class="form-inline" style="padding-left: 20px">
                <input type="text" class="form-control" id="x" name="x" placeholder="3" maxlength="2" size="2">&nbsp;,&nbsp;
                <input type="text" class="form-control" id="y" name="y" placeholder="12" maxlength="2" size="2">&nbsp;,&nbsp;
                <input type="text" class="form-control" id="z" name="z" placeholder="2" maxlength="2" size="2">
              </div>
            </div>

            <div class="radio">
              <label>
                <input type="radio" name="api" id="mapCoord" value="nearby-coord">
                coord
              </label>
              <div class="form-inline" style="padding-left: 20px">
                <input type="text" class="form-control" id="coord" name="coord" placeholder="3,12,2" maxlength="10" size="10">
              </div>
            </div>

            <button type="submit" class="btn btn-lg btn-primary">Go</button>
          </div>
        </form>
        <hr/>
      </div>-->


    </div>
  </div>
</div>
  <!-- /#page-content-wrapper -->
<?php include('template/bottom.php'); ?>