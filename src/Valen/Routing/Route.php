<?php

namespace Valen\Routing;

class Route {

    protected string $uri;
    protected \Closure $action;
    protected string $regex;
    protected array $parameters;

    /**
     * It takes a string and a closure and assigns them to the properties `uri` and `action`
     * respectively.
     * 
     * The `` parameter is a string that represents the URI of the route. The `` parameter
     * is a closure that represents the action to be performed when the route is matched.
     * 
     * The `` property is a regular expression that is used to match the route. The ``
     * property is an array of the parameters that are present in the route.
     * 
     * The `` property is created by replacing the curly braces in the `` property with a
     * regular expression that matches any alphanumeric character.
     * 
     * The `` property is created by matching the curly braces in the `` property.
     * 
     * The `` property is used to match the route. The ``
     * 
     * @param string uri The URI that the route will be listening for.
     * @param \Closure action The function that will be called when the route is matched.
     */
    public function __construct(string $uri, \Closure $action) {
        $this->uri = $uri;
        $this->action = $action;
        $this->regex = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9]+)', $uri);

        preg_match_all('/\{([a-zA-Z]+)\}/', $uri, $parameters);
        $this->parameters = $parameters[1];
    }

    public function uri(){
        return $this->uri;
    }

    public function action(){
        return $this->action;
    }

    public function matches(string $uri): bool {
        return preg_match("#^$this->regex/?$#", $uri);
    }

    public function hasParameters(): bool {
        return count($this->parameters) > 0;
    }

    public function parseParameters(string $uri): array {
        preg_match("#^$this->regex$#", $uri, $arguments);
        return array_combine($this->parameters, array_slice($arguments, 1));
    }
}