<?php 
require_once "../db/general.php";

class CompanyCtrl{

	public static function get(){

		return function($req, $res){

			$res->header('Content-Type', 'application/json');
			$model = Company::findById($req->id);

			if($model){
				if($req->method('post')){
					$data = json_decode( file_get_contents("php://input"));
					$model->name = $data->name;
					$model->description = $data->description;
					
					$model->save();
					echo $model;
				}if($req->method('delete')){
					$model->delete();
					$res->code(200);
				}else{
					echo $model;
				}
				
			} else {
				$res->code(404);
			}
		};
	}

	public static function add(){

		return function($request,$response){
			$data = $request->data();
			$model 		 = new Company();
			$model->name = $data->name;
			$model->description = $data->description;

			$model->save();
			$response->json($model->as_array());
		};
	}

	public static function index(){
		return function($request, $response){
			$models = Company::all();
			$response->json($models->as_array());
		};
	}
}

 ?>