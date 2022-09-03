<?php

namespace Valen\Test;

use PHPUnit\Framework\TestCase;
use Valen\HttpMethod;
use Valen\Request;
use Valen\Router;

class RouterTest extends TestCase {
    
    /**
     * "It should return the callback action when the route is resolved."
     * 
     * The first thing we do is create a URI and an action. The URI is the route we want to test and
     * the action is the callback function we want to execute when the route is resolved.
     * 
     * Next, we create a new instance of the Router class and add the route to it.
     * 
     * Finally, we assert that the action we passed to the router is the same as the one returned when
     * we resolve the route.
     */
    public function test_resolve_basic_route_with_callback_action() {
        $uri = "/test";
        $action = fn () => "test";

        $router = new Router();
        $router->get($uri, $action);

        $route = $router->resolve(new Request(new MockServer($uri, HttpMethod::GET)));
        $this->assertEquals($action, $route->action());
        $this->assertEquals($uri, $route->uri());
    }

    /**
     * It tests that the router can resolve multiple basic routes with callback actions.
     */
    public function test_resolve_multiple_basic_route_with_callback_action() {
        $routes = [
            "/test" => fn () => "test",
            "/foo" => fn () => "foo",
            "/bar" => fn () => "bar",
            "/long/nested/route" => fn () => "long nested route",
        ];

        $router = new Router();

        foreach ($routes as $uri => $action) {
            $router->get($uri, $action);
        }

        foreach ($routes as $uri => $action) {
            $route = $router->resolve(new Request(new MockServer($uri, HttpMethod::GET)));
            $this->assertEquals($action, $route->action());
            $this->assertEquals($uri, $route->uri());
        }
    }

    /**
     * It tests that the router can resolve multiple basic routes with callback actions for different
     * HTTP methods
     */
    public function test_resolve_multiple_basic_route_with_callback_action_for_diferent_http_methods(){
        $routes = [
            [HttpMethod::GET, "/test", fn () => "get"],
            [HttpMethod::POST, "/test", fn () => "post"],
            [HttpMethod::PUT, "/test", fn () => "put"],
            [HttpMethod::PATCH, "/test", fn () => "patch"],
            [HttpMethod::DELETE, "/test", fn () => "delete"],

            [HttpMethod::GET, "/random/get", fn () => "get"],
            [HttpMethod::POST, "/test/random", fn () => "post"],
            [HttpMethod::PUT, "/test/some/put", fn () => "put"],
            [HttpMethod::PATCH, "/test/patch/route", fn () => "patch"],
            [HttpMethod::DELETE, "/d", fn () => "delete"]
        ];

        $router = new Router();

        foreach ($routes as [$method,$uri,$action]) {
            $router->{strtolower($method->value)}($uri, $action);
        }

        foreach ($routes as [$method,$uri,$action]) {
            $route = $router->resolve(new Request(new MockServer($uri, $method)));
            $this->assertEquals($action, $route->action());
            $this->assertEquals($uri, $route->uri());
        }
    }
}