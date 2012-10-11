<?php
require "idiorm.php";
ORM::configure('sqlite:ads.sqlite');


//$user = ORM::for_table('users')->find_many();
//print_r($user);

$cat = ORM::for_table('categories')->find_one(1);
var_dump($cat);
?>
