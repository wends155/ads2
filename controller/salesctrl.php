<?php 
require_once "../db/general.php";

class SalesCtrl{

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
						#echo "GET";
						$sales = Sales::all();
						$response->json($sales->as_array());
						break;
					case 'POST':
						$data = $request->data();
						$sales = new Sales();
						$sales->date = $data->date;
						$sales->order = $data->order_id;
						$sales->amount = $data->amount;
						$sales->save();
						$response->json($sales->as_array());
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
	
}

?>