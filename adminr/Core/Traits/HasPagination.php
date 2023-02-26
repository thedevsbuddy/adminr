<?php

namespace Adminr\Core\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasPagination
{
    public function scopePaginated($builder): static
    {
        $page = request()->has('page') ? request()->get('page') : 1;
        $limit = request()->has('limit') ? request()->get('limit') : 10;
        return $builder->limit($limit)->offset(($page - 1) * $limit)->get();
    }
}
