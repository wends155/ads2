<?php 
require_once '../general.php';

//$item = OrderItem::findById(19);
//print_r($item->as_array());
//$item->delete();
$order = Order::findById(2);
print_r($order->as_array());
 ?>