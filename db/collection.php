<?php 

class Collection implements Iterator {
  private $myArray;

  public function __construct( $givenArray ) {
    $this->myArray = $givenArray;
  }
  function rewind() {
    return reset($this->myArray);
  }
  function current() {
    return current($this->myArray);
  }
  function key() {
    return key($this->myArray);
  }
  function next() {
    return next($this->myArray);
  }
  function valid() {
    return key($this->myArray) !== null;
  }

  public function as_array(){
  	$models = array();
  	foreach ($this->myArray as $model) {
  		# code...
  		$models[] = $model->as_array();
  	}

  	return $models;
  }

  public function as_json(){
  	$models = $this->as_array();
  	return json_encode($models);
  }
}


 ?>