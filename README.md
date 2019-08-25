# simple-router
The simple router PHP

## include
```php
require_once "router.php";
```
## usage
```php
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
$route->option('/',function(){
	echo 'OPTION method';
});
```
## data in router
```php
$route->get('/post/{id}',function($data){
	echo 'This is post page and id = '.$data['id'];
});
```
## return view
```php
function loadView($view){
	echo file_get_contents($view);
}
$route->get('/',function(){
	loadView('./dir_name');
});
```
## listen (run)
```php
$route->listen();
```

## set callback when error(404)
```php
$route->setCallbackError(function(){
	loadView('./404.php');
});
```
## run server
```
php -S localhost:8000
-> open localhost:8000
```



