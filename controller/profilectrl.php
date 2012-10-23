<?php 
require_once "../db/general.php";

class ProfileCtrl{

	public static function profile(){
		return function($request, $response){
			$id = $request->session('id');
			$profile = Profile::findById($id);
			$response->json($profile->as_array());
		};
	}

	public static function update(){
		return function($request,$response){
			$id = $request->session('id');
			$profile = Profile::findById($id);

			if($profile){
				$data = $request->data();
				$profile->update($data);
				$profile->save();
				$response->json($profile->as_array());
			}else{
				$response->code(404);
			}
		};
	}
}

 ?>