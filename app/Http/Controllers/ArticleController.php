<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view article', only: ['index']),
            new Middleware('permission:edit article', only: ['edit']),
            new Middleware('permission:create article', only: ['create']),
            new Middleware('permission:delete article', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Auth::user()->hasRole('super-admin') ? $articles = Article::query()->latest()
            ->orderBy('created_at','desc')->paginate(10) :
        $articles = Article::query()->latest()
            ->where('author', Auth::id())
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(),[
            'title' => 'required|min:5|unique:articles,title',
            'body'  => 'required'
        ]);
        if($validate->passes()){
            $article = new Article();
            $article->title = $request->title;
            $article->body = $request->body;
            $article->author = Auth::user()->id;
            $article->save();

            return redirect()->route('articles.index')->with('success','Article created successfully');
        }else{
            return redirect()->route('articles.create')->withInput()->withErrors($validate);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $validate = Validator::make($request->all(),[
            'title' => 'required|min:5|unique:articles,title',
            'body'  => 'required'
        ]);
        if($validate->passes()){
            $article->title = $request->title;
            $article->body = $request->body;
            Auth::user()->hasRole('super-admin') ? $article->update() : $article->author = Auth::id();
            $article->update();

            return redirect()->route('articles.index')->with('success','Article updated successfully');
        }else{
            return redirect()->route('articles.edit',$id)->withInput()->withErrors($validate);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $article = Article::find($request->id);
        if($article == null){
            session()->flash('error','Article not found');
            return response()->json([
                'status' => false
            ]);
        }
        $article->delete();
        session()->flash('success','Article deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
