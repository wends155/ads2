<?php 
require_once "../db/general.php";

class BrandCtrl{

	public static function test(){
		return function($request, $response){
			echo "controller test";
		};

	}

	public static function get(){
		return function($req,$res){
			$res->header('Content-Type', 'application/json');
			$model = Brand::findById($req->id);
			if($model){
				if($req->method('post')){
					$data = json_decode( file_get_contents("php://input"));
					$model->name = $data->name;
					$model->description = $data->description;
					
					$model->save();
					echo $model;
				}elseif($req->method('delete')){
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

	public static  function index(){
		return function($req,$res){
			$res->header('Content-Type', 'application/json');
			$models = Brand::all();
			$all = array();
			foreach ($models as $model) {
				# code...
				$all[] = $model->as_array();
			}
			echo json_encode($all);
		};
	}

	public static function add(){
		return function($req, $res){
			$res->header('Content-Type', 'application/json; charset=utf-8');
	
			$raw = file_get_contents("php://input");
			$data = json_decode( $raw );
			$model = new Brand();
			$model->name = $data->name;
			$model->description = $data->description;
			
			$model->save();
			echo $model;	
		};
	}

	public static function testget(){
		return function($request, $response){
			$brand = Brand::findById($request->id);
			echo $brand;
		};
	}
}

 ?>