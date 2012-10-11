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
$prod = Product::findById(1);
//echo $prod;
//var_dump($prod->as_joined_json());
$products = Product::findByBrand(2);
print_r($products);
 ?>