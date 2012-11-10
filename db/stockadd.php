<?php 
require_once "general.php";

class StockAdd extends Model{
	public static $_table = 'stock_add';
	public static $class = 'StockAdd';

	//**********************//
	//****** GETTERS *******//
	public function getId(){
		return $this->_orm->id;
	}

	public function getProduct(){
		return $this->_orm->product_id;
	}

	public function getQuantity(){
		return $this->_orm->quantity;
	}

	public function getDate(){
		return $this->_orm->date;
	}

	//*********************//
	//***** SETTERS *******//
	public function setProduct($value){
		$this->_orm->product_id = $value;
	}

	public function setQuantity($value){
		$this->_orm->quantity = $value;
	}

	public function setDate($value){
		$this->_orm->date = $value;
	}


}

?>