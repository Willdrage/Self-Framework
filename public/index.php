<?php

use App\Core\Route;

define('ROOT', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
require_once(ROOT.'config/config.php');
require_once(ROOT.'autoload.php');
require_once(ROOT.'routes/web.php');



function route(string $path = '', $params = []) {
    $finalParams= [];
    preg_match_all('#{(\w+)}#', $path, $match);
    if (is_object($params)) {
        $modelName = $match[1][0] ?? 'model';
        $finalParams = [$modelName => $params->id];
    } 
    elseif (is_array($params)) {
        $i=0;
        foreach ($params as $param=>$value) {
            if (is_object($value)){
                $modelName = $match[1][$i] ?? 'model';
                $param = $modelName;
                $value=$value->id;
                $i+=1;
            } 
            $finalParams[$param]= $value;
        }
    }

    foreach ($finalParams as $key=>$value){
        $path = str_replace("{" . $key . "}", $value, $path);
    }
    $url= ROUTE_URL.$path;
    return $url;
}

$requestUri= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = str_replace(URL_SUBFOLDER, '', $requestUri);

$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new Route();
$router->getRoute($requestUri, $requestMethod);