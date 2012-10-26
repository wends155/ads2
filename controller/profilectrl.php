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
				$response->code(403);
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
				$response->code(403);
			}
			
		};
	}

	public static function verify_password(){
		return function($request, $response){
			$id = $request->session('id');
			if($id){
				$user = User::findById($id);
				$data = $request->data();
				$auth = $user->validate($data->password);
				if($auth){
					$response->code(200);
				}else{
					$response->code(403);
				}
			}else{
				$response->code(404);
			}
		};
	}

	public static function change_password(){
		return function($request,$response){
			$id = $request->session('id');
			if($id){
				$user = User::findById($id);
				$data = $request->data();
				$auth = $user->validate($data->password);
				if($auth){
					$user->password = $data->new_password;
					$user->save();
					$response->code(200);
				}else{
					$response->code(403);
				}
			}else{
				$response->code(404);
			}
		};
	}
}

 ?>