<?php 
require "../user.php";
echo User::count() . "\n";
$all = User::all();
foreach ($all as $user) {
	# code...
	print_r($user->as_array());
}

$user = User::findById(3);
$user->password = 'test';
$user->save();
print_r($user->as_array());

$user = User::findByUsername('wewe');
print_r($user->as_array())
 ?>