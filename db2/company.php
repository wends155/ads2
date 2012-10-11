<?php
require_once "general.php";

class Company extends Model{
	public static $_table = 'companies';
	protected static $class =  'Company';

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
		$products = Product::findByCompany($this->id);
		return $products;
	}

}

?>
