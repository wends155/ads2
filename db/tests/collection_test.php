<?php 
require_once "../general.php";

$models = Order::findByUser(1);
$coll = new Collection($models);
print_r($coll->as_array());
print_r($coll->as_json());

 ?>