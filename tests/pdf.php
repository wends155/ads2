<?php 
require_once "../db/general.php";
$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once "Zend/Pdf.php";

//$response->header('Content-Type','application/pdf');
				
				$stocks_report = Zend_Pdf::load('../pdf/inv.pdf');
				$page = $stocks_report->pages[0];
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
				$page->setFont($font,11);
				//echo "Height = {$page->getHeight()} \n";
				//echo "Width  = {$page->getWidth()} \n";
				
				$page->drawText("as of " . Time::unixToDate(time()), 100,100);
				
				echo $stocks_report->save('test.pdf');




?>

