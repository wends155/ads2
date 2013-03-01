<?php


class Conn{
	protected static $db = "sqlite:../db/ads.sqlite";
	
	public static function getConn(){
		return new PDO(static::$db);
		
	}

	public static function query($sql){
		$conn = static::getConn();
		return $conn->query($sql);
	}
	
}

?>