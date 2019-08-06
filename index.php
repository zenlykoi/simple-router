<?php

require_once "router.php";

function loadView($view){
	echo file_get_contents($view);
}

$route = new router;
$route->get('/',function(){
	echo 'GET method';
});
$route->post('/',function(){
	echo 'POST method';
});
$route->put('/',function(){
	echo 'PUT method';
});
$route->patch('/',function(){
	echo 'PATCH method';
});
$route->delete('/',function(){
	echo 'DELETE method';
});

// $route->setCallbackError(function(){
// 	loadView('./404.php');
// });
$route->listen();