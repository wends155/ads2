<?php 
require_once "../db/general.php";
$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once "Zend/Pdf.php";

class ReportCtrl{

	public static function template(){
		return function($request,$response){
			if($request->session('admin')){
				

			}else{
				$response->code(403);
			}
		};
	}

	public static function test(){
		return function($request,$response){
			if($request->session('admin')){
				$response->header('Content-Type','application/pdf');
				
				$stocks = Zend_Pdf::load('../pdf/inventory.pdf');
				$page = $stocks->pages[0];
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
				$page->setFont($font,11);
				//echo "Height = {$page->getHeight()} \n";
				//echo "Width  = {$page->getWidth()} \n";
				$date = 'Date: 9/19/2012';
				$name = 'Jellene Q. Pastoral';
				
				$page->drawText($name, 100, 100);
				echo $stocks->render();

			}else{
				$response->code(403);
			}
		};
	}

	
}




?>