<?php 
require_once "../db/general.php";

class StockCtrl{

	public static function template(){
		return function($request,$response){
			if($request->session('admin')){
				switch ($request->method()) {
					case 'GET':
						# code...
						echo "GET";
						break;
					case 'POST':
						# code...
						echo "POST";
						break;
					case 'DELETE':
						# code...
						echo "DELETE";
						break;	
					case 'PUT':
						# code...
						echo "PUT";
						break;
					default:
						# code...
						break;
				}

			}else{
				$response->code(403);
			}
		};
	}

	public static function index(){
		return function($request,$response){
			if($request->session('admin')){
				switch ($request->method()) {
					case 'GET':
						# code...
						$stocks = Stock::all();
						$response->json($stocks->as_array());
						break;
					case 'POST':
						# code...
						$data = $request->data();

						$stock = new Stock();
						$stock->product = $data->product->id;
						$stock->quantity = $data->quantity;
						$stock->save();
						$response->json($stock->as_array());
						break;
					case 'DELETE':
						# code...
						echo "DELETE";
						break;	
					case 'PUT':
						# code...
						echo "PUT";
						break;
					default:
						# code...
						break;
				}

			}else{
				$response->code(403);
			}
		};
	}

	public static function show(){
		return function($request,$response){
			if($request->session('admin')){
				$id = $request->id;
				$stock = Stock::findById($id);
				if($stock){
					switch ($request->method()) {
						case 'GET':
							# code...
							#echo "GET " . $id;
							$response->json($stock->as_array());
							break;
						case 'POST':
							# code...
							echo "POST " . $id;
							break;
						case 'DELETE':
							# code...
							#echo "DELETE";
							$stock->delete();
							$response->code(200);
							break;	
						case 'PUT':
							# code...
							echo "PUT";
							break;
						default:
							# code...
							break;
					}
				}else{
					$response->code(404);
				}

			}else{
				$response->code(403);
			}
		};
	}

	public static function increment(){
		return function($request,$response){
			if($request->session('admin')){
				$id = $request->product;
				$stock = Stock::findById($id);
				if($stock){
					switch ($request->method()) {
						case 'GET':
							# code...
							#echo "GET " . $id;
							$value = $request->value;
							$stock->increment($value);
							$response->json($stock->as_array());
							break;
						case 'POST':
							# code...
							echo "POST " . $id;
							break;
						case 'DELETE':
							# code...
							echo "DELETE";
							
							break;	
						case 'PUT':
							# code...
							echo "PUT";
							break;
						default:
							# code...
							break;
					}
				}else{
					$response->code(404);
				}

			}else{
				$response->code(403);
			}
		};
	}

	public static function decrement(){
		return function($request,$response){
			if($request->session('admin')){
				$id = $request->product;
				$stock = Stock::findById($id);
				if($stock){
					switch ($request->method()) {
						case 'GET':
							$value = $request->value;
							$stock->decrement($value);
							$response->json($stock->as_array());
							break;
						case 'POST':
							# code...
							echo "POST " . $id;
							break;
						case 'DELETE':
							# code...
							#echo "DELETE";
							$stock->delete();
							$response->code(200);
							break;	
						case 'PUT':
							# code...
							echo "PUT";
							break;
						default:
							# code...
							break;
					}
				}else{
					$response->code(404);
				}

			}else{
				$response->code(403);
			}
		};
	}
}

?>