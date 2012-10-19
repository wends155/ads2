<?php
$lib = '../lib';
require "$lib/klein.php";
//require "$lib/database.php";
require "$lib/template.php";
require_once "../db/general.php";
require_once "../controller/general.php";

respond(function ($request, $response, $app) {
    // Handle exceptions => flash the message and redirect to the referrer
    $response->onError(function ($response, $err_msg) {
        //$response->flash($err_msg);
        $response->code(500);
        echo $err_msg;
    });

    
});
respond('/error', function($req,$res){
	throw new Exception('sample error');
	});


respond('/','def');
function def($request,$response) {
	if (!$request->session('id')){
		$tpl = Template::load('index.html');
		echo $tpl->render(array('title'=>'Login'));
	}elseif($request->session('admin')){
		try{
		$tpl = Template::load('admin_index.html');
		echo $tpl->render(array('title'=>'Admin', 'username'=>$request->session('username')));
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}else {
		$tpl = Template::load('user_index.html');
		$data = array(
			"title" => "Adsell",
			"username" => $request->session('username')
		);
		
		echo $tpl->render($data);
	}
}
respond('/login',function($req,$res){
	if($req->method('post')){
		$username = $req->param('username');
		$password = $req->param('password');
		$auth = User::validateUserPass($username,$password);
		if ($auth) {
			# code...
			$user = User::findByUsername($username);
			$res->session('id',$user->id);
			$res->session('username',$user->username);
			
			$res->redirect('/');
			
		} else {
			$res->redirect('/login');
		}
		
	}else{
		$tpl = Template::load('login.html');
		echo $tpl->render(array());	
	}
	
});
respond('/logout',function($req,$res){
	$res->session('id',null);
	$res->session('username',null);
	$res->session('admin',null);
	$res->redirect('/');
});

respond('/admin',function($req,$res){
	if($req->method('post')){
		$username = $req->param('username');
		$password = $req->param('password');
		$user = User::findByUsername($username);
		if($user->validate($password)){
			$res->session('id',$user->id);
			$res->session('username', $user->username);
			$res->session('admin', true);
			$res->redirect('/');
		}else{
			$res->redirect('/admin');
		}
	}else {
		$tpl = Template::load('adminlogin.html');
		echo $tpl->render(array());
	}
});

respond('/catalog',function($req,$res){
	$tpl = Template::load('cat_index.html');
	echo $tpl->render(array('title'=>'Catalog','username'=>$req->session('username')));
});


// AJAX FUNCTIONS
respond('/profile/[i:id].json','profile');
function profile($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	if($req->method('POST')){
		$data = json_decode( file_get_contents("php://input") );
		$model = Profile::findById($req->id);
		if($model){
			
			$model->fname = $data->fname;
			$model->lname = $data->lname;
			$model->mname = $data->mname;
			$model->address = $data->address;
			$model->birthday = $data->birthday;
			$model->gender = $data->gender;
			$model->nationality = $data->nationality;
			$model->bio = $data->bio;
			$model->status = $data->status;
			$model->user_id = $req->id;
			$model->mobile = $data->mobile;

			$model->save();
			
			echo $model;
		} else {
			$res->code(404);
		}
	}else{
		
		$prof = Profile::findById($req->id);
		if($prof){
			echo $prof;
		}else{
			$res->code(404);
		}

	}
}

respond('POST','/profile/new.json',function($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = json_decode( file_get_contents("php://input") );
	$model = new Profile();

	$model->fname = $data->fname;
	$model->lname = $data->lname;
	$model->mname = $data->mname;
	$model->address = $data->address;
	$model->birthday = $data->birthday;
	$model->gender = $data->gender;
	$model->nationality = $data->nationality;
	$model->bio = $data->bio;
	$model->status = $data->status;
	$model->user_id = $data->id;
	$model->mobile = $data->mobile;

	$model->save();
	echo $model;

});

respond('/brand/[i:id].json',BrandCtrl::get());

respond('GET','/brand/all.json',BrandCtrl::index());

respond('POST','/brand/new.json',BrandCtrl::add());

respond('/category/[i:id].json',CategoryCtrl::get());

respond('GET','/category/all.json',CategoryCtrl::index());

respond('POST','/category/new.json',CategoryCtrl::add());

respond('/company/[i:id].json', CompanyCtrl::get());

respond('POST','/company/new.json',function($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = json_decode( file_get_contents("php://input") );
	$model = new Company();
	$model->name = $data->name;
	$model->description = $data->description;
	
	$model->save();
	echo $model;

});

respond('GET','/company/all.json',CompanyCtrl::index());

respond('/product/[i:id].json', function($req,$res){
	$res->header('Content-Type', 'application/json');
	$model = Product::findById($req->id);

	if($model){
		if($req->method('post')){
			$data = json_decode( file_get_contents("php://input"));
			
			$model->brand_id = $data->brand_id;
			$model->company_id = $data->company_id;
			$model->category_id = $data->category_id;
			$model->name = $data->name;
			$model->description = $data->description;
			$model->price = $data->price;
			
			$model->save();
			echo $model->as_joined_json();
		}else{
			echo $model->as_joined_json();
		}
		
	} else {
		$res->code(404);
	}
});

respond('POST','/product/new.json',function($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = json_decode( file_get_contents("php://input") );
	$model = new Product();
	
	$model->brand_id = $data->brand_id;
	$model->company_id = $data->company_id;
	$model->category_id = $data->category_id;
	$model->name = $data->name;
	$model->description = $data->description;
	$model->price = $data->price;
	
	$model->save();		
	echo $model->as_joined_json();

});

respond('GET','/product/all.json',function($req,$res){
	$res->header('Content-Type', 'application/json');
	$products = Product::all();
	$all = array();
	foreach ($products as $product) {
		# code...
		$all[] = $product->as_joined_array();
	}
	echo json_encode($all);
});

respond('GET', '/user/[i:user]/orders/all.json', OrderCtrl::admin_index());
respond('GET', '/order/all.json', OrderCtrl::user_index());

dispatch();
?>
