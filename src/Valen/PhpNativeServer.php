<?php

namespace Valen;

class PhpNativeServer implements Server{

    public function requestUri(): string {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function requestMethod(): HttpMethod {
        return HttpMethod::from($_SERVER['REQUEST_METHOD']);
    }

    public function postData(): array {
        return $_POST;
    }
    
    public function queryParams(): array {
        return $_GET;
    }
}
