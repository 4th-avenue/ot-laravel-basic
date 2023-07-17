<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('글 목록') }}
            </h2>
            <div>
                <form method="GET" action="{{route('articles.index')}}">
                    <input type="text" name="q" class="rounded border-gray-200" placeholder="{{$q ?? '검색'}}" />
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach($articles as $article)
                        <x-list-article-item :article=$article />
                    @endforeach
                    <div class="container p-5">
                        {{$articles->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>