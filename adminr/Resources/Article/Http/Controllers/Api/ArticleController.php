<?php

namespace Adminr\Resources\Article\Http\Controllers\Api;

use Adminr\Resources\Article\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Adminr\Core\Http\Controllers\AdminrBaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Adminr\Resources\Article\Http\ApiResources\ArticleResource;
use Adminr\Resources\Article\Http\Requests\{CreateArticleRequest,UpdateArticleRequest};

class ArticleController extends AdminrBaseApiController
{
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try{
            $articles = Article::query()->when(!is_null(request()->get('_title')), function($query){
                $query->where('title', 'LIKE', '%'.request()->get('_title').'%');
            })->paginated()->get();
            return ArticleResource::collection($articles);
        } catch(\Exception | \Error $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function show(Article $article): ArticleResource|JsonResponse
    {
        try{
            return new ArticleResource($article);
        } catch(\Exception | \Error $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function store(CreateArticleRequest $request): JsonResponse
    {
        try{
            if($request->hasFile("featured_image")){
				$featured_image = $this->uploadFile($request->file("featured_image"), "articles")->getFilePath();
			} else {
				return $this->error("Please select an image for Featured Image");
			}

            $article = Article::create([
                "title" => $request->get("title"), 
				"slug" => Str::slug($request->get("title")), 
				"user_id" => auth()->id(), 
				"featured_image" => $featured_image, 
				
            ]);

            return $this->success(["message" => "article created successfully!", "data" => $article], 201);
        } catch(\Exception | \Error $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        try{
            if($request->hasFile("featured_image")){
				$featured_image = $this->uploadFile($request->file("featured_image"), "articles")->getFilePath();
				$this->deleteStorageFile($article->featured_image);
			} else {
				$featured_image = $article->featured_image;
			}

            $article = $article->update([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),
				"user_id" => auth()->id(),
				"featured_image" => $featured_image,
				
            ]);

            return $this->success(["message" => "article updated successfully!", "data" => $article], 201);
        } catch(\Exception | \Error $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try{
            $article = Article::findOrFail($id);
            $this->deleteStorageFile($article->featured_image);
			
            $article->delete();

            return $this->successMessage("article deleted successfully!");
        } catch(\Exception | \Error $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }
}
