<div class="background-white border rounded mt-3 mb-3 p-3">
    <p><a href="{{route('articles.show', ['article' => $article->id])}}">{{$article->body}}</a></p>
    <p>
        <a href="{{route('profile', ['user' => $article->user->username])}}">{{$article->user->name}}</a>
    </p>
    <p class="text-xs text-gray-500">
        {{$article->created_at->diffForHumans()}}
        <span>| 댓글 {{$article->comments_count}} @if($article->comments_exists) (new) @endif</span>
    </p>
    
    <x-article-button-group :article=$article />
</div>