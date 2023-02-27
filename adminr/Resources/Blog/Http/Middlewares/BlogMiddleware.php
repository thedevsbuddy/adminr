<?php

namespace Adminr\Resources\Blog\Http\Middlewares;

use Adminr\Core\Contracts\AdminrMiddlewareInterface;
use Adminr\Core\Http\Middlewares\AdminrMiddleware;

class BlogMiddleware extends AdminrMiddleware implements AdminrMiddlewareInterface
{
    protected string $resource = 'Blog';

    public function get(string $method): string
    {
        return $this->resourceMiddleware->{$method};
    }
}
