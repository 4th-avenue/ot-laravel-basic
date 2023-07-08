<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container p-5">
        <h1 class="text-2xl">글 목록</h1>
        @foreach($articles as $article)
            <div class="background-white border rounded mt-3 mb-3 p-3">
                <p><a href="{{route('articles.show', ['article' => $article->id])}}">{{$article->body}}</a></p>
                <p>{{$article->user->name}}</p>
                <p>{{$article->created_at->diffForHumans()}}</p>
                <div class="flex flex-row mt-2">
                    <p class="mr-1"><a href="{{route('articles.edit', ['article' => $article->id])}}" class="button rounded border bg-blue-500 px-2 py-1 text-xs text-white">수정</a></p>
                    <form action="{{route('articles.destroy', ['article' => $article])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="py-1 px-3 bg-red-500 text-white rounded text-xs">삭제</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="container p-5">
        {{$articles->links()}}
    </div>
</body>
</html>