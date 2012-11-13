<?php 
require_once '../general.php';

$stocks = Stock::all()->as_array();
print_r($stocks);
echo time() . "\n";
echo Time::unixToDate(time()) . "\n";
echo date(DATE_RFC822,(strtotime('thursday next week 10:30am',1352710199))) . "\n";
echo date(DATE_RFC822,(strtotime('next month',1352710199))) . "\n";

?>
