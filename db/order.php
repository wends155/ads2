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

	public function getDate(){
		return $this->_orm->date;
	}

	public function getDate_paid(){
		return $this->_orm->date_paid;
	}

	public function getDate_claimed(){
		return $this->_orm->date_claimed;
	}

	public function getDue(){
		return $this->_orm->due;
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

	public function as_array(){
		$model = $this->_orm->as_array();
		unset($model['user_id']);
		$model['items'] = $this->items->as_array();
		$model['user'] = array(
				'id' => $this->user->id,
				'fullname' => $this->user->profile->fullname
			);
		$model['total'] = $this->total;

		return $model;
	}

	public function delete(){
		$items = $this->items;
		$this->_orm->delete();
		$items->delete();
		return true;
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

	public static function findByUser($user_id){
		$orders = ORM::for_table(static::$_table)->where('user_id', $user_id)->find_many();
		
		if($orders){
			$models = array();
			foreach ($orders as $order) {
				# code...
				$models[] = new Order($order);
			}
			return new Collection($models);
		}
		return null;
	}

}

?>
