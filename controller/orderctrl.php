<?php 
require_once "../db/general.php";

class OrderCtrl{

	public static function get(){
		return function($request,$response){


		};
		
	}

	public static function change(){
		return function($request, $response){

		};
	}

	public static function add(){

		return function($request,$response){

		};
	}

	public static function admin_index(){
		return function($request, $response){
			$user_id = $request->user;
			$orders = Order::findByUser($user_id);
			#$order_arr = array();
			#foreach ($orders as $order) {
			#	# code...
			#	$order_arr[] = $order->as_array();
			#}
			if($orders){
				$response->json($orders->as_array());	
			} else {
				$response->code(404);
			}

			
		};
	}

	public static function user_index(){
		return function($request,$response){
			$user_id = $request->session('id');
			
			
			$orders = Order::findByUser($user_id);
			if(!$user_id){
				$response->code(403);

			}else {
				if($orders){
					$response->json($orders->as_array());
				}else{
					$response->json(array());
				}
			}
			
		};
	}
}

 ?>