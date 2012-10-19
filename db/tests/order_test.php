<?php 
require "../order.php";

class OrderTest extends PHPUnit_Framework_TestCase{

	public function testInstanceType(){
		$order = new Order();

		$this->assertInstanceOf('Order',$order);


	}

	public function testAttribs(){
		$order = Order::findById(1);

		$this->assertInstanceOf('Order', $order);
		$this->assertEquals(1, $order->id);
		$this->assertInstanceOf('User', $order->user);
		$this->assertNull($order->date);
		$this->assertNull($order->date_paid);
		$this->assertNull($order->date_claimed);
		$this->assertNull($order->due);
	}
}




 ?>