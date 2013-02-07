<?php 
require "../dues.php";

$admin = Dues::all();
var_dump($admin->as_json());
 ?>
