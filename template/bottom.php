<?php
$end = microtime();
$load_time = ($end - $start) * 1000;
if($debug) echo '<p>読み込み時間 : ' . $load_time . 'ms</p>';
?>

<?php
include(dirname(__FILE__) . '/../template/jslist.php');
include(dirname(__FILE__) . '/../template/footer.php');
?>

</body>
</html>