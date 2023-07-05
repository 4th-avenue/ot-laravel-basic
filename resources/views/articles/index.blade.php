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
                <p>{{$article->body}}</p>
                <p>{{$article->created_at}}</p>
            </div>
        @endforeach
    </div>

    <div class="container p-5">
        {{$articles->links()}}
    </div>
</body>
</html>