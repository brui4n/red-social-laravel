@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">💬 Mis Comentarios</h2>

    @if($comentarios->isEmpty())
        <p class="text-gray-500">Aún no has comentado en ninguna publicación.</p>
    @else
        <div class="space-y-4">
            @foreach($comentarios as $comentario)
                <div class="bg-white p-4 rounded-lg shadow border">
                    <p class="text-gray-800">"{{ $comentario->contenido }}"</p>
                    <a href="{{ route('posts.show', $comentario->post_id) }}" class="text-sm text-blue-600 hover:underline block mt-2">
                        Ver post: {{ $comentario->post->titulo ?? 'Publicación eliminada' }}
                    </a>
                    <p class="text-xs text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
