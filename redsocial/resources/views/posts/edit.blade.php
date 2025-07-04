@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">✏️ Editar Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white shadow-md rounded-xl p-6 border">
        @csrf
        @method('PUT')

        <div>
            <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $post->titulo) }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label for="contenido" class="block text-sm font-semibold text-gray-700 mb-1">Contenido</label>
            <textarea name="contenido" rows="4" required
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('contenido', $post->contenido) }}</textarea>
        </div>

        <div>
            <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1">Código (opcional)</label>
            <textarea name="codigo" rows="5"
                      class="w-full px-4 py-2 font-mono border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('codigo', $post->codigo) }}</textarea>
        </div>

        <div>
            <label for="lenguaje" class="block text-sm font-semibold text-gray-700 mb-1">Lenguaje</label>
            <select name="lenguaje" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Selecciona uno --</option>
                <option value="php" {{ $post->lenguaje == 'php' ? 'selected' : '' }}>PHP</option>
                <option value="javascript" {{ $post->lenguaje == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                <option value="python" {{ $post->lenguaje == 'python' ? 'selected' : '' }}>Python</option>
                <option value="html" {{ $post->lenguaje == 'html' ? 'selected' : '' }}>HTML</option>
            </select>
        </div>

        <div>
            <label for="imagen" class="block text-sm font-semibold text-gray-700 mb-1">Imagen (opcional)</label>
            <input type="file" name="imagen" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
            <label for="archivo" class="block text-sm font-semibold text-gray-700 mb-1">Archivo (opcional)</label>
            <input type="file" name="archivo" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                💾 Actualizar
            </button>

            <a href="{{ route('inicio') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
