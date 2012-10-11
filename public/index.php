<?php
$lib = '../lib';
require "$lib/klein.php";
require "$lib/database.php";
require "$lib/template.php";

respond('/','def');
respond('/[i:id]','profile');
respond('/[:name]/status.[html|csv|json:format]?','report');
respond('/redirect', function($req,$res){
		$res->redirect("/");
	});
respond('/login/[i:id]/[:name]', function($req,$res){
	$res->header('Content-Type', 'text/plain');
	$res->session('id',$req->id);
	$res->redirect('/');
	print_r($_SERVER);
});
respond('/logout', function($req,$res){
	$res->session('id', null);
	$res->redirect('/');
	});
respond('/register','register');
respond('/twig', 'twig_test');

function register(){
	$tpl = Template::load('register.html');
	echo $tpl->render(array('content' => 'test content'));
}

function twig_test(){
	//echo "hello";
	$tpl = Template::load('test.html');
	echo $tpl->render(array('content' => 'test content'));
}

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

function profile($req,$res){
	
	try{
		$id = $req->id;
		$data = Database::sql("select * from students where id = $id");
	}catch(Exception $e){
		exit( $e->getMessage());
	}
	if(!$data){
		$res->code(404);
		echo 'Not Found';
	}else{
		$res->header('Content-Type','application/json');
		echo json_encode($data);
	}
	
}

function report($request, $response,$view) {
	switch($request->format) {
		case 'json': 
			$response->header('Content-Type','application/json');
			echo 'hello json: ' . $request->uri() . "\n";
			var_dump( $request->params()) . "\n";
			echo $request->param('year');
			break;
		case 'csv':
			$response->header('Content-Type', 'text/plain');
			echo 'hello csv';
			break;
		default: 
			echo 'hello default';
			//echo 'hello default ';
	}
}

dispatch();
?>
