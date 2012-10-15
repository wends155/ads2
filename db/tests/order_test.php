<?php 
require "../general.php";

$order = new Order();
$order->user = 1;
$order->save();
print_r($order->as_array());
$item = new OrderItem();
$item->product = Product::findById(1);
$item->quantity = 1;
$item->price = 123.3;
$order->addItem($item);
$order->save();

$item = $order->addItem();
$item->product = 2;
$item->quantity=2;
$item->price=100;
$item->save();
print_r($order->as_array());
echo $order->total;
 ?>