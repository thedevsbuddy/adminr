<?php

namespace Adminr\Core\Contracts;

use Illuminate\Support\Fluent;

interface AdminrMiddlewareInterface
{
    public function of(string $method): string;
    public function all(): Fluent;
}
