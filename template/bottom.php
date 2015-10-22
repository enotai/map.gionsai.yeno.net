<?php
$end = microtime();
$load_time = ($end - $start) * 1000;
if($debug) echo '<p>読み込み時間 : ' . $load_time . 'ms</p>';
?>

<?php
include(dirname(__FILE__) . '/../template/jslist.php');
include(dirname(__FILE__) . '/../template/footer.php');
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54992414-3', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>