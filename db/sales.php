<?php
require_once "general.php";

class Sales extends Model{
	public static $_table = 'sales';
	protected static $class =  'Sales';

	//*******//
	public function getDate(){
		return $this->_orm->date;

	}

	public function getOrder(){
		$order = Order::findByID($this->_orm->order_id);

		if($order){
			return $order;
		}else{
			return false;
		}

	}

	public function getAmount(){
		return $this->_orm->amount;
	}

	//*************************//
	public function setDate($value){
		$this->_orm->date = $value;
	}

	public function setOrder($value){
		$order = Order::findByID($value);
		if($order){
			$this->_orm->order_id = $order->id;
			return true;
		}else{
			return false;
		}
	}

	public function setAmount($value){
		return $this->_orm->amount = $value;
	}

	public static function all(){
		self::configure();
		$all = ORM::for_table(static::$_table)->order_by_desc('date')->find_many();
		$models = array();
		foreach ($all as $model) {
			$models[] = new static::$class($model);
		}
		return new Collection($models);
	}
}

?>
