<?php 
echo "im in db \n";
echo __DIR__ . "\n";
$db_path = 'sqlite:'.dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ads.sqlite';
echo $db_path . "\n";
 ?>