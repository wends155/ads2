<?php
require_once "../general.php";

$t = Time::dateToUnix('12/07/1986');
echo $t . "\n";
echo Time::unixToDate(1350988194976/1000);

?>
