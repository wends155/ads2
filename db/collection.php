<?php 

class Collection implements Iterator, Countable, ArrayAccess {
  protected $myArray;

  public function __construct( $givenArray ) {
    $this->myArray = $givenArray;
  }

  //****************//
  //****Iterator****//
  //****************//
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

//**************************//
//******ArrayAccess*********//
//**************************//

  public function offsetSet($offset, $value){
    if($offset){
      $this->myArray[$offset] = $value;
    }
  } 

  public function offsetExists($offset){
    return isset($this->myArray[$offset]);
  }

  public function offsetUnset($offset){
    unset($this->myArray[$offset]);
  }

  public function offsetGet($offset){
    return isset($this->myArray[$offset]) ? $this->myArray[$offset] : null;
  }

//*************************//
//*******Countable*********//
//*************************//
  public function count(){
    return count($this->myArray);
  }

  public function length(){
    return $this->count();
  }


//************************//
//***Utility Functions****//
//************************//
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

  public function __toString(){
    return $this->as_json();
  }

  public function delete(){
    foreach ($this->myArray as $model) {
      # code...
      $model->delete();
    }
    return true;
  }
}


 ?>