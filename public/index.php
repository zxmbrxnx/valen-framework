<?php

use Valen\Http\HttpNotFoundException;
use Valen\Http\Request;
use Valen\Routing\Router;
use Valen\Server\PhpNativeServer;

require_once "../vendor/autoload.php";



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