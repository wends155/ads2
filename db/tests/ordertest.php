<?php
require '../order.php';


#$data = json_decode('{"id":"11","date":"1352334438.11","downpayment":null,"date_paid":null,"date_claimed":1352334820332,"due":null,"items":[{"id":"23","order_id":"11","price":"300.0","quantity":"1","product":{"id":"4","name":"Graphic M"},"subtotal":300},{"id":"24","order_id":"11","price":"97.5","quantity":"1","product":{"id":"2","name":"Avon Naturals Hair Care"},"subtotal":97.5}],"user":{"id":"1","fullname":"Saligan, Wendell Philip B."},"total":397.5}');
#$data->user_id = 1;
#$order = Order::findById(11);
#$order->save();
#$order->update($data);
#print_r($order->as_array());
#print_r($data);
#$order = Order::findById(6);
#$order->due = $order->date_claimed;
#$order->save();
#print_r($order->as_array());

function change_claim($id){
	$order = Order::findById($id);
	#echo $order->date;
	$days = 3600*24*5;
	$due = 3600*24*30;
	$claim = $order->date;
	#echo $claim;
	$order->date_claimed = $claim + $days;
	echo $order->date_claimed;
	$order->due = $order->date_claimed + $due;
	$order->save();
}
$ids = array(51,52,53,54,55,56,57,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74);
foreach($ids as $i){
	change_claim($i);
}
?>
