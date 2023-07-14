<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 3);

        $articles = Article::with('user')
        ->withCount('comments')
        ->withExists(['comments' => function ($query) {
            $query->where('created_at', '>', Carbon::now()->subDay());
        }])
        ->when(Auth::check(), function($query) {
            $query->whereHas('user', function(Builder $query) {
                $query->whereIn('id', Auth::user()->followings->pluck('id')->push(Auth::id()));
            });
        })
        ->latest()
        ->paginate($perPage);
        
        return view(
            'articles.index',
            [
                'articles' => $articles
            ]
        );
    }
}
