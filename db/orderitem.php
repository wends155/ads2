<?php
require_once "general.php";

class OrderItem extends Model{
	public static $_table = 'order_items';
	protected static $class =  'OrderItem';

	public function getId(){
		return $this->_orm->id;
	}

	public function getOrder(){
		return Order::findById($this->_orm->order_id);
	}

	public function getProduct(){
		return Product::findById($this->_orm->product_id);
	}

	public function getPname(){
		$product = $this->product;
		return $product->name;
	}

	public function getPrice(){
		return $this->_orm->price;
	}

	public function getQuantity(){
		return $this->_orm->quantity;
	}

	public function getSubtotal(){
		$subtotal = (float)$this->price * (float)$this->quantity;
		return $subtotal;
	}

//SETTERS	
	public function setOrder($value){
		if($value instanceof Order){
			$this->_orm->order_id = $value->id;
			return true;
		}
		$order = Order::findById($value);
		if($order){
			$this->_orm->order_id = $value;
			return true;
		}
		throw new Exception("Order does not exist");

	}

	public function setProduct($value){
		if($value instanceof Product){
			$this->_orm->product_id = $value->id;
			return true;
		}
		$product = Product::findById($value);
		if($product){
			$this->_orm->product_id = $product->id;
		}
		throw new Exception("Product does not exist");
		
	}

	public function setPrice($value){
		$this->_orm->price = $value;
	}

	public function setQuantity($value){
		$this->_orm->quantity = $value;
	}


	public static function findByOrder($order_id){
		$orders = ORM::for_table(static::$_table)->where('order_id', $order_id)->find_many();
		
		if($orders){
			$models = array();
			foreach ($orders as $order) {
				# code...
				$models[] = new OrderItem($order);
			}
			return $models;
		}
		return false;
	}

}

?>
