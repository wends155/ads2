<?php 
require "../user.php";
$user = User::findByUsername('wewe');
$user->password = "test";
$user->save();
echo $user->username;
echo $user;

 ?>