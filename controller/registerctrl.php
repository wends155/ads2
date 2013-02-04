<?php 
require_once "../db/general.php";
require_once "../lib/template.php";

class RegisterCtrl{

	public static function index(){
		return function($request,$response){
			$tpl = Template::load('register.html');
			echo $tpl->render(array());
		};
	}

	public static function check(){
		return function($req,$res){
			$user = User::findByUsername($req->user);
			if($user){
				$res->code(200);
			}else{
				$res->code(404);
			}
		};
	}

	public static function new_user(){
		return function($req,$res){
			$data = $req->data();
			$user = $data->user;
			$new_user = new User();
			$new_user->username = $user->username;
			$new_user->password = $user->password;
			$new_user->save();

			$profile = $data->profile;
			$profile->id = $new_user->id;
			$new_profile = Profile::create($profile);

			//$res->json($new_profile->as_array());
			$res->redirect('/login'); 
		};
	}
}

 ?>