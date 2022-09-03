<?php

namespace Valen\Test;

use PHPUnit\Framework\TestCase;
use Valen\Route;

class RoutesTest extends TestCase{

    public function routesWithNoParameters(){
        return [
            ['/'],
            ['/test'],
            ['/test/nested'],
            ['/test/another/nested'],
            ['/test/another/nested/route'],
            ['/test/another/nested/very/nested/route'],
        ];
    }
    /**
     *@dataProvider routesWithNoParameters
     */
    public function test_regex_with_no_parameters(string $uri){
        $route = new Route($uri, fn () => "test");
        $this->assertTrue($route->matches($uri));
        $this->assertFalse($route->matches("$uri/extra/patch"));
        $this->assertFalse($route->matches("/extra/patch/$uri"));
        $this->assertFalse($route->matches("/random/route"));
    }

    /**
     *@dataProvider routesWithNoParameters
     */
    public function test_regex_on_uri_that_ends_with_slash($uri){
        $route = new Route($uri, fn () => "test");
        $this->assertTrue($route->matches("$uri/"));
    }

    public function routesWithParameters(){
        return [
            [
                '/test/{test}', 
                '/test/1',
                ['test' => 1],
            ],
            [
                '/user/{user}', 
                '/user/6',
                ['user' => 6],
            ],
            [
                '/test/{test}', 
                '/test/string',
                ['test' => "string"]
            ],
            [
                '/test/nested/{test}', 
                '/test/nested/4',
                ['test' => 4],
            ],
            [
                '/test/{param}/long/{test}/with/{multiple}/params', 
                '/test/18/long/test/with/string/params',
                ['param' => 18, 'test' => 'test', 'multiple' => 'string'],
            ],
        ];
    }

    /**
     *@dataProvider routesWithParameters
     */
    public function test_regex_with_parameters(string $definition, string $uri){
        $route = new Route($definition, fn () => "test");
        $this->assertTrue($route->matches($uri));
        $this->assertFalse($route->matches("$uri/extra/patch"));
        $this->assertFalse($route->matches("/extra/patch/$uri"));
        $this->assertFalse($route->matches("/random/route"));
    }

    /**
     *@dataProvider routesWithParameters
     */    
    public function test_parse_parameters(string $definition, string $uri, array $expectedParameters){
        $route = new Route($definition, fn () => "test");

        $this->assertTrue($route->hasParameters());
        $this->assertEquals($expectedParameters, $route->parseParameters($uri));
    }
}
