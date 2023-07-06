<?php

use App\Models\Article;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/articles/create', function () {
    return view('articles/create');
})->name('articles.create');

Route::post('/articles', function (Request $request) {
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
})->name('articles.store');

Route::get('articles', function(Request $request) {
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
})->name('articles.index');

Route::get('articles/{article}', function(Article $article) {
    return view('articles.show', ['article' => $article]);
})->name('articles.show');

Route::get('articles/{article}/edit', function(Article $article) {
    return view('articles.edit', ['article' => $article]);
})->name('articles.edit');

Route::put('articles/{article}/update', function(Request $request, Article $article) {
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
})->name('articles.update');