<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('글 수정') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('articles.update', ['article' => $article->id])}}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="body" class="block w-full mb-2 rounded" value="{{old('body') ?? $article->body}}">
                        @error('body')
                        <p class="text-xs text-red-500 mb-3">{{$message}}</p>
                        @enderror
                        <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>