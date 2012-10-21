<?php 
require "../product.php";
/*
$prod = new Product();
$prod->name = "Avon Naturals Hair Care";
$prod->description = "Anti-Dandruff & Nourishing Shampoo 200mL";
$prod->brand = 3;
$prod->company = 3;
$prod->category = 3;
$prod->price = 97.50;
$prod->save();
print_r($prod->as_array());
**/
//$prod = Product::findById(2);
//print_r($prod->as_array());
//echo $prod;
//var_dump($prod->as_joined_json());
$products = Product::findByBrand(3);
print_r($products->as_array());
echo $products->as_json();
//print_r($products);
//echo $prod->as_json();
//$ob = json_decode($prod->as_json());
//var_dump($ob); 
 ?>