<?php global $options;
	foreach ($options as $value) {
		if ((isset($value['id'])) && (isset($value['std']))) {
			if (FALSE === get_option( $value['id'])) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
		}
	}
?>



<style type="text/css">
  footer h3{
    color: #fff;
  }
  footer h4 {
    color: #bbb;
    font-size: 120%
  }
</style>

<footer id="footer" name="footer">
<!-- <div class="container-field" style="height:600px;z-index=3">
<div class="googlemap">
<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7736.632891435019!2d139.95594587966275!3d35.384091014840166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x0ebd70597093191d!2z5pyo5pu05rSl5bel5qWt6auY562J5bCC6ZaA5a2m5qCh!5e0!3m2!1sja!2sjp!4v1436455565362" width="800" height="600" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
</div>
</div> -->
  <div class="container" style="z-index:500">
    <div class="row">

      <div class="span3">
        <ul>
          <h3>
            <li style="margin-bottom: 20px;">TOP</a></li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#top">トップ</a></li>
            </h4>
          </ul>
          <h3>
            <li style="margin-bottom: 20px;margin-top: 20px;">ABOUT</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#about">祇園祭概要</a></li>
            </h4>
          </ul>
          <h3>
            <li style="margin-bottom: 20px;margin-top: 20px;">THEME</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#theme">祇園祭テーマ</a></li>
            </h4>
          </ul>
          <h3>
            <li style="margin-bottom: 20px;margin-top: 20px;">GREETING</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#greeting">挨拶</a></li>
            </h4>
          </ul>
        </ul>
      </div>

      <div class="span3">
        <ul>
          <h3>
            <li style="margin-bottom: 20px;">MAP</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#address">住所</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#map">地図</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="#access">アクセス</a></li>
            </h4>
          </ul>
          <h3>
            <li style="margin-bottom: 20px;margin-top: 20px;">PAST</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;">
                <a href="http://gionsai.yeno.net/2012/">2012年 ホームページ</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;">
                <a href="http://gionsai.yeno.net/2013/">2013年 ホームページ</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;">
                <a href="http://gionsai.yeno.net/2014/">2014年 ホームページ</a></li>
            </h4>
          </ul>
        </ul>
      </div>

      <div class="span3"><!--Map-->
        <ul><!--
          <h3>
            <li style="margin-bottom: 20px;">企画案内</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="http://map.gionsai.yeno.net">企画案内Top</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="http://map.gionsai.yeno.net/buy">食品案内</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="http://map.gionsai.yeno.net/time-schedule">タイムスケジュール</a></li>
            </h4>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="http://map.gionsai.yeno.net/search">企画検索</a></li>
            </h4>
          </ul>-->

          <h3>
            <li style="margin-bottom: 20px;">連絡先</li>
          </h3>
          <ul>
            <h4>
              <li style="list-style: circle;margin-bottom: 15px;margin-top: 15px;"><a href="mailto://knct.gion[at]gmail.com">knct.gion[at]gmail.com</a></li>
            </h4>
        </ul>
      </div>

<div class="span3">
            <a class="twitter-timeline"  href="https://twitter.com/gion_festival" data-widget-id="499285150048350208">@gion_festivalさんのツイート</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>

</div>
		<?php echo stripslashes($fw_footer_text) ?>
	</div>
</footer>
<?php echo stripslashes($fw_ga_code) ?>