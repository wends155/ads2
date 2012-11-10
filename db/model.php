<?php
require_once "idiorm.php";
require_once 'collection.php';

$db_path = 'sqlite:'.dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ads.sqlite';
ORM::configure($db_path);
abstract class Model{
	public static $_table = __CLASS__;
	protected $_orm = null;
	protected static $class = null;
	
	public static function configure(){
		$db_path = 'sqlite:'.dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ads.sqlite';
		ORM::configure($db_path);
	}	
	
	public function __construct($orm = null){
		self::configure();
		if($orm){
			$this->_orm = $orm;
		} else {
			$this->_orm = ORM::for_table(static::$_table)->create();
		}
	}
	
	public function __set($name,$value){
		//$this->_orm->$name = $value;
		$setter = 'set' . ucfirst($name);
		if(method_exists($this, $setter)){
			return $this->$setter($value);
		}
		throw new Exception("$name does not exist");
		
	}
	
	public function __get($name){
			$getter = 'get' . ucfirst($name);
			if(method_exists($this, $getter)){
				return $this->$getter();	
			}
			throw new Exception("$name does not exist");
							
	}
	
	public function save(){
		$this->_orm->save();
	}
	
	public function id(){
		return $this->_orm->id();
	} 

	
	public function isModified($name){
		return $this->_orm->is_dirty($name);
	}

	public function delete(){
		$this->_orm->delete();
	}

	public function as_array(){
		return $this->_orm->as_array();
	}

	public function as_json(){
		return json_encode($this->as_array());
	}

	public function __toString(){
		return $this->as_json();

	}
	
	//STATIC
	public static function findById($id){
		self::configure();
		$user = ORM::for_table(static::$_table)->find_one($id);
		if($user){
			return new static::$class($user);	
		}
		return null;
		
	}

	//STATIC
	public static function count(){
		self::configure();
		$count = ORM::for_table(static::$_table)->count();
		return $count;

	}

	//STATIC
	public static function all(){
		self::configure();
		$all = ORM::for_table(static::$_table)->find_many();
		$models = array();
		foreach ($all as $model) {
			$models[] = new static::$class($model);
		}
		return new Collection($models);
	}

	
}


?>
