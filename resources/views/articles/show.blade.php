<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{$article->body}}

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
            </div>
            <!-- 댓글 끝 -->
        </div>
    </div>
</x-app-layout>