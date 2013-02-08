<?php 
	$ctx = new ZMQContext();
	$push = new ZMQSocket($ctx, ZMQ::SOCKET_PUSH);
	$endpoint = "tcp://184.164.136.144:5566";
	$push->connect($endpoint);
	$data = array('id' => time(),
					'number' => '09186709817',
					'message' => 'test from php'
		);
	$push->send(json_encode($data));
	echo json_encode($data);
?>
