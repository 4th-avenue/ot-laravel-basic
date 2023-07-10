<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('글 목록') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach($articles as $article)
                        <div class="background-white border rounded mt-3 mb-3 p-3">
                            <p><a href="{{route('articles.show', ['article' => $article->id])}}">{{$article->body}}</a></p>
                            <p>{{$article->user->name}}</p>
                            <p>{{$article->created_at->diffForHumans()}}</p>
                            
                            <x-article-button-group :article=$article />
                        </div>
                    @endforeach
                    <div class="container p-5">
                        {{$articles->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>