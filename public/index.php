<?php

require_once "../vendor/autoload.php";

use Valen\HttpNotFoundException;
use Valen\Router;

$router = new Router;

$router->get('/test', function(){
    return "GET OK";
});

$router->post('/test', function(){
    return "POST OK";
});

try {
    $action = $router->resolve();
    print($action());
} catch (HttpNotFoundException $e) {
    print("Not found");
    http_response_code(404);
}