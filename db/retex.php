<?php
require_once "general.php";

class RetEx extends Model{
	public static $_table = 'return';
	protected static $class =  'RetEx';

	public function getOld_product_id(){
		return $this->_orm->old_product_id;
	}

	public function setOld_product_id($value){
		$this->_orm->old_product_id = $value;
	}

	public function getNew_product_id(){
		return $this->_orm->new_product_id;
	}

	public function setNew_product_id($value){
		$this->_orm->new_product_id = $value;
	}

	public function getDate(){
		return $this->_orm->date;
	}

	public function setDate($value){
		$this->_orm->date = $value;
	}

	public function getItem_id(){
		return $this->_orm->item_id;
	}

	public function setItem_id($value){
		$this->_orm->item_id = $value;
	}

	public function getDone(){
		return $this->_orm->done;
	}

	public function setDone($value){
		$this->_orm->done = $value;
	}

	public function as_array(){
		$model = $this->_orm->as_array();
		
		$model['new_product'] = Product::findById($this->new_product_id)->name;
		$model['old_product'] = Product::findById($this->old_product_id)->name;
		$model['order'] = OrderItem::findById($this->item_id)->order->id;
		$model['user'] = OrderItem::findById($this->item_id)->order->user->profile->fullname;
		return $model;
	}
}

?>
