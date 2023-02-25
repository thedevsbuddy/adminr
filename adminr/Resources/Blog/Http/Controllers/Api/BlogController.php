<?php

namespace Adminr\Resource\Blog\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog::index');
    }
}
