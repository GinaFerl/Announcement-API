<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1 class="my-3">{{ $post->title }}</h1>
                        @if ($post->image)
                            <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" width="300">
                        @endif
                        <p class="my-2">{!! $post->content !!}</p>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary my-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
