@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">❤️ Publicaciones que me gustaron</h2>

    @if($posts->isEmpty())
        <p class="text-gray-500">Aún no has dado like a ninguna publicación.</p>
    @else
        <div class="space-y-4">
            @foreach($posts as $post)
                <div class="bg-white p-4 rounded-lg shadow border">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $post->titulo }}</h3>
                    <p class="text-gray-600">{{ Str::limit($post->contenido, 120) }}</p>
                    <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline">Ver publicación</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
