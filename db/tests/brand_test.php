<?php 
require "../brand.php";

//$brand = new Brand();
//$brand->name = "Avon Naturals";
//$brand->save();

$brand = Brand::findById(3);
echo $brand->products[1]->as_joined_json();
 ?>