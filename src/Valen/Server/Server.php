<?php

namespace Valen\Server;

use Valen\Http\HttpMethod;

interface Server {
    public function requestUri(): string;
    public function requestMethod(): HttpMethod;
    public function postData(): array;
    public function queryParams(): array;
}
