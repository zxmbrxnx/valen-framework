<?php

namespace Valen;

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
     * If the request method and URI are found in the routes array, return the action. Otherwise, throw
     * an exception.
     * 
     * @return The action is being returned.
     */
    public function resolve(string $uri, string $method){

        $action = $this->routes[$method][$uri] ?? null;

        if (is_null($action)) {
            throw new HttpNotFoundException();
        }

        return $action;
    }

    public function get(String $uri, callable $action){
        $this->routes[HttpMethod::GET->value][$uri] = $action;
    }

    public function post(String $uri, callable $action){
        $this->routes[HttpMethod::POST->value][$uri] = $action;
    }

    public function put(String $uri, callable $action){
        $this->routes[HttpMethod::PUT->value][$uri] = $action;
    }

    public function patch(String $uri, callable $action){
        $this->routes[HttpMethod::PATCH->value][$uri] = $action;
    }

    public function delete(String $uri, callable $action){
        $this->routes[HttpMethod::DELETE->value][$uri] = $action;
    }
}