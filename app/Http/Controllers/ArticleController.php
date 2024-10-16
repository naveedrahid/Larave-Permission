<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view articles', ['only' => ['index']]);
    //     $this->middleware('permission:edit articles', ['only' => ['edit']]);
    //     $this->middleware('permission:create articles', ['only' => ['create']]);
    //     $this->middleware('permission:delete articles', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'author' => 'required|min:5',
        ]);

        if ($validator->passes()) {
            $article = new Article();
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            return redirect()->route('articles.index')->with('success', 'Article added successfully');
        }else{
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
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
    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'author' => 'required|min:5',
        ]);

        if ($validator->passes()) {
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            return redirect()->route('articles.index')->with('success', 'Article updated successfully');
        }else{
            return redirect()->route('articles.edit', $article)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article == null) {
            session()->flash('error', 'Article not found!');
            return response()->json([
                'status' => false,
                'message' => 'Article not found!'
            ], 404);
        }
    
        $article->delete();
    
        session()->flash('success', 'Article deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Article deleted successfully'
        ]);
    }
}
