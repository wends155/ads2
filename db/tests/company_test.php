<?php 
require "../company.php";

$co = Company::findById(3);
echo $co->products[1]->as_joined_json();

 ?>