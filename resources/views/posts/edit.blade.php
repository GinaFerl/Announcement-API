<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-2">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="content">Content</label>
                                <textarea name="content" id="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
                            </div>
                            <div class="form-group my-2">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control" >
                                @if ($post->image)
                                    <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" width="100">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary my-3">Update</button>
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary my-3">Back</a>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>
