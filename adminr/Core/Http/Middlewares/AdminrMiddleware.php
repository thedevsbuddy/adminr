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
        $middlewareFile = File::get(resourcesPath("$this->resource/Http/Middlewares/web.json"));
        $apiMiddlewareFile = File::get(resourcesPath("$this->resource/Http/Middlewares/api.json"));

        $this->resourceMiddleware = new Fluent([
            'api' => new Fluent(json_decode($apiMiddlewareFile, true)),
            'web' => new Fluent(json_decode($middlewareFile, true)),
        ]);
    }

    public function api(?string $method = null): null|string|Fluent
    {
        if(is_null($method)) return $this->resourceMiddleware->api;
        return $this->resourceMiddleware->api->{$method} ?: 'api';
    }

    public function web(?string $method = null): null|string|Fluent
    {
        if(is_null($method)) return $this->resourceMiddleware->web;
        return $this->resourceMiddleware->web->{$method}  ?: 'web';
    }

}
