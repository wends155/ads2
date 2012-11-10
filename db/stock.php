<?php 
require_once "general.php";

class Stock extends Model{
	public static $_table = 'stock';
	public static $class = 'Stock';

	//*****************//
	//** GETTERS *****//
	public function getId(){
		return $this->_orm->id;
	}

	public function getProduct(){
		$product = Product::findById($this->_orm->product_id);
		if($product){
			return $product;
		}
		return null;
	}

	public function getQuantity(){
		return $this->_orm->quantity;
	}

	//******************//
	//*** SETTERS ******//
	public function setProduct($value){
		$product = Product::findById($value);
		if($product){
			$this->_orm->product_id = $product->id;
			return true;
		}
		return false;
		
	}

	public function setQuantity($value){
		return $this->_orm->quantity = $value;
	}

	public function increment($value){
		$value = intval($value);
		$oldValue = intval($this->_orm->quantity);
		$newValue = $oldValue + $value;
		$this->_orm->quantity = $newValue;

		$add = new StockAdd();
		$add->product = $this->_orm->product_id;
		$add->quantity = $value;
		$add->date = time();
		$add->save();
		#echo "_orm: " . $this->_orm->product_id;
		return $newValue;

	}

	public function decrement($value){
		$dec = intval($value);
		$oldValue = intval($this->_orm->quantity);
		$newValue = $oldValue - $dec;
		$this->_orm->quantity = $newValue;

		$rem = new StockRemove();
		$rem->product = $this->_orm->product_id;
		$rem->quantity = $value;
		$rem->date = time();
		$rem->save();

		return $newValue;
	}

	public function as_array(){
		$model = $this->_orm->as_array();
		$model['product'] = $this->product->as_array();
		unset($model['product_id']);
		return $model;
	}

	public static function findByProduct($id){
		$stock = ORM::for_table('stock')->where('product_id',$id)->find_one();
		if($stock){
			return new Stock($stock);
		} 
		return null;
	}


}

?>