<?php 
require_once "../db/general.php";

class OrderItemCtrl{
	public static function get(){
		return function($request, $response){
			$user_id = $request->session('id');
			
			if($user_id){
				$id = $request->id;
				$item = OrderItem::findById($id);

				if($item){
					$response->json($item->as_array());
				}else{
					$response->code(404);
				}
				
			}else{
				$response->code(403);
			}

		};
	}

	public static function post(){
		return function($request, $response){
			$user_id = $request->session('id');

			if($user_id){
				$id = $request->id;
				$item = OrderItem::findById($id);
				if($item){
					$data = $request->data();
					$item->product = $data->new_product->id ? $data->new_product->id : $item->product;
					$item->price = $data->new_product->price ? $data->new_product->price : $item->price;  
					$item->save();

					$response->json($item->as_array());
				}else{
					$response->code(404);
				}
				
			}else{
				$response->code(403);
			}
		};
	}

	public static function alternative(){
		return function($request, $response){
			$product_id = $request->id;
			$prod = Product::findById($product_id);

			if($prod){
				$brand = $prod->brand;
				$prods = $brand->products;
				$response->json($prods->as_array());
			} else{
				$response->code(404);
			}
		};

	}
}

 ?>