<?php 
require_once '../stock.php';

$stock = Stock::findByProduct(2);
#$stock->quantity = 2;

#print_r($stock->as_array());
$stock->increment(2);
#print_r($stock->as_array());
$stock->decrement(1);
print_r($stock->as_array());



?>