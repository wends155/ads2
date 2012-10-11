<?php
$lib = '../lib';
require "$lib/klein.php";
//require "$lib/database.php";
require "$lib/template.php";
require "../db/general.php";

respond('/','def');
function def($request,$response) {
	if (!$request->session('id')){
		$tpl = Template::load('login.html');
		echo $tpl->render(array('title'=>'Login', 'message'=>$request->session('id')));
	} else {
		$tpl = Template::load('index.html');
		$data = array(
			"title" => "WebApp Boilerplate",
			"message" => "I'm using Twig with erb syntax, id:" . $request->session('id')
		);
		
		echo $tpl->render($data);
	}
	
	 
}

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

respond('/brand/[i:id].json',function($req,$res){
	$res->header('Content-Type', 'application/json');
	$model = Brand::findById($req->id);
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
});

respond('GET','/brand/all.json',function($req,$res){
	$res->header('Content-Type', 'application/json');
	$models = Brand::all();
	$all = array();
	foreach ($models as $model) {
		# code...
		$all[] = $model->as_array();
	}
	echo json_encode($all);
});

respond('POST','/brand/new.json',function($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = json_decode( file_get_contents("php://input") );
	$model = new Brand();
	$model->name = $data->name;
	$model->description = $data->description;
	
	$model->save();
	echo $model;

});

respond('/category/[i:id].json',function($req,$res){
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
});

respond('GET','/category/all.json',function($req,$res){
	$res->header('Content-Type', 'application/json');
	$models = Category::all();
	$all = array();
	foreach ($models as $model) {
		# code...
		$all[] = $model->as_array();
	}
	echo json_encode($all);
});

respond('POST','/category/new.json',function($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = json_decode( file_get_contents("php://input") );
	$model = new Category();
	$model->name = $data->name;
	$model->description = $data->description;
	
	$model->save();
	echo $model;

});

respond('/company/[i:id].json', function($req,$res){
	$res->header('Content-Type', 'application/json');
	$model = Company::findById($req->id);

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
});

respond('POST','/company/new.json',function($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = json_decode( file_get_contents("php://input") );
	$model = new Company();
	$model->name = $data->name;
	$model->description = $data->description;
	
	$model->save();
	echo $model;

});

respond('GET','/company/all.json',function($req,$res){
	$res->header('Content-Type', 'application/json');
	$models = Company::all();
	$all = array();
	foreach ($models as $model) {
		# code...
		$all[] = $model->as_array();
	}
	echo json_encode($all);
});

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

dispatch();
?>
