<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\DeleteArticleRequest;

class ArticleController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function create() {
        return view('articles/create');
    }

    public function store(CreateArticleRequest $request) {
        // 비어있지 않고, 문자열이어야 하고, 255자를 넘으면 안 된다.
        $input = $request->validated();

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
        $article->load('comments.user');
        return view('articles.show', ['article' => $article]);
    }

    public function edit(EditArticleRequest $request, Article $article) {
        return view('articles.edit', ['article' => $article]);
    }

    public function update(UpdateArticleRequest $request, Article $article) {
        $input = $request->validated();

        $article->body = $input['body'];
        $article->save();

        return redirect()->route('articles.index');
    }

    public function destroy(DeleteArticleRequest $request, Article $article) {
        $article->delete();

        return redirect()->route('articles.index');
    }
}
