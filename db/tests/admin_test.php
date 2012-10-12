<?php 
require "../admin.php";

$admin = new Admin();
$admin->username = 'admin';
$admin->password = 'admin';
$admin->save();
 ?>