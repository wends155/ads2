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

respond('/test', function($req,$res){
	$res->header('Content-Type','text/plain');
	var_dump($req->session('admin'));
	var_dump($req->session('username'));
	var_dump($req->session('id'));
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
		$user = Admin::findByUsername($username);
		$auth = Admin::validateUserPass($username,$password);
		if($auth){
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

respond('/register',RegisterCtrl::index());
respond('/check/[:user]', RegisterCtrl::check());
respond('POST', '/user', RegisterCtrl::new_user());
respond('/catalog',function($req,$res){
	$tpl = Template::load('cat_index.html');
	echo $tpl->render(array('title'=>'Catalog','username'=>$req->session('username')));
});


// AJAX FUNCTIONS
respond('/profile/[i:id].json','profile');
function profile($req,$res){
	$res->header('Content-Type', 'application/json; charset=utf-8');
	if($req->method('POST')){
		$data = $req->data();
		$model = Profile::findById($req->id);
		if($model){
						
			$model->update($data);

			$model->user_id = $req->id;
			$model->save();
			
			echo $model;
		} else {
			$res->code(404);
		}
	}else{
		
		$prof = Profile::findById($req->id);
		if($prof){
			$res->json($prof->as_array());
		}else{
			$res->code(404);
		}

	}
}

respond('POST','/profile/new.json',function($req,$res){
	//$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = $req->data();
	$model = Profile::create($data);

	$res->json($model->as_array());

});

respond('/brand/[i:id].json',BrandCtrl::get());
respond('GET','/brand/all.json',BrandCtrl::index());
respond('POST','/brand/new.json',BrandCtrl::add());

respond('/category/[i:id].json',CategoryCtrl::get());
respond('GET','/category/all.json',CategoryCtrl::index());
respond('POST','/category/new.json',CategoryCtrl::add());

respond('/company/[i:id].json', CompanyCtrl::get());
respond('POST','/company/new.json',CompanyCtrl::add());
respond('GET','/company/all.json',CompanyCtrl::index());


respond('/product/[i:id].json', function($req,$res){
	//$res->header('Content-Type', 'application/json');
	$model = Product::findById($req->id);

	if($model){
		if($req->method('post')){
			$data = $req->data();
			
			$model->update($data);
			
			$model->save();
			$res->json($model->as_array());

		}elseif($req->method('delete')){
			$model->delete();
			$res->code(200);
		}else{
			$res->json($model->as_array());
		}
		
	} else {
		$res->code(404);
	}
});

respond('POST','/product/new.json',function($req,$res){
	//$res->header('Content-Type', 'application/json; charset=utf-8');
	$data = $req->data();
	$model = Product::create($data);
	
	$res->json($model->as_array());

});

respond('GET','/product/all.json',function($req,$res){

	$products = Product::all();
	$res->json($products->as_array());	
	
});

respond('GET', '/user/[i:user]/orders', OrderCtrl::admin_index());
respond('GET', '/orders', OrderCtrl::user_index());
respond('POST','/orders', OrderCtrl::create());
respond('GET', '/orders/[i:id]', OrderCtrl::get());
respond('POST', '/orders/[i:id]', OrderCtrl::change());

respond('GET', '/brand/[i:id].json/products', BrandCtrl::products());
respond('GET', '/profile', ProfileCtrl::profile());
respond('POST', '/profile', ProfileCtrl::update());
respond('POST', '/verify_password', ProfileCtrl::verify_password());
respond('POST', '/change_password', ProfileCtrl::change_password());
respond('GET', '/items/[i:id]',OrderItemCtrl::get());
respond('POST', '/items/[i:id]', OrderItemCtrl::post());
respond('GET', '/alt/[i:id]', OrderItemCtrl::alternative());

respond('GET', '/profiles', ProfileCtrl::index());
respond('GET', '/profiles/[i:id]', ProfileCtrl::show());
respond('DELETE', '/profiles/[i:id]', ProfileCtrl::delete());
respond('GET', '/profiles/[i:user]/orders', OrderCtrl::admin_index());
respond('/stocks',StockCtrl::index());
respond('/stocks/[i:id]', StockCtrl::show());
respond('/stocks/[i:product]/inc/[i:value]',StockCtrl::increment());
respond('/stocks/[i:product]/dec/[i:value]', StockCtrl::decrement());

respond('/report/inventory.pdf', ReportCtrl::test());
respond('/order/[i:id]/receipt.pdf',ReportCtrl::user_order_receipt());

respond('/sales',SalesCtrl::index());
respond('/sales/[i:id]',SalesCtrl::show());

respond('/return', RetExCtrl::index());
respond('/return/[i:id]', RetExCtrl::show());
respond('/dues',function($req,$res){
	$dues = Dues::all();
	$res->json($dues->as_array());
});
respond('/new_orders', function($req,$res){
	$n = Metrics::all();
	$n = $n[0];
	//echo $n->count;
	$count = array('count' => $n->count);
	$res->json($count);
});
respond('POST','/sms',function($req,$res){
	$ctx = new ZMQContext();
	$push = new ZMQSocket($ctx, ZMQ::SOCKET_PUSH);
	$endpoint = "tcp://184.164.136.144:5566";
	$push->connect($endpoint);
	$input = $req->data();
	if ($input->number){
		$data = array('id' => time(),
					'number' => $input->number,
					'message' => $input->message
		);
		$push->send(json_encode($data));
		$res->json($data);	
	}else{
		$res->code(500);
	}
	
	

});
dispatch();
?>
