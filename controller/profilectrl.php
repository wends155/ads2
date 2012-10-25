<?php 
require_once "../db/general.php";

class ProfileCtrl{

	public static function profile(){
		return function($request, $response){
			$id = $request->session('id');
			if($id){
				$user = User::findById($id);
				$profile = $user->profile;
				$response->json($profile->as_array());	
			}else{
				echo $id;
			}
			
		};
	}

	public static function update(){
		return function($request,$response){
			$id = $request->session('id');
			if($id){
				$user = User::findById($id);
				$profile = $user->profile;

				if($profile){
					$data = $request->data();
					$profile->update($data);
					$profile->save();
					$response->json($profile->as_array());
				}else{
					$response->code(404);
				}

			}else{
				$response->code(404);
			}
			
		};
	}
}

 ?>