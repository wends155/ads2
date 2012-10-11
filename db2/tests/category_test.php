<?php 
require "../category.php";

$category = Category::findById(3);
print_r($category->products);
echo $category->products[1]->as_joined_json();
 ?>