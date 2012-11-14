<?php 
require_once '../general.php';

$return = RetEx::findById(3);

print_r($return->as_array());

?>