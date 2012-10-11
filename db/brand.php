<?php
require_once "general.php";

class Brand extends Model{
	public static $_table = 'brands';
	protected static $class =  'Brand';

//=== Getters====	
	protected function getId(){
		return $this->_orm->id;
	}

	public function getName(){
		return $this->_orm->name;
	}

	public function getDescription(){
		return $this->_orm->description;
	}

//===Setters====
	public function setName($value){
		$this->_orm->name = $value;
	}

	public function setDescription($value){
		$this->_orm->description = $value;
	}

	public function getProducts(){
		$products = Product::findByBrand($this->id);
		return $products;
	}

}

?>
