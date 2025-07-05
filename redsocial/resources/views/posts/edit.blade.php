@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">✏️ Editar Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 space-y-6">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div>
            <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $post->titulo) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">
        </div>

        {{-- Contenido --}}
        <div>
            <label for="contenido" class="block text-sm font-semibold text-gray-700 mb-1">Contenido</label>
            <textarea name="contenido" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">{{ old('contenido', $post->contenido) }}</textarea>
        </div>

        {{-- Código --}}
        <div>
            <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1">Código (opcional)</label>
            <textarea name="codigo" rows="5"
                      class="w-full px-4 py-2 font-mono text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">{{ old('codigo', $post->codigo) }}</textarea>
        </div>

        {{-- Lenguaje --}}
        <div>
            <label for="lenguaje" class="block text-sm font-semibold text-gray-700 mb-1">Lenguaje</label>
            <select name="lenguaje"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">
                <option value="">-- Selecciona uno --</option>
                <option value="php" {{ $post->lenguaje == 'php' ? 'selected' : '' }}>PHP</option>
                <option value="javascript" {{ $post->lenguaje == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                <option value="python" {{ $post->lenguaje == 'python' ? 'selected' : '' }}>Python</option>
                <option value="html" {{ $post->lenguaje == 'html' ? 'selected' : '' }}>HTML</option>
                <option value="css" {{ $post->lenguaje == 'css' ? 'selected' : '' }}>CSS</option>
                <option value="java" {{ $post->lenguaje == 'java' ? 'selected' : '' }}>Java</option>
            </select>
        </div>

        {{-- Etiquetas --}}
        <div>
            <label for="tags" class="block text-sm font-semibold text-gray-700 mb-1">Etiquetas</label>
            <select name="tags[]" id="tags" multiple
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags ?? []) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            @error('tags')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Ctrl (Cmd) + clic para seleccionar varias.</p>
        </div>

        {{-- Imagen --}}
        <div>
            <label for="imagen" class="block text-sm font-semibold text-gray-700 mb-1">Imagen (opcional)</label>
            <input type="file" name="imagen"
                   class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer file:bg-blue-50 file:border-none file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        {{-- Archivo --}}
        <div>
            <label for="archivo" class="block text-sm font-semibold text-gray-700 mb-1">Archivo adjunto (opcional)</label>
            <input type="file" name="archivo"
                   class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer file:bg-green-50 file:border-none file:px-4 file:py-2 file:text-green-700 hover:file:bg-green-100">
        </div>

        {{-- Botones --}}
        <div class="flex items-center justify-between pt-4 border-t">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                💾 Guardar cambios
            </button>
            <a href="{{ route('inicio') }}"
               class="text-red-600 hover:underline text-sm font-medium">Cancelar</a>
        </div>
    </form>
</div>
@endsection
