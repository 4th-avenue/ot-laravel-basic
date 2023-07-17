<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Article;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use Illuminate\Database\Eloquent\Builder;

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

        $q = $request->input('q');

        $articles = Article::with('user')
        ->withCount('comments')
        ->withExists(['comments' => function ($query) {
            $query->where('created_at', '>', Carbon::now()->subDay());
        }])
        ->when($q, function ($query, $q) {
            $query->where('body', 'like', "%$q%")
            ->orWhereHas('user', function (Builder $query) use ($q) {
                $query->where('username', 'like', "%$q%");
            });
        })
        ->latest()
        ->paginate($perPage);
        
        return view(
            'articles.index',
            [
                'articles' => $articles,
                'q' => $q
            ]
        );
    }

    public function show(Article $article) {
        $article->load('comments.user');
        $article->loadCount('comments');

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
