@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">📝 Mis Publicaciones</h2>

    @if($posts->isEmpty())
        <p class="text-gray-600">No has publicado nada aún.</p>
    @else
        <div class="space-y-6">
            @foreach ($posts as $post)
                <div class="bg-white rounded-xl shadow-md p-6 border">
                    <h4 class="text-xl font-semibold text-gray-800">{{ $post->titulo }}</h4>
                    <p class="text-gray-700 mt-2">{{ Str::limit($post->contenido, 150) }}</p>

                    @if($post->imagen)
                        <div class="my-3">
                            <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post"
                                 class="rounded-lg shadow max-w-xs">
                        </div>
                    @endif

                    @if($post->archivo)
                        <p class="text-blue-600 mt-2">
                            <a href="{{ asset('storage/' . $post->archivo) }}" target="_blank" download class="hover:underline">
                                📎 Descargar archivo
                            </a>
                        </p>
                    @endif

                    @if($post->codigo)
                        <div class="bg-gray-100 rounded p-3 mt-3 overflow-x-auto text-sm font-mono">
                            <pre><code>{{ $post->codigo }}</code></pre>
                        </div>
                        <small class="text-gray-500">Código en: {{ $post->lenguaje ?? 'No especificado' }}</small>
                    @endif

                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('posts.edit', $post->id) }}"
                           class="px-4 py-2 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            ✏️ Editar
                        </a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8">
        <a href="{{ route('inicio') }}"
           class="inline-block text-blue-600 hover:underline text-sm">
            ← Volver a la página principal
        </a>
    </div>
</div>
@endsection
