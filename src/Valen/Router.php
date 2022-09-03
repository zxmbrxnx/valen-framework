<?php

namespace Valen;

use Closure;

class Router{

    protected array $routes = [];

    /**
     * It creates an array of arrays, where each array is a list of routes for a given HTTP method.
     */
    public function __construct(){
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    /**
     * It loops through the routes array, and if the route matches the uri, it returns the route.
     * 
     * @param string uri The URI that was requested.
     * @param string method The HTTP method of the request.
     * 
     * @return The route object.
     */
    public function resolve(string $uri, string $method){
        foreach ($this->routes[$method] as $route) {
            if ($route->matches($uri)) {
                return $route;
            }
        }
        throw new HttpNotFoundException();
    }

    /**
     * It takes a HTTP method, a URI, and a closure, and adds it to the routes array.
     * 
     * @param HttpMethod method The HTTP method of the request.
     * @param string uri The URI to be matched.
     * @param Closure action The closure that will be executed when the route is matched.
     */
    protected function registerRoute(HttpMethod $method, string $uri, Closure $action){
        $this->routes[$method->value][] = new Route($uri, $action);
    }

    public function get(String $uri, Closure $action){
        $this->registerRoute(HttpMethod::GET, $uri, $action);
    }

    public function post(String $uri, Closure $action){
        $this->registerRoute(HttpMethod::POST, $uri, $action);
    }

    public function put(String $uri, Closure $action){
        $this->registerRoute(HttpMethod::PUT, $uri, $action);
    }

    public function patch(String $uri, Closure $action){
        $this->registerRoute(HttpMethod::PATCH, $uri, $action);
    }

    public function delete(String $uri, Closure $action){
        $this->registerRoute(HttpMethod::DELETE, $uri, $action);
    }
}