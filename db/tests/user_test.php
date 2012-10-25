<?php 
require "../user.php";
$user = User::findById(3);
var_dump($user->validate('wendell'));

 ?>
