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
		return $this->_orm->balance;
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

}

?>
