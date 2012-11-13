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
				
				$stocks_report = Zend_Pdf::load('../pdf/inventory.pdf');
				$page = $stocks_report->pages[0];
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
				$page->setFont($font,11);
				//echo "Height = {$page->getHeight()} \n";
				//echo "Width  = {$page->getWidth()} \n";
				$row = 476;
				$stocks = Stock::all();
				foreach ($stocks as $stock) {
					$page->drawText($stock->product->name, 100, $row);
					$page->drawText($stock->product->description, 300, $row);
					$page->drawText($stock->quantity, 610, $row);
					
					$row -= 15;
				}
				$page->drawText("as of " . Time::unixToDate(time()), 355, 525);
				
				echo $stocks_report->render();

			}else{
				$response->code(403);
			}
		};
	}

	public static function user_order_receipt(){
		return function($request,$response){
			$user_id = $request->session('id'); 
			if($user_id){
				$response->header('Content-Type','application/pdf');
				$id = $request->id;
				
				$order = Order::findById($id);
				$report = Zend_Pdf::load('../pdf/TrustReceipt.pdf');
				$page = $report->pages[0];
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
				$page->setFont($font,11);
				
				$page->drawText(Time::unixToDate($order->date),480,710);
				$page->drawText($order->id,110,697);
				$page->drawText($order->user->profile->fullname,110,685);
				$page->drawText($order->user->profile->address,110,670);

				$row = 620;
				foreach ($order->items as $item) {
					# code...
					$page->drawText($item->product->name,60,$row);
					$page->drawText($item->quantity,200,$row);
					$page->drawText( money_format('Php %5.2n', $item->product->price),320,$row);
					$page->drawText( money_format('Php %5.2n', $item->subtotal),450,$row);

					$row -= 20;
				}
				$page->drawText( money_format('Php %5.2n', $order->total),450,505);
				$page->drawText( money_format('Php %5.2n', $order->total * 0.30),450,485);

				echo $report->render();
				
			}else{
				$response->code(403);
			}
		};
	}

	
}





?>