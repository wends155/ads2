<?php

require_once dirname(__FILE__) . '/setup.php';

class RoutesTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		global $__routes;
		$__routes = array();

		global $__namespace;
		$__namespace = null;

		$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
	}

	public function testBasic() {
		$this->expectOutputString( 'x' );

		respond( '/', function(){ echo 'x'; });
		respond( '/something', function(){ echo 'y'; });
		dispatch( '/' );
	}

	
}
