<?php

namespace Adminr\Core\Http\Middlewares;

use Adminr\Core\Contracts\AdminrMiddlewareInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;

class AdminrMiddleware implements AdminrMiddlewareInterface
{
    protected string $resource = '';
    protected Fluent $resourceMiddleware;

    public function __construct()
    {
        $middlewareFile = File::get(resourcesPath("$this->resource/Http/Middlewares/api.json"));
        $this->resourceMiddleware = new Fluent(json_decode($middlewareFile));
    }

    public function of(string $method): string
    {
        return $this->resourceMiddleware->{$method};
    }

    public function all(): Fluent
    {
        return $this->resourceMiddleware;
    }
}
