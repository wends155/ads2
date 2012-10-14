<?php 
require_once "../db/general.php";

class CategoryCtrl{

	public static function get(){
		return function($req,$res){
			$res->header('Content-Type', 'application/json');
			$model = Category::findById($req->id);

			if($model){
				if($req->method('post')){
					$data = json_decode( file_get_contents("php://input"));
					$model->name = $data->name;
					$model->description = $data->description;
					
					$model->save();
					echo $model;
				}else{
					echo $model;
				}
				
			} else {
				$res->code(404);
			}
		};
	}

	public static function index(){
		return function($request, $response){
			$models = Category::all_as_array();
			$response->json($models);
		};
	}

	public static function add(){
		return function($request,$response){
			$raw = file_get_contents("php://input");
			$data = json_decode($raw);
			if($data){
				$response->header('Content-Type', 'application/json');
				$model = new Category();
				$model->name = $data->name;
				$model->description = $data->description;
				
				$model->save();
				echo $model;
			} else {
				$response->code(404);
			}
		};
	}
}

 ?>