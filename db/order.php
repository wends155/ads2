<?php
require_once "general.php";

class Order extends Model{
	public static $_table = 'orders';
	protected static $class =  'Order';

//Getters
	public function getId(){
		return $this->_orm->id;
	}

	public function getUser(){
		$user = User::findById($this->_orm->user_id);
		return $user;
	}

	public function getDownpayment(){
		return $this->_orm->downpayment;
	}

	public function getBalance(){
		$balance = $this->total - $this->downpayment;
		return $balance;
	}

	public function getItems(){
		$items = OrderItem::findByOrder($this->id);
		if($items){
			return $items;
		}
		return null;
	}

	public function getTotal(){
		$items = $this->items;
		$total = 0;
		foreach ($items as $item) {
			# code...
			$total += $item->subtotal;
		}
		return $total;
	}


//Setters
	public function setUser($value){
		if($value instanceof User){
			$this->_orm->user_id = $value->id;
			return true;
		}
		$user = User::findById($value);
		if($user){
			$this->_orm->user_id = $user->id;
			return true;
		}else{
			throw new Exception("User does not exist");
			
		}
	}

	public function setDownpayment($value){
		$this->_orm->downpayment = $value;
	}



	public function addItem($item=null){
		if($item instanceof OrderItem){
			$item->order = $this->id;
			$item->save();
			return true;
		}
		$item = new OrderItem();
		$item->order = $this->id;
		return $item;
	}

}

?>
