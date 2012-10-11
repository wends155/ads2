<?php
require_once "general.php";

class Product extends Model{
	public static $_table = 'products';
	protected static $class =  'Product';

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

	public function getPrice(){
		return $this->_orm->price;
	}

	public function getBrand(){
		$brand = Brand::findById($this->_orm->brand_id);
		return $brand;
	}

	public function getCompany(){
		return Company::findById($this->_orm->company_id);
	}

	public function getCategory(){
		return Category::findById($this->_orm->category_id);
	}

//===Setters====
	public function setName($value){
		$this->_orm->name = $value;
	}

	public function setDescription($value){
		$this->_orm->description = $value;
	}

	public function setPrice($value){
		$this->_orm->price = $value;
	}

	public function setBrand($value){
		if($value instanceof Brand){
			$this->_orm->brand_id = $value->id;
			return true;
		}
		$brand = Brand::findById($value);
		if($brand){
			$this->_orm->brand_id = $value;
			return true;
		}else{
			throw new Exception("Brand does not exist");
			
		}

	}

	public function setCompany($value){
		if($value instanceof Company){
			$this->_orm->company_id = $value->id;
			return true;
		}
		$company = Company::findById($value);
		if($company){
			$this->_orm->company_id = $value;
			return true;
		}
		throw new Exception("Company does not exist");
		
	}

	public function setCategory($value){
		if($value instanceof Category){
			$this->_orm->category_id = $value->id;
			return true;
		}
		$category = Category::findById($value);
		if($category){
			$this->_orm->category_id = $value;
			return true;
		}
		throw new Exception("Category does not exist");
		
	}

	//==utility funct===

	public function as_joined_array(){
		$model = $this->as_array();
		$model['brand'] = $this->brand->name;
		$model['company'] = $this->company->name;
		$model['category'] = $this->category->name;
		return $model;
	}

	public function as_joined_json(){
		$arr =  $this->as_joined_array();
		return json_encode($arr);
	}

	//STATIC

	public static function findByBrand($brand_id){
		$products = ORM::for_table(static::$_table)->where('brand_id', $brand_id)->find_many();
		
		if($products){
			$models = array();
			foreach ($products as $product) {
				# code...
				$models[] = new Product($product);
			}
			return $models;
		}
		return false;
		
	}

	public static function findByCompany($company_id){
		$products = ORM::for_table(static::$_table)->where('company_id', $company_id)->find_many();
		
		if($products){
			$models = array();
			foreach ($products as $product) {
				# code...
				$models[] = new Product($product);
			}
			return $models;
		}
		return false;
	}

	public static function findByCategory($category_id){
		$products = ORM::for_table(static::$_table)->where('category_id', $category_id)->find_many();
		
		if($products){
			$models = array();
			foreach ($products as $product) {
				# code...
				$models[] = new Product($product);
			}
			return $models;
		}
		return false;
	}
}

?>
