<?php 
require "../admin.php";

$admin = Admin::findById(1);
$auth = $admin->validate('admin');
var_dump($auth);
 ?>
