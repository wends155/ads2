<?php

include dirname(dirname(__FILE__)) . '/lib/klein.php';

class HeadersEcho extends _Headers {
	public function header($key, $value = null) {
		echo $this->_header($key, $value) . "\n";
	}
}

_Request::$_headers = _Response::$_headers = new HeadersEcho;
