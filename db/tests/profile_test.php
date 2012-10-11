<?php 
require_once "../profile.php";

$profile = Profile::findById(1);
print_r($profile);
$profile = Profile::findByUsername("wewe");
echo $profile->birthday;
$profile->birthday = "1986-12-7";
$profile->save();
echo $profile->birthday;
 ?>

