<?php 
require "../dues.php";

$admin = Metrics::all();
$n = $admin[0];
var_dump($n->count);
 ?>
