<?php
require_once "general.php";

class Category extends Model{
	public static $_table = 'categories';
	protected static $class = 'Category';

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

//==special===

	public function getProducts(){
		$products = Product::findByCategory($this->id);
		return $products;
	}

}

?>
