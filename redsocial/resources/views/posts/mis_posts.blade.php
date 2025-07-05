@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">📝 Mis Publicaciones</h2>

    @if($posts->isEmpty())
        <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 px-6 py-4 rounded text-center">
            Aún no has creado ningún post. ¡Publica algo genial! 🚀
        </div>
    @else
        <div class="space-y-8">
            @foreach ($posts as $post)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6">
                    {{-- Título --}}
                    <h4 class="text-2xl font-semibold text-gray-800">{{ $post->titulo }}</h4>
                    
                    {{-- Contenido --}}
                    <p class="text-gray-700 mt-2">{{ Str::limit($post->contenido, 150) }}</p>

                    {{-- Imagen --}}
                    @if($post->imagen)
                        <div class="my-4">
                            <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del post"
                                 class="rounded-xl shadow-md w-full max-h-64 object-contain border">
                        </div>
                    @endif

                    {{-- Archivo --}}
                    @if($post->archivo)
                        <p class="text-blue-600 mt-2">
                            <a href="{{ asset('storage/' . $post->archivo) }}" target="_blank" download
                               class="inline-flex items-center gap-2 hover:underline font-medium">
                                📎 Descargar archivo
                            </a>
                        </p>
                    @endif

                    {{-- Código --}}
                    @if($post->codigo)
                        <div class="bg-gray-100 rounded-lg p-4 mt-4 overflow-x-auto text-sm font-mono border">
                            <pre><code>{{ $post->codigo }}</code></pre>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Lenguaje: <span class="font-medium">{{ $post->lenguaje ?? 'No especificado' }}</span></p>
                    @endif

                    {{-- Botones --}}
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="{{ route('posts.edit', $post->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                            ✏️ Editar
                        </a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>

            @endforeach
        </div>
    @endif

    <div class="mt-10 text-center">
        <a href="{{ route('inicio') }}"
           class="inline-block text-blue-600 hover:underline text-sm font-medium">
            ← Volver a la página principal
        </a>
    </div>
</div>
@endsection
