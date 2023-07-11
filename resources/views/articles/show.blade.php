<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>{{$article->body}}</p>
                    <p>{{$article->user->name}}</p>
                    <p class="text-xs text-gray-500">
                        {{$article->created_at->diffForHumans()}}
                        <span>| 댓글 {{$article->comments_count}}</span>
                    </p>

                    <x-article-button-group :article=$article />
                </div>
            </div>
            <!-- 댓글 시작 -->
            <div class="pt-6">
                <form action="{{route('comments.store')}}" method="POST" class="flex">
                    @csrf
                    <input type="hidden" name="article_id" value="{{$article->id}}" />
                    <x-text-input name="body" class="mr-2" />
                    @error('body')
                    <x-input-error :messages=$messages />
                    @enderror
                    <x-primary-button>댓글</x-primary-button>
                </form>
                <div class="mt-4">
                    @foreach($article->comments as $comment)
                    <div class="mt-4">
                        <p>{{$comment->body}}</p>
                        <p class="text-xs text-gray-500">{{$comment->user->name}} {{$comment->created_at->diffForHumans()}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- 댓글 끝 -->
        </div>
    </div>
</x-app-layout>