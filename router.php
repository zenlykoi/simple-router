<?php
/**
 * @name : Simple router
 * @description : The simple router
 * @author : Nguyen Phuong(NP)
 * @version : 0.1.0
 */
class router {
    /**
     * @name : pathName
     * @type : variable(string)
     * @description : your path
     */
    private $pathName;
    /**
     * @name : routes
     * @type : variable(array)
     * @description : store all route
     */
    private $routes = [];
    /**
     * @name : requestMethod
     * @type : variable(string)
     * @description : request method -> $_SERVER['REQUEST_METHOD']
     */
    private $requestMethod;
    /**
     * @name : callbackError
     * @type : variable(function - Closure Object)
     * @description : call when error (404)
     */
    private $callbackError;
    /**
     * @name : error
     * @type : variable(boolean)
     */
    private $error;
    /**
     * @name : __construct
     * @type : function (constructor)
     * @description : call when router initialization
     * @functional :
     *      - assign path
     *      - assign request method
     */
    function __construct(){
        $this->assignPath();
        $this->assignRequestMethod();
    }
    /**
     * @name : assignPath
     * @type : function
     * @description : call in __construct function
     * @functional :
     *      - assign path
     */
    private function assignPath(){
        $this->pathName = $_SERVER['PATH_INFO'];
        $this->pathName = (!isset($_SERVER['PATH_INFO'])) ? '/' : $this->pathName;
        $this->pathName = ($this->pathName[strlen($this->pathName)-1] == '/' && $this->pathName != '/') ? substr($this->pathName,0,strlen($this->pathName)-1) : $this->pathName;
        $this->error = true;
    }
    /**
     * @name : assignRequestMethod
     * @type : function
     * @description : call in __construct function
     * @functional :
     *      - assign request method
     */
    private function assignRequestMethod(){
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
    /**
     * @name : assignRoutes
     * @type : function
     * @description : call when run request method(get,post,put,...) function
     * @params :
     *      - $route : your route you want store
     * @functional :
     *      - push $route to $this->routes
     */
    private function assignRoutes($route){
        array_push($this->routes,$route);
    }
    /**
     * @name : get
     * @type : function
     * @description : store route get
     * @params :
     *      - $route : your route you want store
     *      - $callback : run with route corresponding
     * @functional :
     *      - define route
     */
    public function get($path,$callback){
        $this->assignRoutes([
            'method' => 'GET',
            'path' => $path,
            'callback' => $callback
        ]);
    }
    /**
     * @name : post
     * @type : function
     * @description : store route post
     * @params :
     *      - $route : your route you want store
     *      - $callback : run with route corresponding
     * @functional :
     *      - define route
     */
    public function post($path,$callback){
        $this->assignRoutes([
            'method' => 'POST',
            'path' => $path,
            'callback' => $callback
        ]);
    }
    /**
     * @name : put
     * @type : function
     * @description : store route put
     * @params :
     *      - $route : your route you want store
     *      - $callback : run with route corresponding
     * @functional :
     *      - define route
     */
    public function put($path,$callback){
        $this->assignRoutes([
            'method' => 'PUT',
            'path' => $path,
            'callback' => $callback
        ]);
    }
    /**
     * @name : patch
     * @type : function
     * @description : store route patch
     * @params :
     *      - $route : your route you want store
     *      - $callback : run with route corresponding
     * @functional :
     *      - define route
     */
    public function patch($path,$callback){
        $this->assignRoutes([
            'method' => 'PATCH',
            'path' => $path,
            'callback' => $callback
        ]);
    }
    /**
     * @name : delete
     * @type : function
     * @description : store route delete
     * @params :
     *      - $route : your route you want store
     *      - $callback : run with route corresponding
     * @functional :
     *      - define route
     */
    public function delete($path,$callback){
        $this->assignRoutes([
            'method' => 'DELETE',
            'path' => $path,
            'callback' => $callback
        ]);
    }
    /**
     * @name : option
     * @type : function
     * @description : store route option
     * @params :
     *      - $route : your route you want store
     *      - $callback : run with route corresponding
     * @functional :
     *      - define route
     */
    public function option($path,$callback){
        $this->assignRoutes([
            'method' => 'OPTION',
            'path' => $path,
            'callback' => $callback
        ]);
    }
    /**
     * @name : setCallbackError
     * @type : function
     * @description : define callback when error(404)
     * @params :
     *      - $callback : run with route corresponding
     */
    public function setCallbackError($callback){
        $this->callbackError = $callback;
    }
    /**
     * @name : renderWhenError
     * @type : function
     * @description : run callback when error
     */
    private function renderWhenError(){
        if($this->error == true){
            echo "<pre>Cannot $this->requestMethod $this->pathName</pre>";
        }if($this->error == true && $this->callbackError){
            ($this->callbackError)();
        }
    }
    /**
     * @name : routePathToArray
     * @type : function
     * @param : path of route
     * @description : convert path of route to array
     */
    private function routePathToArray($routePath){
        $result = explode('/',$routePath);
        array_shift($result);
        $result[0] = ($result[0] == '') ? '/' : $result[0];
        return $result;
    }
    /**
     * @name : routePathToArray
     * @type : function
     * @param : 
     *      - routePath : path of route
     *      - path : pathName
     * @description : compare route
     */
    private function compareRoute($routePath,$path){
        $arrayRoutePath = $this->routePathToArray($routePath);
        $arrayPath = $this->routePathToArray($path);
        if(count($arrayRoutePath) == count($arrayPath)){
            $result = [];
            for($i=0; $i<count($arrayRoutePath); $i++){
                if($arrayRoutePath[$i][0] != '{' && $arrayRoutePath[$i] != $arrayPath[$i]){
                    return false;
                }
                if($arrayRoutePath[$i][0] == '{'){
                    $result[rtrim(ltrim($arrayRoutePath[$i],'{'),'}')] = $arrayPath[$i];
                }
            }
            if(count($result) == 0){
                return true;
            }
            return $result;
        }
        return false;
    }
    /**
     * @name : checkRoute
     * @type : function
     * @description : check route
     */
    private function checkRoute($i){
        if($this->routes[$i]['method'] == $this->requestMethod && $this->compareRoute($this->routes[$i]['path'],$this->pathName) != false){
            $this->routes[$i]['callback']($this->compareRoute($this->routes[$i]['path'],$this->pathName));
            $this->error = false;
        }
    }
    /**
     * @name : listen
     * @type : function
     * @description : listening...
     */
    public function listen(){
        for($i = 0; $i < count($this->routes); $i++){
            $this->checkRoute($i);
        }
        $this->renderWhenError();
    }
}
