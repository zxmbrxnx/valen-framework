<?php

require_once "../vendor/autoload.php";

use Valen\HttpNotFoundException;
use Valen\PhpNativeServer;
use Valen\Request;
use Valen\Router;

$router = new Router;

$router->get('/test', function(){
    return "GET OK";
});

$router->post('/test', function(){
    return "POST OK";
});

try {
    $route = $router->resolve(new Request(new PhpNativeServer()));
    $action = $route->action();
    print($action());
} catch (HttpNotFoundException $e) {
    print("Not found");
    http_response_code(404);
}