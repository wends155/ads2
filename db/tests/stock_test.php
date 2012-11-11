<?php 
require_once '../general.php';

$stocks = Stock::all()->as_array();
print_r($stocks);
echo date(time()) . "\n";
echo Time::unixToDate(time());
?>