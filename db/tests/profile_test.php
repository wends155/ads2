<?php 
require_once "../profile.php";

$profile = Profile::findById(1);
#echo $profile->username;
print_r($profile->as_array());
$profs = Profile::all();
print_r($profs->as_array());
 ?>

