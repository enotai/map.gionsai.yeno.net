<?php
$end = microtime();
$loadtime = ($end - $start) * 1000;
if($debug == true) echo '<p>読み込み時間 : ' . $loadtime . 'ms</p>';
?>

<?php
include('./template/jslist.php'); echo PHP_EOL;
include('./template/footer.php'); echo PHP_EOL;
?>

</body>
</html>