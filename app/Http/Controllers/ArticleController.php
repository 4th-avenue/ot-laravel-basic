<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function create() {
        return view('articles/create');
    }

    public function store(Request $request) {
        // 비어있지 않고, 문자열이어야 하고, 255자를 넘으면 안 된다.
        $input = $request->validate([
            'body' => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        Article::create([
            'body' => $input['body'],
            'user_id' => Auth::id()
        ]);
        
        return redirect()->route('articles.index');
    }

    public function index(Request $request) {
        $perPage = $request->input('per_page', 3);

        $articles = Article::with('user')
        ->latest()
        ->paginate($perPage);
        
        return view(
            'articles.index',
            [
                'articles' => $articles
            ]
        );
    }

    public function show(Article $article) {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article) {
        $this->authorize('update', $article);

        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, Article $article) {
        $this->authorize('update', $article);

        // 비어있지 않고, 문자열이어야 하고, 255자를 넘으면 안 된다.
        $input = $request->validate([
            'body' => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        $article->body = $input['body'];
        $article->save();

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article) {
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()->route('articles.index');
    }
}
