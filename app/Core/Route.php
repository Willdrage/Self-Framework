<?php
namespace App\Core;

use ReflectionMethod;

class Route{
    // Stores all registered routes grouped by HTTP method
    private static array $routes = [];

    /**
     * Registers a GET route.
     *
     * @param string $path The route path (e.g., '/users')
     * @param array $action The controller and method (e.g., [UserController::class, 'index'])
     */
    public static function get($path, $action){
        self::$routes['GET'][$path]= $action;
    }

    /**
     * Registers a POST route.
     *
     * @param string $path The route path (e.g., '/users/store')
     * @param array $action The controller and method (e.g., [UserController::class, 'store'])
     */
    public static function post($path, $action){
        self::$routes['POST'][$path]= $action;
    }

    /**
     * Registers a PUT route.
     *
     * @param string $path The route path (e.g., '/users/store')
     * @param array $action The controller and method (e.g., [UserController::class, 'update'])
     */
    public static function put($path, $action){
        self::$routes['PUT'][$path]= $action;
    }

    /**
     * Registers resourceful routes for a controller.
     * Includes index, create, store, show, edit, update, and delete actions.
     *
     * @param string $path The base route path (e.g., '/users')
     * @param string $controller The controller class name
     * @param string $name The parameter name for resource ID (e.g., 'user')
     */
    public static function resource($path, $controller, $name){
        self::get($path.'',[$controller,'index']);
        self::get($path.'/create',[$controller,'create']);
        self::post($path.'/store',[$controller,'store']);
        self::get($path.'/{'.$name.'}',[$controller,'show']);
        self::get($path.'/{'.$name.'}/edit',[$controller,'edit']);
        self::put($path.'/{'.$name.'}/update',[$controller,'update']);
        self::post($path.'/{'.$name.'}/delete',[$controller,'delete']);
    }

    /**
     * Matches the given URI and HTTP method against the registered routes.
     * If a matching route is found, extracts route parameters and prepares arguments for the controller action.
     * Supports route parameters in the format `{param}` and automatically resolves parameters to model instances if type-hinted.
     *
     * @param string $uri The request URI to match against registered routes.
     * @param string $method The HTTP method (e.g., 'GET', 'POST') to match.
     * @return mixed Returns the result of the controller action if a route matches, or sets a 404 response code if not found.
     */
    public function getRoute($uri,$method){
        // Check if there are any routes registered for the given HTTP method
        if(!isset(self::$routes[$method])) {
            return http_response_code(404); 
        }
        //Loop through all routes registered under this HTTP method
        foreach (self::$routes[$method] as $route => $action){

            // Convert route pattern with placeholders (e.g., /user/{id})
            // into a regex pattern (e.g., /user/([^/]+))
            $pattern = preg_replace('#\{(\w+)\}#', '([^/]+)', $route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                // Extract parameter names from the original route string
                $names = [];
                if (preg_match_all('/\{(\w+)\}/', $route, $namesMatches)) {
                    $names = $namesMatches[1];// e.g., ['id', 'slug']          
                }

                // Combine parameter names with matched values
                // Example: ['id' => 42, 'slug' => 'hello']
                $assoc = array_combine($names, $matches);

                $controllerInstance = new $action[0];

                // Use reflection to inspect the controller method's parameters
                $refMethod = new ReflectionMethod($controllerInstance, $action[1]);

                $args = [];

                foreach ($refMethod->getParameters() as $param) {
                    $name = $param->getName();// Parameter name (e.g., 'id')
                    $type=$param->getType();// Parameter type hint (if any)

                    //If the parameter is a class (e.g., a model) and a matching route param exists
                    $modelClass = $type?->getName();
                    if ($type && class_exists($modelClass) && isset($assoc[$name])) {
                        $modelInstance = new $modelClass();
                        $foundObject = $modelInstance->find($assoc[$name]);
                        $args[] = $foundObject;
                    }
                }
                
                //call the controller method with all resolved arguments
                return call_user_func_array([$controllerInstance, $action[1]], $args);
            }     
        }
        return http_response_code(404); 
    }
    
    public static function listRoutes(){
        echo "<pre>";
        echo "Registered Routes:\n";
        echo "\n";
        foreach (self::$routes as $method => $routes) {
            echo "method:";
            echo $method ."\n";
            echo "\n";

            foreach ($routes as $path=> $action){
                echo "path:";
                print_r($path);
                echo "\n";
                echo "action:";
                print_r($action);
                echo "\n";
            }
        }
        echo "</pre>";
    }
}