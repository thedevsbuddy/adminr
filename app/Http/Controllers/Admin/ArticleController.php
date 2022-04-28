<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ArticleController extends Controller
{
    private $resultLimit;

    public function __construct(){
        $this->resultLimit = 10;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $articles = Article::query();
            if($request->has('title') && !is_null($request->get('title'))){
				$articles->where('title', 'LIKE', '%'.$request->get('title').'%');
			}


            $articles = $articles->paginate($this->resultLimit);

            return view('adminr.articles.index', compact('articles'));
        } catch(\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    /**
     * Return single instance of the
     * requested Model
     *
     * @param Article $article
     * @return mixed
     */
    public function show(Article $article)
    {
        try{
            return view('adminr.articles.show', compact('article'));
        } catch(\Exception $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    /**
     * Return single instance of the
     * requested Model
     *
     * @return mixed
     */
    public function create()
    {
        try{
            return view('adminr.articles.create');
        } catch(\Exception $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
				"title" => ["required", "unique:articles"],
				]);


            Article::create([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),

            ]);

            return $this->redirectSuccess(route(config('app.route_prefix').'.articles.index'), "article saved successfully!");
        } catch(\Exception $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    /**
     * Edit the requested resource
     *
     * @param Article $article
     * @return mixed
     */
    public function edit(Article $article)
    {
        try{
            return view('adminr.articles.edit', compact('article'));
        } catch(\Exception $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Article $article
     * @return mixed
     */
    public function update(Request $request, Article $article)
    {
        try{
            $request->validate([
				"title" => ["required"],
				"slug" => ["required"]
			]);


            $article->update([
                "title" => $request->get("title"),
				"slug" => Str::slug($request->get("title")),

            ]);

            return $this->redirectSuccess(route(config('app.route_prefix').'.articles.index'), "article updated successfully!");
        } catch(\Exception $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy($id)
    {
        try{
            $article = Article::findOrFail($id);


            $article->delete();
            return $this->backSuccess("article deleted successfully!");
        } catch(\Exception $e){
            return $this->backError("Error: " . $e->getMessage());
        }
    }
}
