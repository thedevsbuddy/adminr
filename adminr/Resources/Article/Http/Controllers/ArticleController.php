<?php

namespace Adminr\Resources\Article\Http\Controllers;

use Adminr\Resources\Article\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Adminr\Core\Http\Controllers\AdminrBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Adminr\Resources\Article\Http\Requests\{CreateArticleRequest,UpdateArticleRequest};


class ArticleController extends AdminrBaseController
{
    public function index(Request $request): View|RedirectResponse
    {
        try {
            $articles = Article::query()->when(!is_null(request()->get('_title')), function($query){
                $query->where('title', 'LIKE', '%'.request()->get('_title').'%');
            })->paginate(10);
            return view('adminr.articles.index', compact('articles'));
        } catch(\Exception | \Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function show(Article $article): View|RedirectResponse
    {
        try{
            return view('adminr.articles.show', compact('article'));
        } catch(\Exception | \Error $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    public function create(): View|RedirectResponse
    {
        try{

            return view('adminr.articles.create');
        } catch(\Exception | \Error $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    public function store(CreateArticleRequest $request): RedirectResponse
    {
        try{
            if($request->hasFile("featured_image")){
                $featured_image = $this->uploadFile($request->file("featured_image"), "articles")->getFilePath();
			} else {
				return $this->backError("Please select an image for Featured Image");
			}

            Article::create([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),
				"user_id" => auth()->id(),
				"featured_image" => $featured_image,

            ]);

            return $this->redirectSuccess(route('adminr.articles.index'), "Article saved successfully!");
        } catch(\Exception | \Error $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    public function edit(Article $article): View|RedirectResponse
    {
        try{

            return view('adminr.articles.edit', compact('article'));
        } catch(\Exception | \Error $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        try{
            if($request->hasFile("featured_image")){
				$featured_image = $this->uploadFile($request->file("featured_image"), "articles")->getFilePath();
				$this->deleteStorageFile($article->featured_image);
			} else {
				$featured_image = $article->featured_image;
			}

            $article->update([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),
				"user_id" => auth()->id(),
				"featured_image" => $featured_image,

            ]);

            return $this->redirectSuccess(route( 'adminr.articles.index'), "article updated successfully!");
        } catch(\Exception | \Error $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try{
            $article = Article::findOrFail($id);

            $this->deleteStorageFile($article->featured_image);

            $article->delete();
            return $this->backSuccess("article deleted successfully!");
        } catch(\Exception | \Error $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }
}
