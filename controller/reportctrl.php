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

	public static function inventory(){
		return function($request,$response){
			if($request->session('admin')){
				try{
					$response->header('Content-Type','application/pdf');
					
					$stocks_report = Zend_Pdf::load('../pdf/inv.pdf');
					$page = $stocks_report->pages[0];
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
					$page->setFont($font,10);
					$page->drawText(Time::unixToDate(time()), 290, 818);

					$row = 765;
					$stocks = Stock::all();
					foreach ($stocks as $stock) {
						$page->drawText(sprintf("%10.39s",$stock->product->name), 32, $row);
						$page->drawText($stock->product->description, 280, $row);
						$page->drawText(sprintf("%4u", $stock->quantity), 550, $row);
					
						$row -= 15;
					}
					$page->drawText("Prepared by:",300,80);
					$page->drawText("________________________________", 300, 50);

					echo $stocks_report->render();
				} catch(Exception $e){
					$response->header('Content-Type','text/plain');
					echo $e->getMessage();
				}
			}else{
				$response->code(403);
			}
		};
	}
	
	public static function monthly(){
		return function($request,$response){
			if($request->session('admin')){
				try{
					$response->header('Content-Type','application/pdf');
					
					$stocks_report = Zend_Pdf::load('../pdf/monthly.pdf');
					$page = $stocks_report->pages[0];
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
					$page->setFont($font,11);
					$page->drawText(Time::unixToDate(time()), 290, 818);				
					echo $stocks_report->render();
				} catch(Exception $e){
					$response->header('Content-Type','text/plain');
					echo $e->getMessage();
				}
			}else{
				$response->code(403);
			}
		};
	}
	
	public static function weekly(){
		return function($request,$response){
			if($request->session('admin')){
				try{
					$response->header('Content-Type','application/pdf');
					
					$stocks_report = Zend_Pdf::load('../pdf/weekly.pdf');
					$page = $stocks_report->pages[0];
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
					$page->setFont($font,11);
					$page->drawText(Time::unixToDate(time()), 290, 818);				
					echo $stocks_report->render();
				} catch(Exception $e){
					$response->header('Content-Type','text/plain');
					echo $e->getMessage();
				}
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
				$report = Zend_Pdf::load('../pdf/trustrec.pdf');
				$page = $report->pages[0];
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
				$page->setFont($font,11);
				
				$page->drawText(Time::unixToDate(time()),460,900);
				$page->drawText(Time::unixToDate(time()),460,455);
				$page->drawText('Order#: ' . $order->id,400,910);
				$page->drawText('Order#: ' . $order->id,400,465);
				$page->drawText($order->user->profile->fullname,100,900);
				$page->drawText($order->user->profile->fullname,100,455);
				$page->drawText($order->user->profile->address,440,530);
				$page->drawText($order->user->profile->address,440,85);
				$page->drawText($order->user->profile->fullname,445,555);
				$page->drawText($order->user->profile->fullname,445,109);

				$row = 850;

				foreach ($order->items as $item) {
					# code...
					$page->drawText($item->product->name,80,$row);
					$page->drawText($item->product->name,80,$row-446);
					$page->drawText($item->quantity,45,$row);
					$page->drawText($item->quantity,45,$row-446);
					$page->drawText( money_format('%5.2n', $item->product->price),315,$row);
					$page->drawText( money_format('Php %5.2n', $item->subtotal),370,$row);
					$page->drawText( money_format('%5.2n', $item->product->price),315,$row-446);
					$page->drawText( money_format('Php %5.2n', $item->subtotal),370,$row-446);

					$row -= 17;
				}
				$page->drawText( money_format('Php %5.2n', $order->total),370,562);
				$page->drawText( money_format('Php %5.2n', $order->total),370,118);
				#$page->drawText( money_format('Php %5.2n', $order->total * 0.30),450,485);

				echo $report->render();
				
			}else{
				$response->code(403);
			}
		};
	}

	
}





?>
