<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use Devsbuddy\AdminrEngine\Http\Controllers\AdminrController;
use Devsbuddy\AdminrEngine\Traits\HasResponse;
use Illuminate\Support\Str;

class ArticleController extends AdminrController
{
    use HasResponse;

    private $resultLimit;

    public function __construct(){
        $this->resultLimit = 10;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $articles = Article::query();

            if($request->has('title') && !is_null($request->get('title'))){
				$articles->where('title', 'LIKE', '%'.$request->get('title').'%');
			}
			

            $articles = $articles->limit($limit)->offset(($page - 1) * $limit)->get();

            return $this->success($articles);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Return single instance of the requested resource
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Article $article)
    {
        try{
            return $this->success($article);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
				"title" => ["required", "unique:articles"],
				]);

            
            $article = Article::create([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),
				
            ]);

            return $this->success($article, 201);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Update resource.
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Article $article)
    {
        try{
            $request->validate([
				"title" => ["required"],
				"slug" => ["required"]
			]);

            
            $article = $article->update([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),
				
            ]);

            return $this->success($article, 201);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            $article = Article::findOrFail($id);
            
            $article->delete();

            return $this->successMessage("article deleted successfully!");
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }
}
