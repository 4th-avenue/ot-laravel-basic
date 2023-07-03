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
        <h1 class="text-2xl">글쓰기</h1>
        <form action="/articles" method="POST">
            @csrf
            <input type="text" class="block w-full mt-3 mb-2 rounded">
            <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
        </form>
    </div>
</body>
</html>