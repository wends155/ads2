<?php 
require_once "../db/general.php";

class RetExCtrl{

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
						$retex = Retex::all();
						$response->json($retex->as_array());
						break;
					case 'POST':
						$data = $request->data();
						$retex = new Retex();
						$retex->old_product_id = $data->old_product_id;
						$retex->new_product_id = $data->new_product_id;
						$retex->date 			= $data->date;
						$retex->item_id 		= $data->item_id;
						$retex->done 			= $data->done;
						$retex->save();
						$response->json($retex->as_array());
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
				switch ($request->method()) {
					case 'GET':
						# code...
						$id = $request->id;
						$retex = Retex::findById($id);
						if($retex){
							$response->json($retex->as_array());
						}else{
							$response->code(404);
						}
						break;
					case 'POST':
						# code...
						$id = $request->id;
						$data = $request->data();
						$retex = Retex::findById($id);
						if($retex){
							$retex->old_product_id = $data->old_product_id;
							$retex->new_product_id = $data->new_product_id;
							$retex->date 			= $data->date;
							$retex->item_id 		= $data->item_id;
							$retex->done 			= $data->done;
							$retex->save();
							$response->json($retex->as_array());
						}else{
							$response->code(404);
						}
						
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
	
}

?>