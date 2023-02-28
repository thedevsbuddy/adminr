<?php

namespace Adminr\Core\Contracts;

use Illuminate\Support\Fluent;

interface AdminrMiddlewareInterface
{
    public function api(string $method): null|string|Fluent;
    public function web(string $method): null|string|Fluent;
}
