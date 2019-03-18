<?php

header('Content-Type: application/json');

if( $_SERVER['REQUEST_METHOD'] != "POST" ) {
	echo json_encode(['error'=>'Method Not Allowed ','code'=>404]);
	die();
}

if( !isset( $_SERVER['HTTP_X_AUTH'] )  ) {
	echo json_encode(['error'=>'Access Not Allowed','code'=>404]);
	die();
}

if ( $_SERVER['HTTP_X_AUTH'] != "gSMQwxJQYFspbzKbNPc3WcRXeA4SvEPj" ) {
	echo json_encode(['error'=>'invalid api key','code'=>404]);
	die();
}