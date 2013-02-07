<?php
require_once "general.php";

class Metrics extends Model{
	public static $_table = 'metrics';
	protected static $class =  'Metrics';

	public function getCount(){
		$count = intval($this->_orm->new_orders);
		$this->_orm->new_orders = 0;
		$this->_orm->save();
		return $count;
	}
}

?>
