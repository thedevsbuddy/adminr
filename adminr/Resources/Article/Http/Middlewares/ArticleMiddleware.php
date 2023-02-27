<?php

namespace Adminr\Resources\Article\Http\Middlewares;

use Adminr\Core\Http\Middlewares\AdminrMiddleware;

class ArticleMiddleware extends AdminrMiddleware
{
    protected string $resource = 'Article';

    // Its magic
}
